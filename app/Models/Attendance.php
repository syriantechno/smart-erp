<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'shift_id',
        'attendance_date',
        'status',
        'notes',
        'check_in',
        'check_out',
        'working_hours',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in' => 'datetime:H:i',
        'check_out' => 'datetime:H:i',
        'working_hours' => 'decimal:2',
    ];

    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    // Accessors
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'present' => 'success',
            'absent' => 'danger',
            'vacation' => 'info',
            'travel' => 'warning',
            'half_day' => 'secondary',
            'holiday' => 'primary',
            default => 'secondary'
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match($this->status) {
            'present' => 'check-circle',
            'absent' => 'x-circle',
            'vacation' => 'sun',
            'travel' => 'plane',
            'half_day' => 'clock',
            'holiday' => 'calendar',
            default => 'circle'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'present' => 'حاضر',
            'absent' => 'غائب',
            'vacation' => 'إجازة',
            'travel' => 'سفر',
            'half_day' => 'نصف يوم',
            'holiday' => 'عطلة',
            default => 'غير محدد'
        };
    }

    // Scopes
    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('attendance_date', $year)
                    ->whereMonth('attendance_date', $month);
    }

    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    // Methods
    public static function getMonthlyStats($employeeId, $year, $month)
    {
        $query = self::forEmployee($employeeId)->forMonth($year, $month);

        return [
            'total_days' => $query->count(),
            'present_days' => (clone $query)->where('status', 'present')->count(),
            'absent_days' => (clone $query)->where('status', 'absent')->count(),
            'vacation_days' => (clone $query)->where('status', 'vacation')->count(),
            'half_days' => (clone $query)->where('status', 'half_day')->count(),
            'travel_days' => (clone $query)->where('status', 'travel')->count(),
            'holiday_days' => (clone $query)->where('status', 'holiday')->count(),
        ];
    }

    /**
     * حساب حالة الحضور تلقائياً
     */
    public function calculateAttendanceStatus()
    {
        if (!$this->check_in || !$this->check_out) {
            return 'absent';
        }

        $workingHours = $this->working_hours ?? 0;
        $halfDayHours = setting('attendance.half_day_hours', 4);
        $minimumHours = setting('attendance.minimum_working_hours', 6);

        // إذا كان العمل أقل من الحد الأدنى
        if ($workingHours < $minimumHours) {
            return 'absent';
        }

        // إذا كان العمل أقل من ساعات نصف اليوم
        if ($workingHours < $halfDayHours) {
            return 'half_day';
        }

        return 'present';
    }

    /**
     * التحقق من التأخير
     */
    public function isLate()
    {
        if (!$this->shift || !$this->check_in) {
            return false;
        }

        $shiftStartTime = \Carbon\Carbon::createFromFormat('H:i:s', $this->shift->start_time);
        $checkInTime = \Carbon\Carbon::createFromFormat('H:i:s', $this->check_in->format('H:i:s'));

        $gracePeriodMinutes = setting('attendance.grace_period_minutes', 15);
        $allowedTime = $shiftStartTime->copy()->addMinutes($gracePeriodMinutes);

        return $checkInTime->greaterThan($allowedTime);
    }

    /**
     * التحقق من المغادرة المبكرة
     */
    public function isEarlyDeparture()
    {
        if (!$this->shift || !$this->check_out) {
            return false;
        }

        $shiftEndTime = \Carbon\Carbon::createFromFormat('H:i:s', $this->shift->end_time);
        $checkOutTime = \Carbon\Carbon::createFromFormat('H:i:s', $this->check_out->format('H:i:s'));

        return $checkOutTime->lessThan($shiftEndTime);
    }

    /**
     * حساب ساعات العمل
     */
    public function calculateWorkingHours()
    {
        if (!$this->check_in || !$this->check_out) {
            return 0;
        }

        $checkIn = \Carbon\Carbon::createFromFormat('H:i:s', $this->check_in->format('H:i:s'));
        $checkOut = \Carbon\Carbon::createFromFormat('H:i:s', $this->check_out->format('H:i:s'));

        // التأكد من أن وقت الخروج بعد وقت الدخول
        if ($checkOut->lessThanOrEqualTo($checkIn)) {
            return 0;
        }

        return $checkIn->diffInMinutes($checkOut) / 60; // تحويل إلى ساعات
    }

    /**
     * التحقق من أن التاريخ يوم عطلة
     */
    public static function isHoliday($date)
    {
        $holidays = setting('attendance.holidays', '');
        if (empty($holidays)) {
            return false;
        }

        $holidaysArray = array_map('trim', explode("\n", $holidays));
        return in_array($date->format('Y-m-d'), $holidaysArray);
    }

    /**
     * التحقق من أن التاريخ يوم عطلة نهاية أسبوع
     */
    public static function isWeekend($date)
    {
        $weekendDays = setting('attendance.weekend_days', '5,6');
        $weekendDaysArray = array_map('intval', explode(',', $weekendDays));

        return in_array($date->dayOfWeek, $weekendDaysArray);
    }

    /**
     * إنشاء سجل حضور تلقائي
     */
    public static function createAutoAttendance($employeeId, $date, $shiftId = null)
    {
        $existingAttendance = self::where('employee_id', $employeeId)
            ->where('attendance_date', $date)
            ->first();

        if ($existingAttendance) {
            return $existingAttendance;
        }

        // التحقق من العطل
        $carbonDate = \Carbon\Carbon::parse($date);
        if (self::isHoliday($carbonDate) || self::isWeekend($carbonDate)) {
            return self::create([
                'employee_id' => $employeeId,
                'shift_id' => $shiftId,
                'attendance_date' => $date,
                'status' => self::isHoliday($carbonDate) ? 'holiday' : 'weekend',
            ]);
        }

        // إنشاء سجل غياب للأيام العادية
        return self::create([
            'employee_id' => $employeeId,
            'shift_id' => $shiftId,
            'attendance_date' => $date,
            'status' => 'absent',
        ]);
    }
}
