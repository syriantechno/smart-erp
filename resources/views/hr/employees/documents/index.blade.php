@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $employee->full_name }} - Documents</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">{{ $employee->full_name }} - Documents</h2>
        <div class="flex gap-3">
            <a href="{{ route('hr.employees.show', $employee->id) }}" class="btn-royal btn-royal--outline">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" />
                Back to Profile
            </a>
            <a href="{{ route('hr.employees.documents.create', $employee->id) }}" class="btn-royal btn-royal--gold">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" />
                Add Document
            </a>
        </div>
    </div>

    @include('components.global-notifications')

    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- Passport Documents -->
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                    <h2 class="mr-auto text-base font-medium flex items-center">
                        <x-base.lucide icon="FileText" class="w-5 h-5 mr-2 text-blue-500" />
                        Passport Documents
                    </h2>
                    <a href="{{ route('hr.employees.documents.create', ['employee' => $employee->id, 'type' => 'passport']) }}" class="btn-tonal btn-tonal--info btn-tonal--sm">
                        <x-base.lucide icon="plus" class="w-4 h-4" />
                    </a>
                </div>
                <div class="p-5">
                    @if(isset($documents['passport']) && $documents['passport']->count() > 0)
                        <div class="space-y-4">
                            @foreach($documents['passport'] as $document)
                                <div class="border border-slate-200/60 rounded-lg p-4 dark:border-darkmode-400">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="font-medium text-slate-800 dark:text-slate-300">{{ $document->document_name }}</div>
                                            @if($document->document_number)
                                                <div class="text-sm text-slate-500 mt-1">Number: {{ $document->document_number }}</div>
                                            @endif
                                            <div class="flex items-center mt-2 space-x-4 text-sm text-slate-500">
                                                @if($document->issue_date)
                                                    <span>Issued: {{ $document->issue_date->format('M d, Y') }}</span>
                                                @endif
                                                @if($document->expiry_date)
                                                    <span class="{{ $document->is_expired ? 'text-red-500' : ($document->is_expiring_soon ? 'text-orange-500' : 'text-green-500') }}">
                                                        Expires: {{ $document->expiry_date->format('M d, Y') }}
                                                        @if($document->is_expired)
                                                            <span class="text-xs">(Expired)</span>
                                                        @elseif($document->is_expiring_soon)
                                                            <span class="text-xs">(Expiring Soon)</span>
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            @if($document->file_path)
                                                <a href="{{ route('hr.employees.documents.download', ['employee' => $employee->id, 'document' => $document->id]) }}" class="btn-tonal btn-tonal--info btn-tonal--icon" title="Download">
                                                    <x-base.lucide icon="download" class="w-4 h-4" />
                                                </a>
                                            @endif
                                            <a href="{{ route('hr.employees.documents.edit', ['employee' => $employee->id, 'document' => $document->id]) }}" class="btn-tonal btn-tonal--warning btn-tonal--icon" title="Edit">
                                                <x-base.lucide icon="edit" class="w-4 h-4" />
                                            </a>
                                            <button onclick="confirmDelete({{ $document->id }}, '{{ addslashes($document->document_name) }}')" class="btn-tonal btn-tonal--danger btn-tonal--icon" title="Delete">
                                                <x-base.lucide icon="trash-2" class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </div>
                                    @if($document->notes)
                                        <div class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                            {{ $document->notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <x-base.lucide class="h-12 w-12 text-slate-400 mb-4" icon="file-text" />
                            <div class="text-slate-500 mb-2">No passport documents</div>
                            <a href="{{ route('hr.employees.documents.create', ['employee' => $employee->id, 'type' => 'passport']) }}"
                               class="text-primary hover:text-primary/80 text-sm">
                                Add first passport document
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Visa Documents -->
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                    <h2 class="mr-auto text-base font-medium flex items-center">
                        <x-base.lucide icon="Plane" class="w-5 h-5 mr-2 text-green-500" />
                        Visa Documents
                    </h2>
                    <a href="{{ route('hr.employees.documents.create', ['employee' => $employee->id, 'type' => 'visa']) }}" class="btn-tonal btn-tonal--info btn-tonal--sm">
                        <x-base.lucide icon="plus" class="w-4 h-4" />
                    </a>
                </div>
                <div class="p-5">
                    @if(isset($documents['visa']) && $documents['visa']->count() > 0)
                        <div class="space-y-4">
                            @foreach($documents['visa'] as $document)
                                <div class="border border-slate-200/60 rounded-lg p-4 dark:border-darkmode-400">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="font-medium text-slate-800 dark:text-slate-300">{{ $document->document_name }}</div>
                                            @if($document->document_number)
                                                <div class="text-sm text-slate-500 mt-1">Number: {{ $document->document_number }}</div>
                                            @endif
                                            <div class="flex items-center mt-2 space-x-4 text-sm text-slate-500">
                                                @if($document->issue_date)
                                                    <span>Issued: {{ $document->issue_date->format('M d, Y') }}</span>
                                                @endif
                                                @if($document->expiry_date)
                                                    <span class="{{ $document->is_expired ? 'text-red-500' : ($document->is_expiring_soon ? 'text-orange-500' : 'text-green-500') }}">
                                                        Expires: {{ $document->expiry_date->format('M d, Y') }}
                                                        @if($document->is_expired)
                                                            <span class="text-xs">(Expired)</span>
                                                        @elseif($document->is_expiring_soon)
                                                            <span class="text-xs">(Expiring Soon)</span>
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            @if($document->file_path)
                                                <a href="{{ route('hr.employees.documents.download', ['employee' => $employee->id, 'document' => $document->id]) }}" class="btn-tonal btn-tonal--info btn-tonal--icon" title="Download">
                                                    <x-base.lucide icon="download" class="w-4 h-4" />
                                                </a>
                                            @endif
                                            <a href="{{ route('hr.employees.documents.edit', ['employee' => $employee->id, 'document' => $document->id]) }}" class="btn-tonal btn-tonal--warning btn-tonal--icon" title="Edit">
                                                <x-base.lucide icon="edit" class="w-4 h-4" />
                                            </a>
                                            <button onclick="confirmDelete({{ $document->id }}, '{{ addslashes($document->document_name) }}')" class="btn-tonal btn-tonal--danger btn-tonal--icon" title="Delete">
                                                <x-base.lucide icon="trash-2" class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </div>
                                    @if($document->notes)
                                        <div class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                            {{ $document->notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <x-base.lucide class="h-12 w-12 text-slate-400 mb-4" icon="plane" />
                            <div class="text-slate-500 mb-2">No visa documents</div>
                            <a href="{{ route('hr.employees.documents.create', ['employee' => $employee->id, 'type' => 'visa']) }}"
                               class="text-primary hover:text-primary/80 text-sm">
                                Add first visa document
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Other Documents -->
        <div class="col-span-12">
            <div class="intro-y box">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                    <h2 class="mr-auto text-base font-medium flex items-center">
                        <x-base.lucide icon="Folder" class="w-5 h-5 mr-2 text-purple-500" />
                        Other Documents
                    </h2>
                    <a href="{{ route('hr.employees.documents.create', ['employee' => $employee->id]) }}" class="btn-tonal btn-tonal--info btn-tonal--sm">
                        <x-base.lucide icon="plus" class="w-4 h-4" />
                    </a>
                </div>
                <div class="p-5">
                    @php
                        $otherDocuments = collect();
                        foreach (['id_card', 'license', 'certificate', 'other'] as $type) {
                            if (isset($documents[$type])) {
                                $otherDocuments = $otherDocuments->merge($documents[$type]);
                            }
                        }
                    @endphp

                    @if($otherDocuments->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($otherDocuments as $document)
                                <div class="border border-slate-200/60 rounded-lg p-4 dark:border-darkmode-400">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1">
                                            <div class="font-medium text-slate-800 dark:text-slate-300 text-sm">{{ $document->document_name }}</div>
                                            <div class="text-xs text-slate-500 mt-1">{{ $document->document_type_formatted }}</div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            @if($document->file_path)
                                                <a href="{{ route('hr.employees.documents.download', ['employee' => $employee->id, 'document' => $document->id]) }}" class="btn-tonal btn-tonal--info btn-tonal--icon btn-tonal--sm" title="Download">
                                                    <x-base.lucide icon="download" class="w-3 h-3" />
                                                </a>
                                            @endif
                                            <a href="{{ route('hr.employees.documents.edit', ['employee' => $employee->id, 'document' => $document->id]) }}" class="btn-tonal btn-tonal--warning btn-tonal--icon btn-tonal--sm" title="Edit">
                                                <x-base.lucide icon="edit" class="w-3 h-3" />
                                            </a>
                                            <button onclick="confirmDelete({{ $document->id }}, '{{ addslashes($document->document_name) }}')" class="btn-tonal btn-tonal--danger btn-tonal--icon btn-tonal--sm" title="Delete">
                                                <x-base.lucide icon="trash-2" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    </div>
                                    @if($document->document_number)
                                        <div class="text-xs text-slate-500 mb-2">Number: {{ $document->document_number }}</div>
                                    @endif
                                    <div class="flex items-center justify-between text-xs text-slate-500">
                                        @if($document->expiry_date)
                                            <span class="{{ $document->is_expired ? 'text-red-500' : ($document->is_expiring_soon ? 'text-orange-500' : '') }}">
                                                Expires: {{ $document->expiry_date->format('M d, Y') }}
                                            </span>
                                        @else
                                            <span>No expiry</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <x-base.lucide class="h-12 w-12 text-slate-400 mb-4" icon="folder" />
                            <div class="text-slate-500 mb-2">No other documents</div>
                            <a href="{{ route('hr.employees.documents.create', ['employee' => $employee->id]) }}"
                               class="text-primary hover:text-primary/80 text-sm">
                                Add first document
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function confirmDelete(documentId, documentName) {
    window.confirmDelete(documentName, function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('hr.employees.documents.index', ['employee' => $employee->id]) }}/${documentId}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';

        form.appendChild(methodInput);
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    });
}
</script>
@endpush
