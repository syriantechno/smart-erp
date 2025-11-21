<!-- Update Recruitment Status Modal -->
<x-base.dialog id="status-recruitment-modal" size="md">
    <x-base.dialog.panel>
        <!-- Header -->
        <x-base.dialog.title>
            <x-base.lucide icon="Edit3" class="w-5 h-5 mr-2" />
            Update Candidate Status
        </x-base.dialog.title>

        <form
            id="status-recruitment-form"
            data-status-url-base="{{ url('/hr/recruitment') }}"
        >
            <!-- Modal Body -->
            <div class="px-5 py-3">
                <div class="space-y-4">
                    <!-- Current Status Info -->
                    <div class="bg-slate-50 dark:bg-darkmode-600 rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <x-base.lucide icon="User" class="w-8 h-8 text-slate-400" />
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-900 dark:text-white" id="status-candidate-name">
                                    Candidate Name
                                </h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400" id="status-current-status">
                                    Current Status
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- New Status -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            New Status *
                        </label>
                        <x-base.form-select id="new_status" name="status" class="w-full" required>
                            <option value="">Select New Status</option>
                            <option value="applied">Applied</option>
                            <option value="screening">Screening</option>
                            <option value="interview">Interview</option>
                            <option value="offered">Offered</option>
                            <option value="hired">Hired</option>
                            <option value="rejected">Rejected</option>
                        </x-base.form-select>
                    </div>

                    <div id="interview-fields" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Interview Date *
                            </label>
                            <div class="relative mx-auto w-56">
                                <div
                                    class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                    <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                                </div>
                                <x-base.litepicker
                                    id="interview_date"
                                    name="interview_date"
                                    class="pl-12"
                                    data-single-mode="false"
                                />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Interviewer *
                            </label>
                            <x-base.form-input
                                id="interviewer"
                                name="interviewer"
                                type="text"
                                placeholder="Interviewer name"
                                class="w-full"
                            />
                        </div>
                    </div>

                    <div id="offer-fields" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Offered Salary *
                            </label>
                            <x-base.form-input
                                id="offered_salary"
                                name="offered_salary"
                                type="number"
                                step="0.01"
                                placeholder="0.00"
                                class="w-full"
                            />
                        </div>
                    </div>

                    <div id="hire-fields" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Joining Date *
                            </label>
                            <div class="relative mx-auto w-56">
                                <div
                                    class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                    <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                                </div>
                                <x-base.litepicker
                                    id="joining_date"
                                    name="joining_date"
                                    class="pl-12"
                                    data-single-mode="true"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Notes
                        </label>
                        <x-base.form-textarea
                            id="status_notes"
                            name="notes"
                            rows="3"
                            placeholder="Add any notes about this status change..."
                            class="w-full"
                        />
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
                    <x-base.lucide icon="X" class="w-4 h-4 mr-2" />
                    Cancel
                </x-base.button>

                <x-base.button
                    type="submit"
                    variant="primary"
                    id="update-status-btn"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Save
                </x-base.button>
            </x-base.dialog.footer>

            <!-- Hidden Fields -->
            <input type="hidden" id="status-recruitment-id" name="recruitment_id" />
        </form>
    </x-base.dialog.panel>
</x-base.dialog>
