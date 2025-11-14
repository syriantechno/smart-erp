@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Edit Document - {{ $employee->full_name }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Edit Document for {{ $employee->full_name }}</h2>
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
                    <form action="{{ route('hr.employees.documents.update', ['employee' => $employee->id, 'document' => $document->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-12 gap-6">
                            <!-- Document Type -->
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="document_type">Document Type <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-select id="document_type" name="document_type" class="w-full" required>
                                    <option value="">Select document type</option>
                                    <option value="passport" {{ $document->document_type === 'passport' ? 'selected' : '' }}>🛂 Passport</option>
                                    <option value="visa" {{ $document->document_type === 'visa' ? 'selected' : '' }}>✈️ Visa</option>
                                    <option value="id_card" {{ $document->document_type === 'id_card' ? 'selected' : '' }}>🆔 ID Card</option>
                                    <option value="license" {{ $document->document_type === 'license' ? 'selected' : '' }}>🚗 License</option>
                                    <option value="certificate" {{ $document->document_type === 'certificate' ? 'selected' : '' }}>🎓 Certificate</option>
                                    <option value="other" {{ $document->document_type === 'other' ? 'selected' : '' }}>📄 Other</option>
                                </x-base.form-select>
                            </div>

                            <!-- Document Name -->
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="document_name">Document Name <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-input id="document_name" name="document_name" type="text" placeholder="e.g., Passport, Work Visa, Driver License" class="w-full" value="{{ old('document_name', $document->document_name) }}" required />
                            </div>

                            <!-- Document Number -->
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="document_number">Document Number</x-base.form-label>
                                <x-base.form-input id="document_number" name="document_number" type="text" placeholder="Enter document number" class="w-full" value="{{ old('document_number', $document->document_number) }}" />
                            </div>

                            <!-- Issue Date -->
                            <div class="col-span-12 md:col-span-3">
                                <x-base.form-label for="issue_date">Issue Date</x-base.form-label>
                                <div class="relative mx-auto w-56">
                                    <div
                                        class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                        <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                                    </div>
                                    <x-base.litepicker
                                        id="issue_date"
                                        name="issue_date"
                                        class="pl-12"
                                        data-single-mode="true"
                                        value="{{ old('issue_date', $document->issue_date ? $document->issue_date->format('Y-m-d') : '') }}"
                                    />
                                </div>
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-span-12 md:col-span-3">
                                <x-base.form-label for="expiry_date">Expiry Date</x-base.form-label>
                                <div class="relative mx-auto w-56">
                                    <div
                                        class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                        <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                                    </div>
                                    <x-base.litepicker
                                        id="expiry_date"
                                        name="expiry_date"
                                        class="pl-12"
                                        data-single-mode="true"
                                        value="{{ old('expiry_date', $document->expiry_date ? $document->expiry_date->format('Y-m-d') : '') }}"
                                    />
                                </div>
                            </div>

                            <!-- Current File -->
                            @if($document->file_path)
                            <div class="col-span-12">
                                <x-base.form-label>Current File</x-base.form-label>
                                <div class="flex items-center space-x-3 p-3 bg-slate-50 dark:bg-darkmode-600 rounded-lg">
                                    <x-base.lucide icon="FileText" class="w-5 h-5 text-slate-500" />
                                    <div class="flex-1">
                                        <div class="font-medium">{{ $document->file_name }}</div>
                                        <div class="text-sm text-slate-500">
                                            Uploaded on {{ $document->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <a href="{{ route('hr.employees.documents.download', ['employee' => $employee->id, 'document' => $document->id]) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <x-base.lucide icon="Download" class="w-4 h-4" />
                                    </a>
                                </div>
                            </div>
                            @endif

                            <!-- File Upload -->
                            <div class="col-span-12">
                                <x-base.form-label for="file">{{ $document->file_path ? 'Replace File' : 'Document File' }}</x-base.form-label>
                                <input type="file" id="file" name="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="text-sm text-slate-500 mt-1">
                                    Accepted formats: PDF, JPG, JPEG, PNG. Maximum size: 5MB
                                    @if($document->file_path)
                                        <br>Leave empty to keep current file
                                    @endif
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="col-span-12">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" {{ $document->is_active ? 'checked' : '' }} class="form-check-input">
                                    <span class="ml-2 text-sm font-medium text-slate-700 dark:text-slate-300">Active Document</span>
                                </label>
                            </div>

                            <!-- Notes -->
                            <div class="col-span-12">
                                <x-base.form-label for="notes">Notes</x-base.form-label>
                                <x-base.form-textarea id="notes" name="notes" rows="3" placeholder="Additional notes about this document" class="w-full">{{ old('notes', $document->notes) }}</x-base.form-textarea>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <x-base.button as="a" href="{{ route('hr.employees.documents.index', ['employee' => $employee->id]) }}" variant="outline-secondary" class="mr-3">
                                Cancel
                            </x-base.button>
                            <x-base.button type="submit" variant="primary">
                                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                                Update Document
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

    issueDateInput.addEventListener('change', validateDates);
    expiryDateInput.addEventListener('change', validateDates);
});
</script>
@endpush
