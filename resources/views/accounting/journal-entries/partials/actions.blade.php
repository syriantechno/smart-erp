<div class="flex items-center justify-center space-x-2">
    <!-- View Journal Entry -->
    <button type="button"
            onclick="viewJournalEntry({{ $entry->id }})"
            class="flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            title="View Journal Entry">
        <x-base.lucide icon="Eye" class="w-3 h-3 mr-1" />
        View
    </button>

    <!-- Edit Journal Entry -->
    @if($entry->status === 'draft')
    <button type="button"
            onclick="editJournalEntry({{ $entry->id }}, '{{ $entry->reference_number }}')"
            class="flex items-center px-2 py-1 text-xs font-medium text-yellow-600 bg-yellow-100 rounded-md hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2"
            title="Edit Journal Entry">
        <x-base.lucide icon="Edit" class="w-3 h-3 mr-1" />
        Edit
    </button>
    @endif

    <!-- Post Journal Entry -->
    @if($entry->status === 'draft' && $entry->is_balanced)
    <button type="button"
            onclick="postJournalEntry({{ $entry->id }}, '{{ $entry->reference_number }}')"
            class="flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            title="Post Journal Entry">
        <x-base.lucide icon="CheckCircle" class="w-3 h-3 mr-1" />
        Post
    </button>
    @endif

    <!-- Void Journal Entry -->
    @if($entry->status === 'posted')
    <button type="button"
            onclick="voidJournalEntry({{ $entry->id }}, '{{ $entry->reference_number }}')"
            class="flex items-center px-2 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            title="Void Journal Entry">
        <x-base.lucide icon="XCircle" class="w-3 h-3 mr-1" />
        Void
    </button>
    @endif
</div>

<script>
// View Journal Entry
window.viewJournalEntry = function(id) {
    console.log('Viewing journal entry:', id);
    showToast('Journal entry details view coming soon', 'info');
};

// Edit Journal Entry
window.editJournalEntry = function(id, reference) {
    console.log('Editing journal entry:', id, reference);
    showToast('Journal entry editing coming soon', 'info');
};

// Post Journal Entry
window.postJournalEntry = function(id, reference) {
    if (confirm('Are you sure you want to post journal entry "' + reference + '"? This action cannot be undone.')) {
        showToast('Posting journal entry...', 'info');
        // Here you would make an API call to post the entry
        console.log('Posting journal entry:', id);
    }
};

// Void Journal Entry
window.voidJournalEntry = function(id, reference) {
    if (confirm('Are you sure you want to void journal entry "' + reference + '"? This action cannot be undone.')) {
        showToast('Voiding journal entry...', 'info');
        // Here you would make an API call to void the entry
        console.log('Voiding journal entry:', id);
    }
};
</script>
