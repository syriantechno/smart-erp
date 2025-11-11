@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('إدارة الأقسام') }} - {{ config('app.name') }}</title>
@endsection

@push('styles')
    @include('components.toast-notifications')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css"/>
    <style>
        #departments-table {
            width: 100% !important;
        }
        .dataTables_wrapper .dt-buttons {
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('subcontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-sitemap"></i> إدارة الأقسام
                        </h6>
                        <div class="flex">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDepartmentModal">
                                <i class="fas fa-plus"></i> إضافة قسم
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="departments-table" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>الشركة</th>
                                        <th>المدير</th>
                                        <th class="text-center">الموظفين</th>
                                        <th class="text-center">الحالة</th>
                                        <th class="text-center">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- سيتم تحميل البيانات عبر AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('hr.departments.modals.create')
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
    
    <!-- DataTables Buttons -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    $(document).ready(function() {
        console.log('جاري تهيئة الجدول...');
        
        try {
            var table = $('#departments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("hr.departments.datatable") }}',
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.error('خطأ في DataTables:', error);
                        showToast('حدث خطأ أثناء تحميل البيانات', 'error');
                    }
                },
                columns: [
                    { 
                        data: 'DT_RowIndex', 
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '5%'
                    },
                    { 
                        data: 'name', 
                        name: 'name',
                        width: '20%'
                    },
                    { 
                        data: 'company',
                        name: 'company',
                        render: function(data) {
                            return data ? data.name : '-';
                        },
                        width: '20%'
                    },
                    { 
                        data: 'manager',
                        name: 'manager',
                        render: function(data) {
                            return data ? data.full_name : '-';
                        },
                        width: '20%'
                    },
                    { 
                        data: 'employees_count',
                        name: 'employees_count',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        width: '10%'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        className: 'text-center',
                        render: function(data) {
                            return data ? 
                                '<span class="badge bg-success">نشط</span>' : 
                                '<span class="badge bg-danger">غير نشط</span>';
                        },
                        width: '10%'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '15%'
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json'
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
                responsive: true,
                order: [[1, 'asc']],
                initComplete: function() {
                    console.log('تم تهيئة الجدول بنجاح');
                }
            });
            
        } catch (error) {
            console.error('خطأ في تهيئة الجدول:', error);
            showToast('حدث خطأ في تهيئة الجدول. يرجى مراجعة وحدة التحكم', 'error');
        }
    });
    
    function showToast(message, type = 'success') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        
        Toast.fire({
            icon: type,
            title: message
        });
    }
    </script>
@endpush
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        className: 'text-center',
                        width: '10%',
                        render: function(data, type, row) {
                            return data ?
                                '<span class="badge bg-success">نشط</span>' :
                                '<span class="badge bg-danger">غير نشط</span>';
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '15%'
                    }
                ],
                order: [[1, 'asc']], // Default sort by name
                drawCallback: function() {
                    // Add any additional callbacks if needed
                },
                initComplete: function() {
                    // Add any initialization complete code here
                }
            });
            
            // Handle row click if needed
            $('#departments-table tbody').on('click', 'tr', function() {
                // Add row click handler if needed
            });
            
        } catch (error) {
            console.error('Error initializing DataTable:', error);
            showToast('حدث خطأ في تهيئة الجدول', 'error');
        }
    });
    
    // Function to show toast messages
    function showToast(message, type = 'success') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        
        Toast.fire({
            icon: type,
            title: message
        });
    }
    </script>
    @endpush
@endsection
