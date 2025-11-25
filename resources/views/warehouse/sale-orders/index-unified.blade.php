@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Sale Orders - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Sale Orders</h2>
        <button
            id="open-create-so-modal"
            class="btn-royal btn-royal--gold btn-royal--sm"
            data-tw-toggle="modal"
            data-tw-target="#create-so-modal"
        >
            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" />
            Add Sale Order
        </button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Sale Orders Table -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table id="sale-orders-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Title</th>
                                    <th>Customer</th>
                                    <th>Warehouse</th>
                                    <th>Order Date</th>
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

    <!-- Unified Invoice Modal for Sale Orders -->
    <x-invoice.unified-form 
        id="create-so-modal" 
        title="Create Sale Order" 
        type="sale_order"
        :customers="$customers ?? []"
        :warehouses="$warehouses ?? []"
        :materials="$materials ?? []"
    />

    @include('components.datatable.scripts')

    <script>
        let saleOrdersTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) return;

            jq(document).ready(function () {
                initializeSaleOrdersTable();
            });
        });

        function initializeSaleOrdersTable() {
            saleOrdersTable = window.erpCrud.initDataTable({
                tableSelector: '#sale-orders-table',
                ajaxUrl: '{{ route("warehouse.sale-orders.datatable") }}',
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'warehouse_name', name: 'warehouse_name' },
                    { data: 'order_date', name: 'order_date' },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25
            });
        }
    </script>
@endsection
