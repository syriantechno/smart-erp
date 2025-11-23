@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Contracts Management - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (Departments template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="file-signature" class="w-7 h-7" />
                <span>Contracts Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Expired --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="archive" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Expired
                    </div>
                </div>

                {{-- Active --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Active
                    </div>
                </div>

                {{-- Draft --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="edit" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Draft
                    </div>
                </div>

                {{-- Total --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="file-signature" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Contracts
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <div class="flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="contracts-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export" placement="bottom">
                                <button id="contracts-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="contracts-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Contract button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new contract" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    onclick="alert('Create Contract functionality coming soon!')"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <!-- Contracts Table -->
                    <div class="overflow-x-auto">
                        <table id="contracts-table" class="table table-striped">
                            <thead class="bg-gradient-to-r from-royalDark to-gray-800 text-white">
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">#</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Client</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Value</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Start Date</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">End Date</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="px-5 py-8 text-center text-slate-500">
                                        <x-base.lucide icon="file-signature" class="w-12 h-12 mx-auto mb-3 opacity-50" />
                                        <p>No contracts found. Create your first contract!</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // PDF export
            const pdfBtn = document.getElementById('contracts-pdf');
            if (pdfBtn) {
                pdfBtn.addEventListener('click', function () {
                    showToast('PDF export functionality not implemented yet', 'info');
                });
            }

            // Export functionality
            const exportBtn = document.getElementById('contracts-export');
            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    // Simple message for now since table is empty
                    if (typeof showToast === 'function') {
                        showToast('No data available for export', 'info');
                    }
                });
            }

            // Refresh functionality
            const refreshBtn = document.getElementById('contracts-refresh');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function () {
                    window.location.reload();
                    if (typeof showToast === 'function') {
                        showToast('Page refreshed', 'success');
                    }
                });
            }
        });
    </script>
@endpush
