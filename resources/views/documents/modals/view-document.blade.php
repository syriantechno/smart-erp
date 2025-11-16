<x-modal.form id="view-document-modal" title="Document Details" size="lg">
    <div class="space-y-4">
        <div>
            <h3 id="view-doc-title" class="text-lg font-semibold text-slate-800 dark:text-slate-100">
                <!-- Filled by JS -->
            </h3>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400 flex flex-wrap items-center gap-2">
                <span id="view-doc-code" class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 dark:bg-darkmode-600 dark:text-slate-200 text-[11px]"></span>
                <span id="view-doc-type" class="inline-flex items-center px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[11px]"></span>
                <span id="view-doc-status" class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px]"></span>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 text-sm">
            <div class="col-span-12 md:col-span-6 space-y-1">
                <div class="flex items-center text-slate-600 dark:text-slate-300">
                    <x-base.lucide icon="User" class="w-4 h-4 mr-2" />
                    <span id="view-doc-uploader">-</span>
                </div>
                <div class="flex items-center text-slate-600 dark:text-slate-300">
                    <x-base.lucide icon="Building2" class="w-4 h-4 mr-2" />
                    <span id="view-doc-company">-</span>
                </div>
                <div class="flex items-center text-slate-600 dark:text-slate-300">
                    <x-base.lucide icon="Layers" class="w-4 h-4 mr-2" />
                    <span id="view-doc-department">-</span>
                </div>
            </div>
            <div class="col-span-12 md:col-span-6 space-y-1">
                <div class="flex items-center text-slate-600 dark:text-slate-300">
                    <x-base.lucide icon="Calendar" class="w-4 h-4 mr-2" />
                    <span id="view-doc-created">-</span>
                </div>
                <div class="flex items-center text-slate-600 dark:text-slate-300">
                    <x-base.lucide icon="CalendarClock" class="w-4 h-4 mr-2" />
                    <span id="view-doc-expiry">-</span>
                </div>
                <div class="flex items-center text-slate-600 dark:text-slate-300">
                    <x-base.lucide icon="HardDrive" class="w-4 h-4 mr-2" />
                    <span id="view-doc-size">-</span>
                </div>
            </div>
        </div>

        <div class="text-sm">
            <x-base.form-label>Description</x-base.form-label>
            <p id="view-doc-description" class="mt-1 text-slate-600 dark:text-slate-300 whitespace-pre-line">
                -
            </p>
        </div>
    </div>

    @slot('footer')
        <div class="flex justify-between items-center w-full">
            <div class="text-xs text-slate-500 dark:text-slate-400" id="view-doc-access">
                <!-- Access level info -->
            </div>
            <div class="flex gap-2">
                <x-base.button
                    class="w-28"
                    type="button"
                    variant="outline-secondary"
                    data-tw-dismiss="modal"
                >
                    Close
                </x-base.button>
                <x-base.button
                    class="w-32"
                    type="button"
                    id="view-doc-download-btn"
                    variant="primary"
                >
                    <x-base.lucide icon="Download" class="w-4 h-4 mr-2" />
                    Download
                </x-base.button>
            </div>
        </div>
    @endslot
</x-modal.form>
