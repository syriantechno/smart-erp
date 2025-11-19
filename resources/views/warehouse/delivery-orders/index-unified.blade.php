@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Delivery Orders - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Delivery Orders</h2>
        <button
            id="open-create-do-modal"
            class="btn-tonal btn-tonal--success"
            data-tw-toggle="modal"
            data-tw-target="#create-do-modal"
        >
            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" />
            Add Delivery Order
        </button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Delivery Orders Table -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table id="delivery-orders-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Title</th>
                                    <th>Customer</th>
                                    <th>Warehouse</th>
                                    <th>Delivery Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <!-- Unified Invoice Modal for Delivery Orders -->
    <x-invoice.unified-form 
        id="create-do-modal" 
        title="Create Delivery Order" 
        type="delivery_order"
        :customers="$customers ?? []"
        :warehouses="$warehouses ?? []"
        :materials="$materials ?? []"
    />

    @include('components.datatable.scripts')

    <script>
        let deliveryOrdersTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) return;

            jq(document).ready(function () {
                initializeDeliveryOrdersTable();
            });
        });

        function initializeDeliveryOrdersTable() {
            deliveryOrdersTable = window.erpCrud.initDataTable({
                tableSelector: '#delivery-orders-table',
                ajaxUrl: '{{ route("warehouse.delivery-orders.datatable") }}',
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'warehouse_name', name: 'warehouse_name' },
                    { data: 'delivery_date', name: 'delivery_date' },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25
            });
        }
    </script>
@endsection
