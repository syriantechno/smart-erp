{{-- Edit Payroll Modal --}}
<x-modal.form id="edit-modal" title="Edit Payroll" size="lg">
    <form id="edit-form" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="payroll_id" id="edit-payroll-id">

        <div class="grid grid-cols-12 gap-4">
            {{-- Bonuses --}}
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-bonuses">
                    Bonuses
                </x-base.form-label>
                <div class="relative">
                    <x-base.form-input 
                        type="number" 
                        id="edit-bonuses" 
                        name="bonuses" 
                        step="0.01" 
                        min="0"
                        class="w-full pr-12" 
                        placeholder="0.00"
                    />
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">SAR</span>
                </div>
            </div>

            {{-- Additional Deductions --}}
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-deductions">
                    Additional Deductions
                </x-base.form-label>
                <div class="relative">
                    <x-base.form-input 
                        type="number" 
                        id="edit-deductions" 
                        name="deductions" 
                        step="0.01" 
                        min="0"
                        class="w-full pr-12" 
                        placeholder="0.00"
                    />
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">SAR</span>
                </div>
            </div>

            {{-- Notes --}}
            <div class="col-span-12">
                <x-base.form-label for="edit-notes">
                    Notes
                </x-base.form-label>
                <x-base.form-textarea 
                    id="edit-notes" 
                    name="notes" 
                    rows="3" 
                    placeholder="Add any notes..."
                    class="w-full"
                ></x-base.form-textarea>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex justify-end gap-2 w-full">
            <button type="button" class="btn-royal btn-royal--outline" data-tw-dismiss="modal">
                <x-base.lucide icon="x" class="w-4 h-4 mr-2" />
                Cancel
            </button>
            <button type="submit" form="edit-form" id="btn-submit-edit" class="btn-royal btn-royal--gold">
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                Save
            </button>
        </div>
    @endslot
</x-modal.form>
