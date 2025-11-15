<!-- Add Account Modal -->
<x-base.dialog id="add-account-modal" size="lg">
    <x-base.dialog.panel>
        <!-- Header -->
        <x-base.dialog.title>
            <x-base.lucide icon="Plus" class="w-5 h-5 mr-2" />
            Add New Account
        </x-base.dialog.title>

        <form id="add-account-form">
            <!-- Modal Body -->
            <div class="px-5 py-3">
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Account Name -->
                        <div class="col-span-12 md:col-span-8">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Account Name *
                            </label>
                            <x-base.form-input
                                id="name"
                                name="name"
                                type="text"
                                placeholder="Enter account name"
                                class="w-full"
                                required
                            />
                        </div>

                        <!-- Account Type -->
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Account Type *
                            </label>
                            <x-base.form-select id="type" name="type" class="w-full" required>
                                <option value="">Select Type</option>
                                <option value="asset">Asset</option>
                                <option value="liability">Liability</option>
                                <option value="equity">Equity</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </x-base.form-select>
                        </div>

                        <!-- Description -->
                        <div class="col-span-12">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Description
                            </label>
                            <x-base.form-textarea
                                id="description"
                                name="description"
                                rows="2"
                                placeholder="Account description..."
                                class="w-full"
                            />
                        </div>
                    </div>

                    <!-- Classification -->
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Parent Account -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Parent Account
                            </label>
                            <x-base.form-select id="parent_id" name="parent_id" class="w-full">
                                <option value="">Root Account (No Parent)</option>
                                <!-- Will be populated via JavaScript -->
                            </x-base.form-select>
                        </div>

                        <!-- Category -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Category
                            </label>
                            <x-base.form-select id="category" name="category" class="w-full">
                                <option value="">Select Category</option>
                                <!-- Will be populated based on type selection -->
                            </x-base.form-select>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Is Active -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="flex items-center">
                                <input
                                    id="is_active"
                                    name="is_active"
                                    type="checkbox"
                                    value="1"
                                    checked
                                    class="form-checkbox rounded text-primary border-slate-300 dark:border-darkmode-400"
                                />
                                <span class="ml-2 text-sm font-medium text-slate-700 dark:text-slate-300">Active Account</span>
                            </label>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                Inactive accounts won't appear in transaction dropdowns
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <x-base.dialog.footer>
                <x-base.button
                    type="button"
                    variant="secondary"
                    x-on:click="$dispatch('close')"
                >
                    Cancel
                </x-base.button>

                <x-base.button
                    type="submit"
                    variant="primary"
                    id="submit-account-btn"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Create Account
                </x-base.button>
            </x-base.dialog.footer>
        </form>
    </x-base.dialog.panel>
</x-base.dialog>

<script>
// Account Form Handling
document.addEventListener('DOMContentLoaded', function() {
    const accountForm = document.getElementById('add-account-form');
    const typeSelect = document.getElementById('type');
    const categorySelect = document.getElementById('category');
    const parentSelect = document.getElementById('parent_id');

    // Account type to category mapping
    const typeCategories = {
        'asset': [
            { value: 'current_asset', label: 'Current Asset' },
            { value: 'fixed_asset', label: 'Fixed Asset' }
        ],
        'liability': [
            { value: 'current_liability', label: 'Current Liability' },
            { value: 'long_term_liability', label: 'Long-term Liability' }
        ],
        'equity': [
            { value: 'owner_equity', label: 'Owner Equity' },
            { value: 'retained_earnings', label: 'Retained Earnings' }
        ],
        'income': [
            { value: 'operating_income', label: 'Operating Income' },
            { value: 'other_income', label: 'Other Income' }
        ],
        'expense': [
            { value: 'cost_of_goods_sold', label: 'Cost of Goods Sold' },
            { value: 'operating_expense', label: 'Operating Expense' },
            { value: 'other_expense', label: 'Other Expense' }
        ]
    };

    // Update categories when type changes
    if (typeSelect) {
        typeSelect.addEventListener('change', function() {
            updateCategories(this.value);
            updateParentAccounts(this.value);
        });
    }

    // Form submission
    if (accountForm) {
        accountForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const submitBtn = document.getElementById('submit-account-btn');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<x-base.lucide icon="Loader" class="w-4 h-4 mr-2 animate-spin"></x-base.lucide>Creating...';

            const formData = new FormData(accountForm);

            // Convert FormData to JSON for better handling
            const data = {};
            for (let [key, value] of formData.entries()) {
                if (key === 'is_active') {
                    data[key] = value === '1';
                } else {
                    data[key] = value;
                }
            }

            console.log('Account data:', data);

            fetch('{{ route("accounting.chart-of-accounts.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data),
                credentials: 'same-origin'
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    showToast(data.message || 'Account created successfully', 'success');

                    // Reset form and close modal
                    accountForm.reset();
                    categorySelect.innerHTML = '<option value="">Select Category</option>';
                    parentSelect.innerHTML = '<option value="">Root Account (No Parent)</option>';

                    const modal = document.getElementById('add-account-modal');
                    if (modal) {
                        modal.__tippy?.hide();
                    }

                    // Reload table
                    if (window.accountTable) {
                        window.accountTable.ajax.reload(null, false);
                    }
                } else {
                    // Show validation errors
                    if (data.errors) {
                        let errorMessage = 'Validation errors:\n';
                        Object.values(data.errors).forEach(function(errors) {
                            if (Array.isArray(errors)) {
                                errors.forEach(function(error) { errorMessage += '• ' + error + '\n'; });
                            } else {
                                errorMessage += '• ' + errors + '\n';
                            }
                        });
                        showToast(errorMessage, 'error');
                    } else {
                        showToast(data.message || 'Failed to create account', 'error');
                    }
                }
            })
            .catch(function(error) {
                console.error('Error creating account:', error);
                showToast('An error occurred while creating the account', 'error');
            })
            .finally(function() {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }

    function updateCategories(selectedType) {
        if (!categorySelect) return;

        categorySelect.innerHTML = '<option value="">Select Category</option>';

        if (selectedType && typeCategories[selectedType]) {
            typeCategories[selectedType].forEach(function(category) {
                const option = document.createElement('option');
                option.value = category.value;
                option.textContent = category.label;
                categorySelect.appendChild(option);
            });
        }
    }

    function updateParentAccounts(selectedType) {
        if (!parentSelect) return;

        parentSelect.innerHTML = '<option value="">Loading parent accounts...</option>';

        // Fetch parent accounts of the same type
        fetch('/accounting/chart-of-accounts/parents?type=' + selectedType, {
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            parentSelect.innerHTML = '<option value="">Root Account (No Parent)</option>';
            if (data.success && data.data) {
                data.data.forEach(function(account) {
                    const option = document.createElement('option');
                    option.value = account.id;
                    option.textContent = account.code + ' - ' + account.name;
                    parentSelect.appendChild(option);
                });
            }
        })
        .catch(function(error) {
            console.error('Error loading parent accounts:', error);
            parentSelect.innerHTML = '<option value="">Root Account (No Parent)</option>';
        });
    }
});
</script>
