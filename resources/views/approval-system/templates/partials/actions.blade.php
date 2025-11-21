<div class="flex items-center justify-center gap-1">
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Template"
        onclick="editTemplate({{ $template->id }})"
    />

    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Template"
        onclick="deleteTemplate({{ $template->id }})"
    />
</div>
