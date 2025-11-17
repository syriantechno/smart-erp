// ERP CRUD Helper
// Shared helper functions for initializing DataTables and handling
// create / edit / delete forms via AJAX in a consistent way.

window.erpCrud = {
    /**
     * Initialize a DataTable with unified defaults.
     * @param {Object} options
     * @param {string} options.tableSelector - CSS selector for the table
     * @param {string} options.ajaxUrl - URL for server-side data
     * @param {function} [options.ajaxData] - function(d) to append extra params
     * @param {Array} options.columns - DataTables columns definition
     * @param {number} [options.pageLength] - default page length
     * @returns {DataTable|null}
     */
    initDataTable(options) {
        if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.DataTable) {
            console.error('DataTables is not available');
            return null;
        }

        const $ = window.jQuery;
        const {
            tableSelector,
            ajaxUrl,
            ajaxData,
            columns,
            pageLength = 25,
        } = options;

        return $(tableSelector).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: ajaxUrl,
                type: 'GET',
                data: function (d) {
                    if (typeof ajaxData === 'function') {
                        ajaxData(d);
                    }
                }
            },
            pageLength,
            columns,
            lengthChange: false,
            searching: false,
            dom:
                "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
        });
    },

    /**
     * Attach unified AJAX submit handler for create form.
     * @param {Object} options
     * @param {string} options.formSelector
     * @param {string} [options.modalSelector]
     * @param {function} [options.onSuccess]
     */
    handleCreateForm(options) {
        const form = document.querySelector(options.formSelector);
        if (!form) return;

        const modal = options.modalSelector ? document.querySelector(options.modalSelector) : null;

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(form);

            fetch(form.action, {
                method: form.method || 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData,
            })
                .then(async (response) => {
                    if (response.ok) {
                        return response.json();
                    }

                    if (response.status === 422) {
                        const data = await response.json();
                        const errors = data.errors || {};
                        const firstError = Object.values(errors)[0];
                        if (firstError && typeof window.showToast === 'function') {
                            window.showToast(Array.isArray(firstError) ? firstError[0] : firstError, 'error');
                        }
                        throw new Error('validation');
                    }

                    throw new Error('request');
                })
                .then((data) => {
                    if (data && data.success) {
                        if (typeof window.showToast === 'function') {
                            window.showToast(data.message || 'Saved successfully', 'success');
                        }
                        form.reset();

                        if (modal) {
                            const dismissBtn = modal.querySelector('[data-tw-dismiss="modal"]');
                            if (dismissBtn) dismissBtn.click();
                        }

                        if (typeof options.onSuccess === 'function') {
                            options.onSuccess(data);
                        }
                    } else if (typeof window.showToast === 'function') {
                        window.showToast((data && data.message) || 'Failed to save', 'error');
                    }
                })
                .catch((error) => {
                    if (error.message === 'validation') return;
                    if (typeof window.showToast === 'function') {
                        window.showToast('An error occurred while saving', 'error');
                    }
                });
        });
    },

    /**
     * Attach unified AJAX submit handler for edit form.
     * @param {Object} options
     * @param {string} options.formSelector
     * @param {string} [options.modalSelector]
     * @param {function} [options.onSuccess]
     */
    handleEditForm(options) {
        const form = document.querySelector(options.formSelector);
        if (!form) return;

        const modal = options.modalSelector ? document.querySelector(options.modalSelector) : null;

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(form);

            fetch(form.action, {
                method: form.method || 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData,
            })
                .then(async (response) => {
                    if (response.ok) {
                        return response.json();
                    }

                    if (response.status === 422) {
                        const data = await response.json();
                        const errors = data.errors || {};
                        const firstError = Object.values(errors)[0];
                        if (firstError && typeof window.showToast === 'function') {
                            window.showToast(Array.isArray(firstError) ? firstError[0] : firstError, 'error');
                        }
                        throw new Error('validation');
                    }

                    throw new Error('request');
                })
                .then((data) => {
                    if (data && data.success) {
                        if (typeof window.showToast === 'function') {
                            window.showToast(data.message || 'Updated successfully', 'success');
                        }

                        if (modal) {
                            const dismissBtn = modal.querySelector('[data-tw-dismiss="modal"]');
                            if (dismissBtn) dismissBtn.click();
                        }

                        if (typeof options.onSuccess === 'function') {
                            options.onSuccess(data);
                        }
                    } else if (typeof window.showToast === 'function') {
                        window.showToast((data && data.message) || 'Failed to update', 'error');
                    }
                })
                .catch((error) => {
                    if (error.message === 'validation') return;
                    if (typeof window.showToast === 'function') {
                        window.showToast('An error occurred while updating', 'error');
                    }
                });
        });
    },

    /**
     * Unified delete handler with confirmation.
     * @param {Object} options
     * @param {function} options.urlBuilder - function(id) => url
     * @param {function} [options.onSuccess]
     */
    handleDelete(options) {
        window.erpDeleteRecord = function (id, name) {
            const url = options.urlBuilder(id);

            const doDelete = () => {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.success) {
                            if (typeof window.showToast === 'function') {
                                window.showToast(data.message || 'Deleted successfully', 'success');
                            }
                            if (typeof options.onSuccess === 'function') {
                                options.onSuccess(data);
                            }
                        } else if (typeof window.showToast === 'function') {
                            window.showToast((data && data.message) || 'Failed to delete', 'error');
                        }
                    })
                    .catch(() => {
                        if (typeof window.showToast === 'function') {
                            window.showToast('An error occurred while deleting', 'error');
                        }
                    });
            };

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, doDelete);
            } else {
                if (window.confirm(`Delete ${name}?`)) {
                    doDelete();
                }
            }
        };
    },
};
