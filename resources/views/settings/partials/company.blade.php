@php 
    $companyCollection = $companies ?? collect(); 
@endphp

<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                {{-- Title --}}
                <h2 class="flex items-center gap-2 text-xl font-semibold text-slate-700 mb-5">
                    <x-base.lucide icon="building-2" class="w-6 h-6 text-primary" />
                    <span>إدارة الشركات</span>
                </h2>

                {{-- Filters & Actions Toolbar --}}
                <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                    <form id="companies-filter-form" class="w-full sm:mr-auto xl:flex">
                        <div class="items-center sm:mr-4 sm:flex">
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial text-slate-500">الحقل</label>
                            <x-base.form-select id="filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                <option value="all">الكل</option>
                                <option value="name">اسم الشركة</option>
                                <option value="commercial">السجل التجاري</option>
                                <option value="tax">الرقم الضريبي</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial text-slate-500">القيمة</label>
                            <x-base.form-input id="filter-value" type="text" placeholder="بحث..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial text-slate-500">الحالة</label>
                            <x-base.form-select id="filter-status" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="">الكل</option>
                                <option value="active">نشطة</option>
                                <option value="inactive">غير نشطة</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                            <x-base.tippy content="تطبيق الفلتر" placement="top">
                                <button id="filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    بحث
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="إعادة تعيين" placement="top">
                                <button id="filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    إعادة
                                </button>
                            </x-base.tippy>
                        </div>
                    </form>

                    <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                        <x-base.tippy content="طباعة" placement="bottom">
                            <button type="button" class="btn-royal btn-royal--outline btn-royal--sm group text-royalDark">
                                <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="تصدير Excel" placement="bottom">
                            <button id="export-excel" type="button" class="btn-royal btn-royal--outline btn-royal--sm group text-royalDark">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="تحديث" placement="bottom">
                            <button id="refresh-table" type="button" class="btn-royal btn-royal--outline btn-royal--sm group text-royalDark" onclick="location.reload()">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        {{-- Add Button --}}
                        <x-base.tippy content="إضافة شركة جديدة" placement="bottom">
                            <button type="button" class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group" data-tw-toggle="modal" data-tw-target="#create-company-modal">
                                <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                <span class="hidden sm:inline">إضافة</span>
                            </button>
                        </x-base.tippy>
                    </div>
                </div>

                <div class="overflow-x-auto sm:overflow-visible mt-5" data-erp-table-wrapper>
                    <table id="companies-table" data-tw-merge data-erp-table class="w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center w-12">#</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">الشركة</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">السجل / الضريبي</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">التواصل</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">الموقع</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">الحالة</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companyCollection as $companyRow)
                            <tr class="intro-x" data-id="{{ $companyRow->id }}">
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center text-slate-500">
                                    {{ $loop->iteration }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <div class="flex items-center gap-3">
                                        @if($companyRow->logo)
                                            <img src="{{ asset('storage/' . $companyRow->logo) }}" class="w-10 h-10 rounded-lg object-cover shadow" alt="{{ $companyRow->name }}">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center">
                                                <x-base.lucide icon="building-2" class="w-5 h-5 text-slate-400" />
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-slate-800 dark:text-slate-100">{{ $companyRow->name }}</div>
                                            @if($companyRow->website)
                                                <a href="{{ $companyRow->website }}" target="_blank" class="text-xs text-blue-500 hover:underline">{{ $companyRow->website }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <div class="text-sm">
                                        <div class="flex items-center gap-1">
                                            <span class="text-xs text-slate-400">سجل:</span>
                                            <span class="font-medium">{{ $companyRow->commercial_registration ?? '—' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="text-xs text-slate-400">ضريبي:</span>
                                            <span class="font-medium">{{ $companyRow->tax_number ?? '—' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <div class="text-sm">
                                        @if($companyRow->phone)
                                            <div class="flex items-center gap-1">
                                                <x-base.lucide icon="phone" class="w-3 h-3 text-slate-400" />
                                                <span>{{ $companyRow->phone }}</span>
                                            </div>
                                        @endif
                                        @if($companyRow->email)
                                            <div class="flex items-center gap-1">
                                                <x-base.lucide icon="mail" class="w-3 h-3 text-slate-400" />
                                                <span class="text-xs">{{ $companyRow->email }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <div class="text-sm">
                                        <div>{{ $companyRow->city ?? '' }}{{ $companyRow->city && $companyRow->country ? '، ' : '' }}{{ $companyRow->country ?? '—' }}</div>
                                        @if($companyRow->postal_code)
                                            <div class="text-xs text-slate-400">{{ $companyRow->postal_code }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                                    @if($companyRow->is_active)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-600 rounded text-xs font-semibold">
                                            <x-base.lucide icon="check-circle" class="w-3 h-3" /> نشطة
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 text-slate-500 rounded text-xs font-semibold">
                                            <x-base.lucide icon="pause-circle" class="w-3 h-3" /> غير نشطة
                                        </span>
                                    @endif
                                </td>
                                @php
                                    $companyData = json_encode([
                                        'id' => $companyRow->id,
                                        'name' => $companyRow->name,
                                        'phone' => $companyRow->phone,
                                        'email' => $companyRow->email,
                                        'website' => $companyRow->website,
                                        'commercial_registration' => $companyRow->commercial_registration,
                                        'tax_number' => $companyRow->tax_number,
                                        'country' => $companyRow->country,
                                        'city' => $companyRow->city,
                                        'postal_code' => $companyRow->postal_code,
                                        'address' => $companyRow->address,
                                        'is_active' => $companyRow->is_active,
                                    ]);
                                @endphp
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                                    <div class="flex justify-center gap-1">
                                        <button class="btn-edit p-1.5 rounded hover:bg-blue-50 text-blue-600 hover:text-blue-800 transition-colors" 
                                                data-id="{{ $companyRow->id }}"
                                                data-company="{{ $companyData }}"
                                                title="تعديل">
                                            <x-base.lucide icon="edit" class="w-4 h-4" />
                                        </button>
                                        <button class="btn-delete p-1.5 rounded hover:bg-red-50 text-slate-500 hover:text-red-600 transition-colors" 
                                                data-id="{{ $companyRow->id }}" 
                                                data-name="{{ $companyRow->name }}" 
                                                title="حذف">
                                            <x-base.lucide icon="trash-2" class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                                    <x-base.lucide icon="building" class="w-12 h-12 mx-auto mb-2 opacity-50" />
                                    لا توجد شركات مسجلة
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-base.preview-component>
    </div>
</div>

{{-- Create Company Modal (Unified Theme) --}}
<x-modal.form id="create-company-modal" title="إضافة شركة جديدة">
    <form id="create-company-form" action="{{ route('settings.company.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-12 gap-4 gap-y-4">
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-name">اسم الشركة <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="create-name" name="name" type="text" placeholder="أدخل اسم الشركة" class="w-full" required />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-phone">الهاتف</x-base.form-label>
                <x-base.form-input id="create-phone" name="phone" type="tel" placeholder="رقم الهاتف" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-email">البريد الإلكتروني</x-base.form-label>
                <x-base.form-input id="create-email" name="email" type="email" placeholder="email@example.com" class="w-full" />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-website">الموقع الإلكتروني</x-base.form-label>
                <x-base.form-input id="create-website" name="website" type="url" placeholder="https://example.com" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-commercial">السجل التجاري</x-base.form-label>
                <x-base.form-input id="create-commercial" name="commercial_registration" type="text" placeholder="رقم السجل التجاري" class="w-full" />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-tax">الرقم الضريبي</x-base.form-label>
                <x-base.form-input id="create-tax" name="tax_number" type="text" placeholder="الرقم الضريبي" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="create-country">الدولة</x-base.form-label>
                <x-base.form-input id="create-country" name="country" type="text" placeholder="الدولة" class="w-full" />
            </div>
            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="create-city">المدينة</x-base.form-label>
                <x-base.form-input id="create-city" name="city" type="text" placeholder="المدينة" class="w-full" />
            </div>
            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="create-postal">الرمز البريدي</x-base.form-label>
                <x-base.form-input id="create-postal" name="postal_code" type="text" placeholder="الرمز البريدي" class="w-full" />
            </div>

            <div class="col-span-12">
                <x-base.form-label for="create-address">العنوان</x-base.form-label>
                <x-base.form-textarea id="create-address" name="address" rows="2" placeholder="العنوان الكامل" class="w-full"></x-base.form-textarea>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-logo">شعار الشركة</x-base.form-label>
                <input id="create-logo" name="logo" type="file" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>الحالة</x-base.form-label>
                <div class="flex items-center gap-4 mt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="form-checkbox rounded text-primary">
                        <span>نشطة</span>
                    </label>
                </div>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button type="button" class="btn-royal btn-royal--outline group" data-tw-dismiss="modal">
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                إلغاء
            </button>
            <button type="button" id="save-company-btn" class="btn-royal btn-royal--gold group">
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                حفظ
            </button>
        </div>
    @endslot
</x-modal.form>

{{-- Edit Company Modal (Unified Theme) --}}
<x-modal.form id="edit-company-modal" title="تعديل بيانات الشركة">
    <form id="edit-company-form" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="edit-company-id" name="id">
        <div class="grid grid-cols-12 gap-4 gap-y-4">
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-name">اسم الشركة <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="edit-name" name="name" type="text" placeholder="أدخل اسم الشركة" class="w-full" required />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-phone">الهاتف</x-base.form-label>
                <x-base.form-input id="edit-phone" name="phone" type="tel" placeholder="رقم الهاتف" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-email">البريد الإلكتروني</x-base.form-label>
                <x-base.form-input id="edit-email" name="email" type="email" placeholder="email@example.com" class="w-full" />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-website">الموقع الإلكتروني</x-base.form-label>
                <x-base.form-input id="edit-website" name="website" type="url" placeholder="https://example.com" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-commercial">السجل التجاري</x-base.form-label>
                <x-base.form-input id="edit-commercial" name="commercial_registration" type="text" placeholder="رقم السجل التجاري" class="w-full" />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-tax">الرقم الضريبي</x-base.form-label>
                <x-base.form-input id="edit-tax" name="tax_number" type="text" placeholder="الرقم الضريبي" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="edit-country">الدولة</x-base.form-label>
                <x-base.form-input id="edit-country" name="country" type="text" placeholder="الدولة" class="w-full" />
            </div>
            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="edit-city">المدينة</x-base.form-label>
                <x-base.form-input id="edit-city" name="city" type="text" placeholder="المدينة" class="w-full" />
            </div>
            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="edit-postal">الرمز البريدي</x-base.form-label>
                <x-base.form-input id="edit-postal" name="postal_code" type="text" placeholder="الرمز البريدي" class="w-full" />
            </div>

            <div class="col-span-12">
                <x-base.form-label for="edit-address">العنوان</x-base.form-label>
                <x-base.form-textarea id="edit-address" name="address" rows="2" placeholder="العنوان الكامل" class="w-full"></x-base.form-textarea>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-logo">شعار الشركة</x-base.form-label>
                <input id="edit-logo" name="logo" type="file" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>الحالة</x-base.form-label>
                <div class="flex items-center gap-4 mt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="edit-is-active" name="is_active" value="1" class="form-checkbox rounded text-primary">
                        <span>نشطة</span>
                    </label>
                </div>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button type="button" class="btn-royal btn-royal--outline group" data-tw-dismiss="modal">
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                إلغاء
            </button>
            <button type="button" id="update-company-btn" class="btn-royal btn-royal--gold group">
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                تحديث
            </button>
        </div>
    @endslot
</x-modal.form>

@push('styles')
<style>
    #companies-table { font-size: 0.95rem; line-height: 1.4; }
    #companies-table tbody tr { height: 2.25rem; }
    #companies-table th { font-size: 0.8rem; font-weight: 700; padding: 0.5rem 1.25rem; }
    #companies-table td { padding: 0.375rem 1.25rem; }
    .icon-hover-rise { transition: transform 200ms ease; }
    .group:hover .icon-hover-rise { transform: translateY(-2px); }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Create Company
    const saveBtn = document.getElementById('save-company-btn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            const form = document.getElementById('create-company-form');
            const formData = new FormData(form);
            
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> جاري الحفظ...';
            
            fetch('{{ route("settings.company.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof window.showSuccess === 'function') {
                        window.showSuccess(data.message || 'تم إضافة الشركة بنجاح');
                    }
                    const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('create-company-modal'));
                    modal.hide();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    if (typeof window.showError === 'function') {
                        window.showError(data.message || 'فشل في إضافة الشركة');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof window.showError === 'function') {
                    window.showError('حدث خطأ أثناء الحفظ');
                }
            })
            .finally(() => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i data-lucide="save" class="w-5 h-5 icon-hover-rise"></i> حفظ';
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        });
    }

    // Edit Company - Open Modal
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const company = JSON.parse(this.dataset.company);
            
            document.getElementById('edit-company-id').value = company.id;
            document.getElementById('edit-name').value = company.name || '';
            document.getElementById('edit-phone').value = company.phone || '';
            document.getElementById('edit-email').value = company.email || '';
            document.getElementById('edit-website').value = company.website || '';
            document.getElementById('edit-commercial').value = company.commercial_registration || '';
            document.getElementById('edit-tax').value = company.tax_number || '';
            document.getElementById('edit-country').value = company.country || '';
            document.getElementById('edit-city').value = company.city || '';
            document.getElementById('edit-postal').value = company.postal_code || '';
            document.getElementById('edit-address').value = company.address || '';
            document.getElementById('edit-is-active').checked = company.is_active;
            
            const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('edit-company-modal'));
            modal.show();
        });
    });

    // Update Company
    const updateBtn = document.getElementById('update-company-btn');
    if (updateBtn) {
        updateBtn.addEventListener('click', function() {
            const form = document.getElementById('edit-company-form');
            const formData = new FormData(form);
            const companyId = document.getElementById('edit-company-id').value;
            
            updateBtn.disabled = true;
            updateBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> جاري التحديث...';
            
            fetch(`/settings/companies/${companyId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof window.showSuccess === 'function') {
                        window.showSuccess(data.message || 'تم تحديث الشركة بنجاح');
                    }
                    const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('edit-company-modal'));
                    modal.hide();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    if (typeof window.showError === 'function') {
                        window.showError(data.message || 'فشل في تحديث الشركة');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof window.showError === 'function') {
                    window.showError('حدث خطأ أثناء التحديث');
                }
            })
            .finally(() => {
                updateBtn.disabled = false;
                updateBtn.innerHTML = '<i data-lucide="save" class="w-5 h-5 icon-hover-rise"></i> تحديث';
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        });
    }

    // Delete Company
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const row = this.closest('tr');

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, () => {
                    fetch(`/settings/companies/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(data.message || 'تم حذف الشركة بنجاح');
                            }
                            row.remove();
                        } else {
                            if (typeof window.showError === 'function') {
                                window.showError(data.message || 'فشل في حذف الشركة');
                            }
                        }
                    })
                    .catch(() => {
                        if (typeof window.showError === 'function') {
                            window.showError('حدث خطأ أثناء الحذف');
                        }
                    });
                });
            }
        });
    });

    // Filter functionality
    const filterGo = document.getElementById('filter-go');
    const filterReset = document.getElementById('filter-reset');
    
    if (filterGo) {
        filterGo.addEventListener('click', function() {
            const field = document.getElementById('filter-field').value;
            const value = document.getElementById('filter-value').value.toLowerCase();
            const status = document.getElementById('filter-status').value;
            
            document.querySelectorAll('#companies-table tbody tr').forEach(row => {
                if (row.querySelector('td[colspan]')) return;
                
                let show = true;
                const text = row.textContent.toLowerCase();
                
                if (value && !text.includes(value)) {
                    show = false;
                }
                
                if (status) {
                    const isActive = row.querySelector('.bg-emerald-100') !== null;
                    if (status === 'active' && !isActive) show = false;
                    if (status === 'inactive' && isActive) show = false;
                }
                
                row.style.display = show ? '' : 'none';
            });
        });
    }
    
    if (filterReset) {
        filterReset.addEventListener('click', function() {
            document.getElementById('filter-field').value = 'all';
            document.getElementById('filter-value').value = '';
            document.getElementById('filter-status').value = '';
            document.querySelectorAll('#companies-table tbody tr').forEach(row => {
                row.style.display = '';
            });
        });
    }
});
</script>
@endpush
