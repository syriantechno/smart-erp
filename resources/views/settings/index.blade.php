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
            <div class="container mx-auto px-4 lg:px-0">
                <!-- General Settings Tab -->
                <div class="settings-content intro-y" id="general-content">
                    @include('settings.partials.general')
                </div>

                <!-- Company Settings Tab -->
                <div class="settings-content hidden intro-y" id="company-content">
                    @include('settings.partials.company')
                </div>

                <!-- Prefix Settings Tab -->
                <div class="settings-content hidden intro-y" id="prefix-content">
                    @include('settings.partials.prefix')
                </div>

                <!-- Notifications Settings Tab -->
                <div class="settings-content hidden intro-y" id="notifications-content">
                    @include('settings.partials.notifications')
                </div>

                 <!-- AI Settings Tab -->
                <div class="settings-content hidden intro-y" id="ai-content">
                    @include('settings.partials.ai')
                </div>

                <!-- Permissions Settings Tab -->
                <div class="settings-content hidden intro-y" id="permissions-content">
                    @include('settings.partials.permissions')
                </div>

                <!-- Taxes Settings Tab -->
                <div class="settings-content hidden intro-y" id="taxes-content">
                    @include('settings.partials.taxes')
                </div>

                <!-- Email Settings Tab -->
                <div class="settings-content hidden intro-y" id="email-content">
                    @include('settings.partials.email')
                </div>

                <!-- Appearance Settings Tab -->
                <div class="settings-content hidden intro-y" id="appearance-content">
                    @include('settings.partials.appearance')
                </div>

                <!-- Attendance Settings Tab -->
                <div class="settings-content hidden intro-y" id="attendance-content">
                    @include('settings.partials.attendance')
                </div>

                <!-- Expiry Notifications Settings Tab -->
                <div class="settings-content hidden intro-y" id="expiry-notifications-content">
                    @include('settings.partials.expiry-notifications')
                </div>
            </div>
        </div>
    </div>

    @include('settings.partials.scripts')
@endsection
