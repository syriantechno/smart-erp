@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>الصناديق النقدية - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
@include('components.global-notifications')

{{-- Header --}}
<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="wallet" class="w-7 h-7" />
            <span>الصناديق النقدية</span>
        </h2>
        <div class="flex flex-col items-center gap-1">
            <div class="flex items-baseline gap-2">
                <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                    <x-base.lucide icon="box" class="w-4 h-4" />
                </div>
                <div class="text-4xl md:text-5xl font-semibold tracking-tight" style="color: #303030">
                    {{ $cashBoxes->count() ?? 0 }}
                </div>
            </div>
            <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">إجمالي الصناديق</div>
        </div>
    </div>
</div>

<div class="mt-5 grid grid-cols-12 gap-6">
    {{-- Create Form --}}
    <div class="intro-y col-span-12 lg:col-span-4">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                <h3 class="mb-4 text-lg font-semibold flex items-center gap-2">
                    <x-base.lucide icon="plus-circle" class="w-5 h-5 text-primary" />
                    إضافة صندوق جديد
                </h3>

                <form method="POST" action="{{ route('accounting.cash-boxes.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-base.form-label for="company_id">الشركة <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="company_id" name="company_id" required>
                            <option value="">اختر الشركة</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </x-base.form-select>
                    </div>

                    <div>
                        <x-base.form-label for="account_id">الحساب <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="account_id" name="account_id" required>
                            <option value="">اختر الحساب</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" @selected(old('account_id') == $account->id)>
                                    {{ $account->code }} - {{ $account->name }}
                                </option>
                            @endforeach
                        </x-base.form-select>
                    </div>

                    <div>
                        <x-base.form-label for="name">الاسم <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="اسم الصندوق" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-base.form-label for="code">الكود</x-base.form-label>
                            <x-base.form-input id="code" name="code" type="text" value="{{ old('code') }}" placeholder="CB001" />
                        </div>
                        <div>
                            <x-base.form-label for="currency">العملة</x-base.form-label>
                            <x-base.form-input id="currency" name="currency" type="text" value="{{ old('currency') }}" placeholder="SAR" />
                        </div>
                    </div>

                    <div>
                        <x-base.form-label for="description">الوصف</x-base.form-label>
                        <x-base.form-textarea id="description" name="description" rows="2" placeholder="وصف الصندوق...">{{ old('description') }}</x-base.form-textarea>
                    </div>

                    <div class="flex items-center gap-2">
                        <x-base.form-switch>
                            <x-base.form-switch.input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', true)) />
                            <x-base.form-switch.label for="is_active">نشط</x-base.form-switch.label>
                        </x-base.form-switch>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-royal btn-royal--gold w-full">
                            <x-base.lucide icon="save" class="w-4 h-4" /> حفظ الصندوق
                        </button>
                    </div>
                </form>
            </div>
        </x-base.preview-component>
    </div>

    {{-- Cash Boxes Table --}}
    <div class="intro-y col-span-12 lg:col-span-8">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                <h3 class="mb-4 text-lg font-semibold flex items-center gap-2">
                    <x-base.lucide icon="list" class="w-5 h-5 text-primary" />
                    الصناديق النقدية
                </h3>

                <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                    <table data-tw-merge data-erp-table class="w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">الاسم</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">الشركة</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">الحساب</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">العملة</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cashBoxes as $box)
                            <tr class="intro-x">
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <div class="font-semibold">{{ $box->name }}</div>
                                    @if($box->code)
                                        <div class="text-xs text-slate-500">{{ $box->code }}</div>
                                    @endif
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    {{ $box->company->name ?? '-' }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    {{ $box->account?->name ?? '-' }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    {{ $box->currency ?: 'SAR' }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                                    @if($box->is_active)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-600 rounded text-xs font-semibold">
                                            <x-base.lucide icon="check-circle" class="w-3 h-3" /> نشط
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-semibold">
                                            <x-base.lucide icon="x-circle" class="w-3 h-3" /> غير نشط
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-slate-400">
                                    <x-base.lucide icon="inbox" class="w-12 h-12 mx-auto mb-2 opacity-50" />
                                    لا توجد صناديق نقدية
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
@endsection
