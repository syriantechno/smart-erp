@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Settings - ERP System</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')
    <div class="grid grid-cols-12 gap-6">
        <!-- Sidebar -->
        <div class="col-span-12 lg:col-span-3">
            @include('settings.partials.sidebar')
        </div>

        <!-- Content Area -->
        <div class="col-span-12 lg:col-span-9">
            <!-- General Settings Tab -->
            <div class="settings-content" id="general-content">
                @include('settings.partials.general')
            </div>

            <!-- Appearance Settings Tab -->
            <div class="settings-content hidden" id="appearance-content">
                @include('settings.partials.appearance')
            </div>

            <!-- Company Settings Tab -->
            <div class="settings-content hidden" id="company-content">
                @include('settings.partials.company')
            </div>

            <!-- Prefix Settings Tab -->
            <div class="settings-content hidden" id="prefix-content">
                @include('settings.partials.prefix')
            </div>

            <!-- Notifications Settings Tab -->
            <div class="settings-content hidden" id="notifications-content">
                @include('settings.partials.notifications')
            </div>

            <!-- Email Settings Tab -->
            <div class="settings-content hidden" id="email-content">
                @include('settings.partials.email')
            </div>
        </div>
    </div>

    @include('settings.partials.scripts')
@endsection
