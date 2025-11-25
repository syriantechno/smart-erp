{{-- Documents Tab --}}
@php
    $documents = collect();
    $categories = [
        ['name' => 'Contracts', 'icon' => 'file-text', 'color' => 'blue', 'count' => 0],
        ['name' => 'Reports', 'icon' => 'bar-chart-2', 'color' => 'green', 'count' => 0],
        ['name' => 'Designs', 'icon' => 'palette', 'color' => 'amber', 'count' => 0],
        ['name' => 'Specifications', 'icon' => 'clipboard-list', 'color' => 'purple', 'count' => 0],
        ['name' => 'Legal', 'icon' => 'shield', 'color' => 'red', 'count' => 0],
        ['name' => 'Other', 'icon' => 'folder', 'color' => 'slate', 'count' => 0],
    ];
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Project Documents</h2>
            <p class="text-sm text-slate-500 mt-1">All files and documents related to this project</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all" onclick="document.getElementById('folder-modal').classList.remove('hidden')">
                <x-base.lucide icon="folder-plus" class="w-4 h-4 mr-2" /> New Folder
            </button>
            <button class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all" onclick="document.getElementById('file-input').click()">
                <x-base.lucide icon="upload" class="w-4 h-4 mr-2" /> Upload Files
            </button>
            <input type="file" id="file-input" class="hidden" multiple onchange="handleFileUpload(this.files)">
        </div>
    </div>

    {{-- Document Categories --}}
    <div class="grid grid-cols-6 gap-4">
        @foreach($categories as $cat)
        <div class="rounded-2xl bg-white p-5 shadow-lg border border-slate-200/60 cursor-pointer hover:shadow-xl hover:-translate-y-1 transition-all group">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-{{ $cat['color'] }}-400 to-{{ $cat['color'] }}-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                <x-base.lucide icon="{{ $cat['icon'] }}" class="w-6 h-6 text-white" />
            </div>
            <div class="text-sm font-semibold text-[#303030]">{{ $cat['name'] }}</div>
            <div class="text-xs text-slate-500 mt-1">{{ $cat['count'] }} files</div>
        </div>
        @endforeach
    </div>

    {{-- Upload Area --}}
    <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-gradient-to-br from-slate-50 to-white p-10 text-center hover:border-slate-400 transition-all" 
         ondragover="event.preventDefault(); this.classList.add('border-blue-500', 'bg-blue-50');" 
         ondragleave="this.classList.remove('border-blue-500', 'bg-blue-50');"
         ondrop="event.preventDefault(); this.classList.remove('border-blue-500', 'bg-blue-50'); handleFileUpload(event.dataTransfer.files);">
        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
            <x-base.lucide icon="cloud-upload" class="w-8 h-8 text-slate-400" />
        </div>
        <p class="text-slate-700 font-semibold">Drag and drop files here</p>
        <p class="text-sm text-slate-400 mt-1">or click to browse from your computer</p>
        <button class="mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all" onclick="document.getElementById('file-input').click()">
            <x-base.lucide icon="folder-open" class="w-4 h-4 inline mr-2" /> Select Files
        </button>
        <p class="text-xs text-slate-400 mt-4">Supported: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG (Max 50MB)</p>
    </div>

    {{-- Recent Documents --}}
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden border border-slate-200/60">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <h3 class="text-lg font-semibold text-[#303030]">All Documents</h3>
            <div class="flex items-center gap-2">
                <div class="relative">
                    <x-base.lucide icon="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input type="text" placeholder="Search documents..." class="h-9 pl-9 pr-4 rounded-full border border-slate-200 text-sm focus:outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                </div>
                <select class="h-9 px-3 rounded-full border border-slate-200 text-sm focus:outline-none focus:border-slate-400">
                    <option>All Types</option>
                    <option>PDF</option>
                    <option>Word</option>
                    <option>Excel</option>
                    <option>Images</option>
                </select>
            </div>
        </div>
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase">Name</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase">Category</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase">Uploaded By</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase">Date</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-slate-600 uppercase">Size</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                            <x-base.lucide icon="file-x" class="w-8 h-8 text-slate-400" />
                        </div>
                        <p class="text-slate-600 font-medium">No documents uploaded yet</p>
                        <p class="text-sm text-slate-400 mt-1">Upload your first document to get started</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Storage Info --}}
    <div class="rounded-2xl bg-gradient-to-r from-slate-800 to-slate-900 p-5 flex items-center justify-between text-white">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                <x-base.lucide icon="hard-drive" class="w-6 h-6 text-white" />
            </div>
            <div>
                <div class="font-semibold">Storage Used</div>
                <div class="text-sm text-slate-300"><strong>0 MB</strong> of <strong>5 GB</strong></div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-48 h-3 bg-white/20 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-green-400 to-green-500 rounded-full" style="width: 0%"></div>
            </div>
            <span class="text-sm font-medium">0%</span>
        </div>
    </div>
</div>

<script>
function handleFileUpload(files) {
    if (files.length > 0) {
        // Show upload progress
        const fileNames = Array.from(files).map(f => f.name).join(', ');
        if (typeof showInfo === 'function') {
            showInfo('Uploading: ' + fileNames);
        }
        // TODO: Implement actual file upload via AJAX
        console.log('Files to upload:', files);
    }
}
</script>
