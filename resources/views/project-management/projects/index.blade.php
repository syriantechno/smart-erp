@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Projects Management - {{ config('app.name') }}</title>
@endsection

@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <h2 class="intro-y text-lg font-medium mt-10">Projects Management</h2>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <!-- Placeholder content -->
                <div class="intro-y col-span-12">
                    <div class="alert alert-primary show mb-2">
                        Projects management view will be implemented here
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
