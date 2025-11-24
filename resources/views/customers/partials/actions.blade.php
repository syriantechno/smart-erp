<div class="flex items-center justify-center gap-2">
    <x-base.tippy content="View customer" placement="top">
        <button type="button" class="btn-royal btn-royal--info btn-royal--icon group" onclick="viewCustomer({{ $customer->id }})">
            <x-base.lucide icon="eye" class="w-4 h-4 icon-hover-rise" />
        </button>
    </x-base.tippy>
    <x-base.tippy content="Edit customer" placement="top">
        <button type="button" class="btn-royal btn-royal--warning btn-royal--icon group" onclick="editCustomer({{ $customer->id }})">
            <x-base.lucide icon="edit" class="w-4 h-4 icon-hover-rise" />
        </button>
    </x-base.tippy>
    <x-base.tippy content="Delete customer" placement="top">
        <button type="button" class="btn-royal btn-royal--danger btn-royal--icon group" onclick="deleteCustomer({{ $customer->id }})">
            <x-base.lucide icon="trash-2" class="w-4 h-4 icon-hover-rise" />
        </button>
    </x-base.tippy>
</div>
