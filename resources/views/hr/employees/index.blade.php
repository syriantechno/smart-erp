@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Employees Management - ERP System</title>
@endsection

@section('subcontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-users"></i> Employees Management
                        </h6>
                        <div class="flex">
                            <x-base.button
                                href="{{ route('hr.employees.export') }}"
                                class="ml-2"
                                variant="outline-secondary"
                            >
                                <x-base.lucide
                                    class="mr-2 h-4 w-4"
                                    icon="FileText"
                                />
                                Export
                            </x-base.button>
                            <x-base.button
                                type="button"
                                data-tw-toggle="modal"
                                data-tw-target="#create-employee-modal"
                                variant="primary"
                            >
                                <x-base.lucide icon="UserPlus" class="w-4 h-4 mr-2" />
                                Add Employee
                            </x-base.button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Employee table content here -->
                        <div class="text-center text-gray-500 py-4">
                            <p>No data available</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('hr.employees.modals.create')
@endsection
