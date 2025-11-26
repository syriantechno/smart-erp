<!-- Extension Request Modal -->
<x-base.dialog id="extension-request-modal">
    <x-base.dialog.panel>
        <x-base.dialog.title class="bg-gradient-to-r from-primary to-primary/70 text-white">
            <h2 class="text-lg font-semibold flex items-center gap-2">
                <x-base.lucide icon="clock" class="w-5 h-5" />
                طلب تمديد الوقت
            </h2>
            <button type="button" data-tw-dismiss="modal" class="text-white/80 hover:text-white transition-colors">
                <x-base.lucide icon="x" class="w-5 h-5" />
            </button>
        </x-base.dialog.title>
        <form id="extension-request-form">
            <x-base.dialog.description class="p-6">
                <input type="hidden" id="extension-task-id" name="task_id">
                
                <!-- Current Due Date Info -->
                <div class="mb-6 p-4 bg-slate-50 dark:bg-darkmode-600 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                            <x-base.lucide icon="calendar" class="w-6 h-6 text-primary" />
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">تاريخ الاستحقاق الحالي</p>
                            <p id="current-due-date-display" class="text-lg font-semibold text-slate-800 dark:text-white">-</p>
                        </div>
                    </div>
                </div>

                <!-- Requested Due Date -->
                <div class="mb-6">
                    <x-base.form-label for="requested_due_date">تاريخ الاستحقاق المطلوب <span class="text-red-500">*</span></x-base.form-label>
                    <div class="relative w-full">
                        <div class="absolute flex h-full w-10 items-center justify-center rounded-r border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                            <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                        </div>
                        <x-base.litepicker
                            id="requested_due_date"
                            name="requested_due_date"
                            class="pr-12"
                            data-single-mode="true"
                            data-format="YYYY-MM-DD"
                            required
                        />
                    </div>
                    <p class="text-xs text-slate-500 mt-1">يجب أن يكون التاريخ المطلوب بعد اليوم</p>
                </div>

                <!-- Extension Days Preview -->
                <div id="extension-days-preview" class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl hidden">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <x-base.lucide icon="plus-circle" class="w-5 h-5 text-blue-600" />
                        </div>
                        <div>
                            <p class="text-xs text-blue-600">أيام التمديد</p>
                            <p id="extension-days-count" class="text-lg font-bold text-blue-700">0 يوم</p>
                        </div>
                    </div>
                </div>

                <!-- Reason -->
                <div class="mb-4">
                    <x-base.form-label for="extension_reason">سبب طلب التمديد <span class="text-red-500">*</span></x-base.form-label>
                    <x-base.form-textarea 
                        id="extension_reason" 
                        name="reason" 
                        rows="4" 
                        placeholder="يرجى توضيح سبب طلب تمديد الوقت للمهمة..."
                        class="w-full"
                        required
                    ></x-base.form-textarea>
                    <p class="text-xs text-slate-500 mt-1">يجب أن يكون السبب 10 أحرف على الأقل</p>
                </div>

                <!-- Pending Request Warning -->
                <div id="pending-request-warning" class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl hidden">
                    <div class="flex items-start gap-3">
                        <x-base.lucide icon="alert-triangle" class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" />
                        <div>
                            <p class="text-sm font-semibold text-yellow-700">يوجد طلب تمديد قيد الانتظار</p>
                            <p class="text-xs text-yellow-600 mt-1">لا يمكن إرسال طلب جديد حتى تتم مراجعة الطلب الحالي</p>
                        </div>
                    </div>
                </div>
            </x-base.dialog.description>
            <x-base.dialog.footer class="bg-slate-50 dark:bg-darkmode-600">
                <button type="button" data-tw-dismiss="modal" class="btn-royal btn-royal--outline">
                    إلغاء
                </button>
                <button type="submit" id="submit-extension-btn" class="btn-royal btn-royal--gold">
                    <x-base.lucide icon="send" class="w-4 h-4 ml-2" />
                    إرسال الطلب
                </button>
            </x-base.dialog.footer>
        </form>
    </x-base.dialog.panel>
</x-base.dialog>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const extensionForm = document.getElementById('extension-request-form');
    const requestedDateInput = document.getElementById('requested_due_date');
    const extensionDaysPreview = document.getElementById('extension-days-preview');
    const extensionDaysCount = document.getElementById('extension-days-count');
    let currentDueDate = null;

    // Calculate extension days when date changes
    if (requestedDateInput) {
        requestedDateInput.addEventListener('change', function() {
            if (currentDueDate && this.value) {
                const requested = new Date(this.value);
                const current = new Date(currentDueDate);
                const diffTime = requested - current;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (diffDays > 0) {
                    extensionDaysCount.textContent = diffDays + ' يوم';
                    extensionDaysPreview.classList.remove('hidden');
                } else {
                    extensionDaysPreview.classList.add('hidden');
                }
            }
        });
    }

    // Open extension request modal
    window.openExtensionRequestModal = function(taskId, dueDate, hasPendingRequest) {
        document.getElementById('extension-task-id').value = taskId;
        currentDueDate = dueDate;
        
        // Format and display current due date
        const dateObj = new Date(dueDate);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('current-due-date-display').textContent = dateObj.toLocaleDateString('ar-SA', options);
        
        // Reset form
        extensionForm.reset();
        extensionDaysPreview.classList.add('hidden');
        
        // Check for pending request
        const pendingWarning = document.getElementById('pending-request-warning');
        const submitBtn = document.getElementById('submit-extension-btn');
        
        if (hasPendingRequest) {
            pendingWarning.classList.remove('hidden');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            pendingWarning.classList.add('hidden');
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        
        const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('extension-request-modal'));
        modal.show();
    };

    // Submit extension request
    if (extensionForm) {
        extensionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const taskId = document.getElementById('extension-task-id').value;
            const requestedDate = document.getElementById('requested_due_date').value;
            const reason = document.getElementById('extension_reason').value;
            
            if (!requestedDate) {
                window.showWarning && showWarning('يرجى تحديد تاريخ الاستحقاق المطلوب');
                return;
            }
            
            if (!reason || reason.length < 10) {
                window.showWarning && showWarning('يجب أن يكون السبب 10 أحرف على الأقل');
                return;
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/tasks/${taskId}/extension-requests`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    requested_due_date: requestedDate,
                    reason: reason
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.showSuccess && showSuccess(data.message);
                    tailwind.Modal.getOrCreateInstance(document.getElementById('extension-request-modal')).hide();
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    window.showError && showError(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showError && showError('حدث خطأ أثناء إرسال الطلب');
            });
        });
    }
});
</script>
