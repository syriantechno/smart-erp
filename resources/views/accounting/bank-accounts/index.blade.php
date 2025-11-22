@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Bank Accounts - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Bank Accounts</h2>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-4">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h3 class="mb-4 text-base font-semibold">Add New Bank Account</h3>

                    <form method="POST" action="{{ route('accounting.bank-accounts.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-base.form-label for="company_id">Company <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="company_id" name="company_id" required>
                                <option value="">Select company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <div>
                            <x-base.form-label for="account_id">Account <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="account_id" name="account_id" required>
                                <option value="">Select account</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" @selected(old('account_id') == $account->id)>
                                        {{ $account->code }} - {{ $account->name }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <div>
                            <x-base.form-label for="name">Account Name <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input id="name" name="name" type="text" value="{{ old('name') }}" required />
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6">
                                <x-base.form-label for="bank_name">Bank Name</x-base.form-label>
                                <x-base.form-input id="bank_name" name="bank_name" type="text" value="{{ old('bank_name') }}" />
                            </div>
                            <div class="col-span-6">
                                <x-base.form-label for="account_number">Account Number</x-base.form-label>
                                <x-base.form-input id="account_number" name="account_number" type="text" value="{{ old('account_number') }}" />
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6">
                                <x-base.form-label for="iban">IBAN</x-base.form-label>
                                <x-base.form-input id="iban" name="iban" type="text" value="{{ old('iban') }}" />
                            </div>
                            <div class="col-span-6">
                                <x-base.form-label for="currency">Currency</x-base.form-label>
                                <x-base.form-input id="currency" name="currency" type="text" value="{{ old('currency') }}" placeholder="e.g. SAR" />
                            </div>
                        </div>

                        <div>
                            <x-base.form-label for="description">Description</x-base.form-label>
                            <x-base.form-textarea id="description" name="description" rows="2">{{ old('description') }}</x-base.form-textarea>
                        </div>

                        <div class="flex items-center gap-2">
                            <x-base.form-switch>
                                <x-base.form-switch.input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', true)) />
                                <x-base.form-switch.label for="is_active">Active</x-base.form-switch.label>
                            </x-base.form-switch>
                        </div>

                        <div class="pt-2 text-right">
                            <x-base.button type="submit" variant="primary">
                                Save Bank Account
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </x-base.preview-component>
        </div>

        <div class="intro-y col-span-12 lg:col-span-8">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h3 class="mb-4 text-base font-semibold">Existing Bank Accounts</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 text-xs font-semibold uppercase text-slate-500">
                                    <th class="py-2 pr-4">Account</th>
                                    <th class="py-2 pr-4">Company</th>
                                    <th class="py-2 pr-4">Bank</th>
                                    <th class="py-2 pr-4">Number / IBAN</th>
                                    <th class="py-2 pr-4">Currency</th>
                                    <th class="py-2 pr-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bankAccounts as $acc)
                                    <tr class="border-b border-slate-100 text-xs text-slate-700 dark:text-slate-300">
                                        <td class="py-2 pr-4">
                                            <div class="font-semibold">{{ $acc->name }}</div>
                                            <div class="text-[11px] text-slate-500">{{ $acc->account?->code }} - {{ $acc->account?->name }}</div>
                                        </td>
                                        <td class="py-2 pr-4">{{ $acc->company->name ?? '-' }}</td>
                                        <td class="py-2 pr-4">{{ $acc->bank_name ?: '-' }}</td>
                                        <td class="py-2 pr-4">
                                            @if($acc->account_number)
                                                <div class="text-[11px]">{{ $acc->account_number }}</div>
                                            @endif
                                            @if($acc->iban)
                                                <div class="text-[11px] text-slate-500">{{ $acc->iban }}</div>
                                            @endif
                                        </td>
                                        <td class="py-2 pr-4">{{ $acc->currency ?: '-' }}</td>
                                        <td class="py-2 pr-4">
                                            @if($acc->is_active)
                                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-[11px] font-semibold text-green-700">Active</span>
                                            @else
                                                <span class="rounded-full bg-red-100 px-2 py-0.5 text-[11px] font-semibold text-red-700">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-xs text-slate-500">
                                            No bank accounts found.
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
