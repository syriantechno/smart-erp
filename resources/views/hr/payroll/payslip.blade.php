<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip - {{ $payroll->employee->full_name }} - {{ $payroll->period }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            background: #fff;
        }
        .payslip {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            border: 2px solid #303030;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #303030;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            color: #303030;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 16px;
            color: #666;
            font-weight: normal;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .info-section .left, .info-section .right {
            width: 48%;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .info-label {
            width: 120px;
            color: #666;
        }
        .info-value {
            font-weight: 600;
        }
        .earnings-deductions {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .earnings, .deductions {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        .section-header {
            padding: 10px 15px;
            font-weight: 600;
            color: #fff;
        }
        .earnings .section-header {
            background: #28a745;
        }
        .deductions .section-header {
            background: #dc3545;
        }
        .section-body {
            padding: 15px;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dotted #ddd;
        }
        .item-row:last-child {
            border-bottom: none;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            font-weight: 600;
            background: #f8f9fa;
            border-top: 2px solid #ddd;
        }
        .net-salary {
            text-align: center;
            padding: 20px;
            background: #303030;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .net-salary h3 {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 5px;
        }
        .net-salary .amount {
            font-size: 32px;
            font-weight: 700;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .signature {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 5px;
        }
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            .payslip {
                border: none;
                margin: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="payslip">
        <div class="header">
            <h1>{{ $payroll->employee->company->name ?? config('app.name') }}</h1>
            <h2>PAYSLIP</h2>
            <p>{{ $payroll->period }}</p>
        </div>

        <div class="info-section">
            <div class="left">
                <div class="info-row">
                    <span class="info-label">Employee Name:</span>
                    <span class="info-value">{{ $payroll->employee->full_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Employee ID:</span>
                    <span class="info-value">{{ $payroll->employee->employee_id ?? $payroll->employee->id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Department:</span>
                    <span class="info-value">{{ $payroll->employee->department->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Position:</span>
                    <span class="info-value">{{ $payroll->employee->position ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="right">
                <div class="info-row">
                    <span class="info-label">Payslip No:</span>
                    <span class="info-value">{{ $payroll->code }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pay Period:</span>
                    <span class="info-value">{{ $payroll->period }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Working Days:</span>
                    <span class="info-value">{{ $payroll->actual_working_days }} / {{ $payroll->working_days }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Date:</span>
                    <span class="info-value">{{ $payroll->payment_date?->format('d M Y') ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="earnings-deductions">
            <div class="earnings">
                <div class="section-header">EARNINGS</div>
                <div class="section-body">
                    <div class="item-row">
                        <span>Basic Salary</span>
                        <span>{{ number_format($payroll->basic_salary, 2) }}</span>
                    </div>
                    @if($payroll->overtime_hours > 0)
                    <div class="item-row">
                        <span>Overtime ({{ $payroll->overtime_hours }}h × {{ $payroll->overtime_multiplier }}x)</span>
                        <span>{{ number_format($payroll->overtime_amount, 2) }}</span>
                    </div>
                    @endif
                    @if($payroll->weekend_overtime_hours > 0)
                    <div class="item-row">
                        <span>Weekend OT ({{ $payroll->weekend_overtime_hours }}h × {{ $payroll->weekend_overtime_multiplier }}x)</span>
                        <span>{{ number_format($payroll->weekend_overtime_amount, 2) }}</span>
                    </div>
                    @endif
                    @if($payroll->bonuses > 0)
                    <div class="item-row">
                        <span>Bonuses</span>
                        <span>{{ number_format($payroll->bonuses, 2) }}</span>
                    </div>
                    @endif
                </div>
                <div class="total-row">
                    <span>Total Earnings</span>
                    <span>{{ number_format($payroll->gross_salary, 2) }}</span>
                </div>
            </div>

            <div class="deductions">
                <div class="section-header">DEDUCTIONS</div>
                <div class="section-body">
                    @if($payroll->absent_days > 0)
                    <div class="item-row">
                        <span>Absent ({{ $payroll->absent_days }} days)</span>
                        <span>{{ number_format($payroll->absent_deduction, 2) }}</span>
                    </div>
                    @endif
                    @if($payroll->half_days > 0)
                    <div class="item-row">
                        <span>Half Days ({{ $payroll->half_days }})</span>
                        <span>{{ number_format($payroll->half_day_deduction, 2) }}</span>
                    </div>
                    @endif
                    @if($payroll->late_deduction > 0)
                    <div class="item-row">
                        <span>Late Deduction</span>
                        <span>{{ number_format($payroll->late_deduction, 2) }}</span>
                    </div>
                    @endif
                    @if($payroll->deductions > 0)
                    <div class="item-row">
                        <span>Other Deductions</span>
                        <span>{{ number_format($payroll->deductions, 2) }}</span>
                    </div>
                    @endif
                    @if($payroll->absent_days == 0 && $payroll->half_days == 0 && $payroll->deductions == 0)
                    <div class="item-row">
                        <span>No Deductions</span>
                        <span>0.00</span>
                    </div>
                    @endif
                </div>
                <div class="total-row">
                    <span>Total Deductions</span>
                    <span>{{ number_format($payroll->absent_deduction + $payroll->half_day_deduction + $payroll->late_deduction + $payroll->deductions, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="net-salary">
            <h3>NET SALARY</h3>
            <div class="amount">{{ number_format($payroll->net_salary, 2) }} SAR</div>
        </div>

        <div class="footer">
            <div class="signature">
                <div class="signature-line">Employee Signature</div>
            </div>
            <div class="signature">
                <div class="signature-line">HR Manager</div>
            </div>
            <div class="signature">
                <div class="signature-line">Finance Manager</div>
            </div>
        </div>

        <p style="text-align: center; margin-top: 20px; font-size: 10px; color: #999;">
            This is a computer-generated document. Generated on {{ now()->format('d M Y H:i') }}
        </p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
