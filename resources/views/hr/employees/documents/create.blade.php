@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Add Document - {{ $employee->full_name }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Add Document for {{ $employee->full_name }}</h2>
        <a href="{{ route('hr.employees.documents.index', ['employee' => $employee->id]) }}" class="btn btn-outline-secondary">
            <x-base.lucide icon="ArrowLeft" class="w-4 h-4 mr-2" />
            Back to Documents
        </a>
    </div>

    @include('components.global-notifications')

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="intro-y box">
                <div class="p-5">
                    <form action="{{ route('hr.employees.documents.store', ['employee' => $employee->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-12 gap-6">
                            <!-- Document Type -->
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="document_type">Document Type <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-select id="document_type" name="document_type" class="w-full" required>
                                    <option value="">Select document type</option>
                                    <option value="passport" {{ request('type') === 'passport' ? 'selected' : '' }}>🛂 Passport</option>
                                    <option value="visa" {{ request('type') === 'visa' ? 'selected' : '' }}>✈️ Visa</option>
                                    <option value="id_card">🆔 ID Card</option>
                                    <option value="license">🚗 License</option>
                                    <option value="certificate">🎓 Certificate</option>
                                    <option value="other">📄 Other</option>
                                </x-base.form-select>
                            </div>

                            <!-- Document Name -->
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="document_name">Document Name <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-input id="document_name" name="document_name" type="text" placeholder="e.g., Passport, Work Visa, Driver License" class="w-full" required />
                            </div>

                            <!-- Document Number -->
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="document_number">Document Number</x-base.form-label>
                                <x-base.form-input id="document_number" name="document_number" type="text" placeholder="Enter document number" class="w-full" />
                            </div>

                            <!-- Issue Date -->
                            <div class="col-span-12 md:col-span-3">
                                <x-base.form-label for="issue_date">Issue Date</x-base.form-label>
                                <x-base.form-input id="issue_date" name="issue_date" type="date" class="w-full" />
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-span-12 md:col-span-3">
                                <x-base.form-label for="expiry_date">Expiry Date</x-base.form-label>
                                <x-base.form-input id="expiry_date" name="expiry_date" type="date" class="w-full" />
                            </div>

                            <!-- File Upload -->
                            <div class="col-span-12">
                                <x-base.form-label for="file">Document File</x-base.form-label>
                                <input type="file" id="file" name="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="text-sm text-slate-500 mt-1">
                                    Accepted formats: PDF, JPG, JPEG, PNG. Maximum size: 5MB
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="col-span-12">
                                <x-base.form-label for="notes">Notes</x-base.form-label>
                                <x-base.form-textarea id="notes" name="notes" rows="3" placeholder="Additional notes about this document" class="w-full"></x-base.form-textarea>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('hr.employees.documents.index', ['employee' => $employee->id]) }}" class="btn btn-outline-secondary mr-3">
                                Cancel
                            </a>
                            <x-base.button type="submit" variant="primary">
                                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                                Upload Document
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate that expiry date is after issue date
    const issueDateInput = document.getElementById('issue_date');
    const expiryDateInput = document.getElementById('expiry_date');
    const documentTypeSelect = document.getElementById('document_type');
    const documentNameInput = document.getElementById('document_name');

    function validateDates() {
        if (issueDateInput.value && expiryDateInput.value) {
            const issueDate = new Date(issueDateInput.value);
            const expiryDate = new Date(expiryDateInput.value);

            if (expiryDate <= issueDate) {
                expiryDateInput.setCustomValidity('Expiry date must be after issue date');
            } else {
                expiryDateInput.setCustomValidity('');
            }
        }
    }

    function updateDocumentNameHint() {
        const selectedType = documentTypeSelect.value;
        let placeholder = '';

        switch(selectedType) {
            case 'passport':
                placeholder = 'e.g., Passport Number, Diplomatic Passport';
                break;
            case 'visa':
                placeholder = 'e.g., Work Visa, Tourist Visa, Student Visa';
                break;
            case 'id_card':
                placeholder = 'e.g., National ID, Resident Card';
                break;
            case 'license':
                placeholder = 'e.g., Driver License, Professional License';
                break;
            case 'certificate':
                placeholder = 'e.g., Degree Certificate, Training Certificate';
                break;
            default:
                placeholder = 'e.g., Document name or title';
        }

        documentNameInput.placeholder = placeholder;
    }

    issueDateInput.addEventListener('change', validateDates);
    expiryDateInput.addEventListener('change', validateDates);
    documentTypeSelect.addEventListener('change', updateDocumentNameHint);

    // Set initial placeholder
    updateDocumentNameHint();
});
</script>
@endpush
