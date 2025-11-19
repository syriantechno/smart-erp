<div class="flex items-center justify-center gap-2">
    <button
        class="btn-tonal btn-tonal--warning btn-tonal--icon"
        onclick="editCategory({{ $category->id }})"
        title="Edit Category"
    >
        <i data-lucide="edit" class="w-4 h-4"></i>
    </button>
    <button
        class="btn-tonal btn-tonal--danger btn-tonal--icon"
        onclick="deleteCategory({{ $category->id }}, '{{ addslashes($category->name) }}')"
        title="Delete Category"
    >
        <i data-lucide="trash-2" class="w-4 h-4"></i>
    </button>
</div>
