<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-6 px-3 fs-6 w-275px" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-2">
        <div class="menu-content d-flex align-items-center p-0">
            <!--begin::Avatar-->
            <div class="user_avatar_one me-2">
                <img src="{{ auth()->user()->image_url }}" alt="image" class="img-fluid rounded-circle"/>
            </div>
            <!--end::Avatar-->

            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bolder d-flex align-items-center fs-6">
                    {{ auth()->user()->name }}
                    <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span>
                </div>
                <a href="#" class="fw-bold text-muted text-hover-primary fs-8">{{ auth()->user()->email }}</a>
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->

    <!--begin::Menu item-->
    <div class="menu-item px-2">
        <a href="{{ theme()->getPageUrl('settings.index') }}" class="menu-link px-3">
            <figure class="mb-0 me-2 symbol symbol-20px d-flex align-items-center justify-content-center">
                <i class="bi bi-person-fill"></i>
            </figure>{{ __('My Profile') }}
        </a>
    </div>
    <!--end::Menu item-->


    <!--begin::Menu item-->
    <div class="menu-item px-2 my-1">
        <a href="{{ theme()->getPageUrl('settings.index') }}" class="menu-link px-3">
            <figure class="mb-0 me-2 symbol symbol-20px d-flex align-items-center justify-content-center">
                <i class="bi bi-gear-fill"></i>
            </figure>{{ __('Account Settings') }}
        </a>
    </div>
    <!--end::Menu item-->


    <!--begin::Menu item-->
    <!--<div class="menu-item px-5">-->
    <!--    <a href="#" class="menu-link px-5" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ __('Coming soon') }}">-->
    <!--        <span class="menu-text">{{ __('My Projects') }}</span>-->
    <!--        <span class="menu-badge">-->
    <!--            <span class="badge badge-light-danger badge-circle fw-bolder fs-7">3</span>-->
    <!--        </span>-->
    <!--    </a>-->
    <!--</div>-->
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <!--<div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">-->
    <!--    <a href="#" class="menu-link px-5">-->
    <!--        <span class="menu-title">{{ __('My Subscription') }}</span>-->
    <!--        <span class="menu-arrow"></span>-->
    <!--    </a>-->


    <!--    <div class="menu-sub menu-sub-dropdown w-175px py-4">-->

    <!--        <div class="menu-item px-3">-->
    <!--            <a href="#" class="menu-link px-5">-->
    <!--                {{ __('Referrals') }}-->
    <!--            </a>-->
    <!--        </div>-->

    <!--        <div class="menu-item px-3">-->
    <!--            <a href="#" class="menu-link px-5">-->
    <!--                {{ __('Billing') }}-->
    <!--            </a>-->
    <!--        </div>-->

    <!--        <div class="menu-item px-3">-->
    <!--            <a href="#" class="menu-link px-5">-->
    <!--                {{ __('Payments') }}-->
    <!--            </a>-->
    <!--        </div>-->

    <!--        <div class="menu-item px-3">-->
    <!--            <a href="#" class="menu-link d-flex flex-stack px-5">-->
    <!--                {{ __('Statements') }}-->

    <!--                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="View your statements"></i>-->
    <!--            </a>-->
    <!--        </div>-->

    <!--        <div class="separator my-2"></div>-->

    <!--        <div class="menu-item px-3">-->
    <!--            <div class="menu-content px-3">-->
    <!--                <label class="form-check form-switch form-check-custom form-check-solid">-->
    <!--                    <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications"/>-->
    <!--                    <span class="form-check-label text-muted fs-7">-->
    <!--                        {{ __('Notifications') }}-->
    <!--                    </span>-->
    <!--                </label>-->
    <!--            </div>-->
    <!--        </div>-->

    <!--    </div>-->

    <!--</div>-->
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <!--<div class="menu-item px-5" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ __('Coming soon') }}">-->
    <!--    <a href="#" class="menu-link px-5">-->
    <!--        {{ __('My Statements') }}-->
    <!--    </a>-->
    <!--</div>-->
    <!--end::Menu item-->

    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->

    <!--begin::Menu item-->

    <!--end::Menu item-->



    <!--begin::Menu item-->
    <div class="menu-item px-2">
        <a href="#" data-action="{{ theme()->getPageUrl('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}" data-reload="true" class="button-ajax menu-link px-3">
            <figure class="mb-0 me-2 symbol symbol-20px d-flex align-items-center justify-content-center">
                <i class="bi bi-door-closed-fill"></i>
            </figure>{{ __('Sign Out') }}
        </a>
    </div>
    <!--end::Menu item-->

    @if (theme()->isDarkModeEnabled())
        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->

        <!--begin::Menu item-->
        <div class="menu-item px-2">
            <div class="menu-content px-3">
                <label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success" for="kt_user_menu_dark_mode_toggle">
                    <input class="form-check-input w-30px h-20px" type="checkbox" value="1" name="skin" id="kt_user_menu_dark_mode_toggle" {{ theme()->isDarkMode() ? 'checked' : '' }} data-kt-url="{{ theme()->getPageUrl('', '', theme()->isDarkMode() ? '' : 'dark') }}"/>
                    <span class="pulse-ring ms-n1"></span>

                    <span class="form-check-label text-gray-600 fs-7">
                        {{ __('Dark Mode') }}
                    </span>
                </label>
            </div>
        </div>
        <!--end::Menu item-->
    @endif
</div>
<!--end::Menu-->
