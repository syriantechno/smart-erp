<div class="flex items-center gap-2 justify-center">
    <x-base.button
        variant="outline-primary"
        size="sm"
        title="View"
        onclick="viewVendor({{ $vendor->id }})"
    >
        <x-base.lucide icon="Eye" class="w-4 h-4" />
    </x-base.button>
    <x-base.button
        variant="outline-warning"
        size="sm"
        title="Edit"
        onclick="editVendor({{ $vendor->id }})"
    >
        <x-base.lucide icon="Pencil" class="w-4 h-4" />
    </x-base.button>
    <x-base.button
        variant="outline-danger"
        size="sm"
        title="Delete"
        onclick="deleteVendor({{ $vendor->id }})"
    >
        <x-base.lucide icon="Trash2" class="w-4 h-4" />
    </x-base.button>
</div>
