{{-- Edit Invoice Modal --}}
<div id="edit-invoice-modal" class="fixed inset-0 z-[99998] hidden items-center justify-center bg-slate-900/60" aria-hidden="true">
    <div class="modal-dialog modal-xl max-w-6xl w-full mx-4">
        <div class="modal-content bg-white dark:bg-darkmode-600 rounded-lg shadow-lg max-h-[95vh] flex flex-col">
            <div class="modal-header flex items-center justify-between px-6 py-4 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-semibold text-lg mr-auto flex items-center gap-2">
                    <x-base.lucide icon="edit" class="w-5 h-5 text-primary" />
                    تعديل الفاتورة
                </h2>
                <button type="button" class="text-slate-400 hover:text-slate-600" onclick="closeEditInvoiceModal()">
                    <x-base.lucide icon="x" class="w-6 h-6" />
                </button>
            </div>

            <div class="modal-body p-6 overflow-y-auto">
                <form id="edit-invoice-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Invoice Details --}}
                    <div class="grid grid-cols-12 gap-6 mb-6">
                        <div class="col-span-12 md:col-span-6">
                            <x-base.form-label for="edit-customer_id">العميل <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="edit-customer_id" name="customer_id" required>
                                <option value="">اختر العميل</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->code }} - {{ $customer->name }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <div class="col-span-12 md:col-span-3">
                            <x-base.form-label for="edit-type">نوع الفاتورة <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="edit-type" name="type" required>
                                <option value="sales">مبيعات</option>
                                <option value="purchase">مشتريات</option>
                            </x-base.form-select>
                        </div>

                        <div class="col-span-12 md:col-span-3">
                            <x-base.form-label for="edit-invoice_date">تاريخ الفاتورة <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input id="edit-invoice_date" name="invoice_date" type="date" required />
                        </div>

                        <div class="col-span-12 md:col-span-4">
                            <x-base.form-label for="edit-due_date">تاريخ الاستحقاق</x-base.form-label>
                            <x-base.form-input id="edit-due_date" name="due_date" type="date" />
                        </div>

                        <div class="col-span-12 md:col-span-4">
                            <x-base.form-label for="edit-reference">المرجع</x-base.form-label>
                            <x-base.form-input id="edit-reference" name="reference" type="text" placeholder="رقم المرجع" />
                        </div>

                        <div class="col-span-12 md:col-span-4">
                            <x-base.form-label for="edit-status">الحالة</x-base.form-label>
                            <x-base.form-select id="edit-status" name="status">
                                <option value="pending">معلقة</option>
                                <option value="paid">مدفوعة</option>
                                <option value="overdue">متأخرة</option>
                                <option value="cancelled">ملغاة</option>
                            </x-base.form-select>
                        </div>

                        <div class="col-span-12">
                            <x-base.form-label for="edit-notes">ملاحظات</x-base.form-label>
                            <x-base.form-textarea id="edit-notes" name="notes" rows="3" placeholder="أي ملاحظات إضافية"></x-base.form-textarea>
                        </div>
                    </div>

                    {{-- Invoice Lines --}}
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">بنود الفاتورة</h3>
                            <button type="button" class="btn-royal btn-royal--outline btn-royal--sm" onclick="addEditInvoiceLine()">
                                <x-base.lucide icon="plus" class="w-4 h-4 mr-1" /> إضافة بند
                            </button>
                        </div>

                        <div id="edit-invoice-lines" class="space-y-4">
                            {{-- Lines will be loaded dynamically --}}
                        </div>
                    </div>

                    {{-- Totals --}}
                    <div class="bg-slate-50 rounded-lg p-6 border">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center">
                                <div class="text-sm text-slate-600">المجموع الفرعي</div>
                                <div id="edit-subtotal" class="text-xl font-semibold text-slate-800">0.00</div>
                            </div>
                            <div class="text-center">
                                <div class="text-sm text-slate-600">الضريبة ({{ $taxRate ?? 0 }}%)</div>
                                <div id="edit-tax-amount" class="text-xl font-semibold text-slate-800">0.00</div>
                            </div>
                            <div class="text-center">
                                <div class="text-sm text-slate-600">خصم</div>
                                <div id="edit-discount-amount" class="text-xl font-semibold text-slate-800">0.00</div>
                            </div>
                            <div class="text-center">
                                <div class="text-sm text-slate-600">الإجمالي</div>
                                <div id="edit-total-amount" class="text-2xl font-bold text-primary">0.00</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200/60 dark:border-darkmode-400">
                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm px-6" onclick="closeEditInvoiceModal()">
                    <x-base.lucide icon="x" class="w-4 h-4 mr-2" />
                    إلغاء
                </button>
                <button type="button" id="update-invoice-btn" class="btn-royal btn-royal--gold btn-royal--sm px-6" onclick="updateInvoice()">
                    <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                    تحديث الفاتورة
                </button>
            </div>
        </div>
    </div>
</div>
