<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Category"
        onclick="editCategory({{ $category->id }})"
    />

    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Category"
        onclick="deleteCategory({{ $category->id }}, '{{ addslashes($category->name) }}')"
    />
</div>
