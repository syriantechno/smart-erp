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
                },
                dataSrc: function(json) {
                    console.log('DataTable Response:', json);
                    return json.data || [];
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTable AJAX Error:', error, thrown, xhr.responseText);
                }
            },
            pageLength,
            columns,
            lengthChange: false,
            searching: false,
            deferRender: true,
            stateSave: true,
            stateDuration: 300,
            dom:
                "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
            language: {
                processing: '<div class="flex items-center justify-center py-4"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div><span class="ml-2">Loading...</span></div>',
                emptyTable: '<div class="text-center py-8 text-slate-500"><i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 opacity-50"></i><p>No data available</p></div>',
                zeroRecords: '<div class="text-center py-8 text-slate-500"><i data-lucide="search" class="w-12 h-12 mx-auto mb-3 opacity-50"></i><p>No matching records found</p></div>'
            },
            drawCallback: function () {
                // Re-render Lucide icons after table draw
                if (typeof window.lucide !== 'undefined' && typeof window.lucide.createIcons === 'function') {
                    window.lucide.createIcons({
                        'stroke-width': 1.5,
                        nameAttr: 'data-lucide'
                    });
                }
            }
        });
    },

    /**
     * Render a unified status badge similar to Midone demo tables.
     * @param {boolean|number|string} value - Truthy = active
     * @param {Object} [options]
     * @param {Object} [options.labels]
     * @param {string} [options.labels.active]
     * @param {string} [options.labels.inactive]
     * @returns {string}
     */
    renderStatusBadge(value, options = {}) {
        const isActive = Boolean(value);
        const labels = Object.assign({ active: 'Active', inactive: 'Inactive' }, options.labels || {});
        const colorClasses = isActive ? 'text-lime-600' : 'text-rose-500';
        const iconSvg = isActive
            ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/><path d="M19 5v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>';

        return `
            <span class="inline-flex items-center text-base font-semibold ${colorClasses}">
                ${iconSvg}
                ${isActive ? labels.active : labels.inactive}
            </span>
        `;
    },

    /**
     * Render unified action buttons with animations.
     * @param {Object} data - Row data
     * @param {string} data.id - Record ID
     * @param {string} data.name - Record name for delete confirmation
     * @param {Object} [options]
     * @param {function} [options.editUrl] - Function to get edit URL
     * @param {function} [options.viewUrl] - Function to get view URL
     * @param {boolean} [options.canEdit=true]
     * @param {boolean} [options.canDelete=true]
     * @param {boolean} [options.canView=true]
     * @returns {string}
     */
    renderActionButtons(data, options = {}) {
        const {
            editUrl = (id) => `javascript:void(0)`,
            viewUrl = (id) => `javascript:void(0)`,
            canEdit = true,
            canDelete = true,
            canView = false
        } = options;

        let buttons = [];

        if (canView && viewUrl) {
            buttons.push(`
                <button class="btn-action btn-secondary" onclick="window.location.href='${viewUrl(data.id)}'" title="View">
                    <i data-lucide="Eye" class="w-4 h-4"></i>
                    View
                </button>
            `);
        }

        if (canEdit && editUrl) {
            buttons.push(`
                <button class="btn-action btn-primary" onclick="window.location.href='${editUrl(data.id)}'" title="Edit">
                    <i data-lucide="Edit" class="w-4 h-4"></i>
                    Edit
                </button>
            `);
        }

        if (canDelete) {
            buttons.push(`
                <button class="btn-action btn-danger" onclick="window.deleteDepartment('${data.id}', '${data.name || 'item'}')" title="Delete">
                    <i data-lucide="Trash2" class="w-4 h-4"></i>
                    Delete
                </button>
            `);
        }

        return `<div class="flex gap-2">${buttons.join('')}</div>`;
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
                            // Refresh notifications
                            if (typeof window.refreshNotifications === 'function') {
                                window.refreshNotifications();
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
