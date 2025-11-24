<div class="flex items-center justify-center gap-2">
    <x-base.tippy content="View vendor" placement="top">
        <button type="button" class="btn-royal btn-royal--info btn-royal--icon group" onclick="viewVendor({{ $vendor->id }})">
            <x-base.lucide icon="eye" class="w-4 h-4 icon-hover-rise" />
        </button>
    </x-base.tippy>
    <x-base.tippy content="Edit vendor" placement="top">
        <button type="button" class="btn-royal btn-royal--warning btn-royal--icon group" onclick="editVendor({{ $vendor->id }})">
            <x-base.lucide icon="edit" class="w-4 h-4 icon-hover-rise" />
        </button>
    </x-base.tippy>
    <x-base.tippy content="Delete vendor" placement="top">
        <button type="button" class="btn-royal btn-royal--danger btn-royal--icon group" onclick="deleteVendor({{ $vendor->id }})">
            <x-base.lucide icon="trash-2" class="w-4 h-4 icon-hover-rise" />
        </button>
    </x-base.tippy>
</div>
