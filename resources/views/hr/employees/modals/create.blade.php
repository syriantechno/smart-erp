@push('modals')
    <x-base.dialog id="create-employee-modal" size="xl">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="font-medium text-lg text-gray-900 dark:text-white">Add New Employee</h2>
                <button
                    type="button"
                    class="text-slate-500 hover:text-slate-400"
                    data-tw-dismiss="modal"
                >
                    <x-base.lucide icon="X" class="w-5 h-5" />
                </button>
            </x-base.dialog.title>
            
            <x-base.dialog.description class="p-5">
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <!-- Personal Information -->
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="full_name_ar">Full Name (Arabic)</x-base.form-label>
                        <x-base.form-input id="full_name_ar" type="text" placeholder="أحمد محمد علي" class="w-full rtl text-right" />
                    </div>
                    
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="full_name_en">Full Name (English)</x-base.form-label>
                        <x-base.form-input id="full_name_en" type="text" placeholder="Ahmed Mohammed Ali" class="w-full" />
                    </div>
                    
                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="national_id">National ID/Iqama</x-base.form-label>
                        <x-base.form-input id="national_id" type="text" placeholder="10XXXXXXX" class="w-full" />
                    </div>
                    
                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="birth_date">Date of Birth</x-base.form-label>
                        <x-base.form-input id="birth_date" type="date" class="w-full" />
                    </div>
                    
                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="gender">Gender</x-base.form-label>
                        <x-base.form-select id="gender" class="w-full">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </x-base.form-select>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="col-span-12 mt-4 pt-4 border-t border-gray-200 dark:border-dark-5">
                        <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Contact Information</h4>
                    </div>
                    
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="email">Email Address</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <x-base.lucide icon="Mail" class="w-5 h-5 text-gray-400" />
                            </div>
                            <x-base.form-input id="email" type="email" placeholder="employee@example.com" class="w-full pr-10" />
                        </div>
                    </div>
                    
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="phone">Mobile Number</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <x-base.lucide icon="Phone" class="w-5 h-5 text-gray-400" />
                            </div>
                            <x-base.form-input id="phone" type="tel" placeholder="05XXXXXXXX" class="w-full pr-10" dir="ltr" />
                        </div>
                    </div>
                    
                    <!-- Job Information -->
                    <div class="col-span-12 mt-4 pt-4 border-t border-gray-200 dark:border-dark-5">
                        <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Job Information</h4>
                    </div>
                    
                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="employee_id">Employee ID</x-base.form-label>
                        <x-base.form-input id="employee_id" type="text" placeholder="EMP-XXXX" class="w-full" />
                    </div>
                    
                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="department">Department</x-base.form-label>
                        <x-base.form-select id="department" class="w-full">
                            <option value="">Select Department</option>
                            <option>Software Development</option>
                            <option>Human Resources</option>
                            <option>Finance</option>
                            <option>Sales</option>
                            <option>Technical Support</option>
                        </x-base.form-select>
                    </div>
                    
                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="position">Job Title</x-base.form-label>
                        <x-base.form-input id="position" type="text" placeholder="Software Developer" class="w-full" />
                    </div>
                    
                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="hiring_date">Hiring Date</x-base.form-label>
                        <x-base.form-input id="hiring_date" type="date" class="w-full" />
                    </div>
                    
                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="salary">Basic Salary</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500">SAR</span>
                            </div>
                            <x-base.form-input id="salary" type="number" placeholder="0.00" class="w-full pr-12" dir="ltr" />
                        </div>
                    </div>
                    
                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="status">Employee Status</x-base.form-label>
                        <x-base.form-select id="status" class="w-full">
                            <option value="active">Active</option>
                            <option value="on_leave">On Leave</option>
                            <option value="inactive">Inactive</option>
                        </x-base.form-select>
                    </div>
                    
                    <!-- Notes -->
                    <div class="col-span-12">
                        <x-base.form-label for="notes">Additional Notes</x-base.form-label>
                        <x-base.form-textarea id="notes" rows="3" class="w-full" placeholder="Any additional notes..."></x-base.form-textarea>
                    </div>
                </div>
            </x-base.dialog.description>
            
            <x-base.dialog.footer class="border-t border-gray-200 dark:border-dark-5 pt-4">
                <div class="flex justify-end space-x-2 w-full">
                    <x-base.button
                        class="w-24"
                        data-tw-dismiss="modal"
                        type="button"
                        variant="outline-secondary"
                    >
                        Cancel
                    </x-base.button>
                    <x-base.button
                        class="w-24"
                        type="button"
                        variant="primary"
                    >
                        <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                        Save
                    </x-base.button>
                </div>
            </x-base.dialog.footer>
        </x-base.dialog.panel>
    </x-base.dialog>
@endpush
