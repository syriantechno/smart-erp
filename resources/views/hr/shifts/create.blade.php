@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Add New Shift - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Add New Shift</h2>
        <a href="{{ route('hr.shifts.index') }}" class="btn btn-outline-secondary">
            <x-base.lucide icon="ArrowLeft" class="w-4 h-4 mr-2" />
            Back to List
        </a>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    @if (session('success'))
                        <x-base.alert class="mb-4" variant="success">
                            <div class="flex items-center">
                                <x-base.lucide icon="CheckCircle" class="w-5 h-5 mr-2" />
                                {{ session('success') }}
                            </div>
                        </x-base.alert>
                    @endif

                    @if (session('error'))
                        <x-base.alert class="mb-4" variant="danger">
                            <div class="flex items-center">
                                <x-base.lucide icon="AlertTriangle" class="w-5 h-5 mr-2" />
                                {{ session('error') }}
                            </div>
                        </x-base.alert>
                    @endif

                    @include('hr.shifts.modals.create')
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

@include('components.datatable.scripts')
