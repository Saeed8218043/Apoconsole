@php
    $toolbarButtonMarginClass = "ms-1 ms-lg-3";
    $toolbarButtonHeightClass = "w-30px h-30px w-md-40px h-md-40px";
    $toolbarUserAvatarHeightClass = "symbol-30px symbol-md-40px";
    $toolbarButtonIconSizeClass = "svg-icon-1";
@endphp





<div class="d-flex align-items-stretch" id="kt_header_nav">
		@if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
        @endif
        @if(Session::has('success'))
            <p class="alert alert-success">{{ Session::get('success') }}</p>
        @endif
        				</div>







<!--begin::Toolbar wrapper-->
<div class="d-flex align-items-stretch flex-shrink-0">

    <!--begin::Search-->

    <!--end::Search-->

    <!--begin::Activities-->
    <!--<div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}">-->

    <!--    <div class="btn btn-icon btn-active-light-primary {{ $toolbarButtonHeightClass }}" id="kt_activities_toggle">-->
    <!--        <i class="bi bi-bell fs-2"></i>-->
    <!--    </div>-->

    <!--</div>-->
    <!--end::Activities-->

    <!--begin::Quick links-->
    <!--<div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}">-->

    <!--    <div class="btn btn-icon btn-active-light-primary {{ $toolbarButtonHeightClass }}" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">-->
    <!--        <i class="bi bi-clipboard-check fs-2"></i>-->
    <!--    </div>-->


    <!--</div>-->
    <!--end::Quick links-->

    <!--begin::Chat-->
    <!--<div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}">-->

    <!--    <div class="btn btn-icon btn-active-light-primary position-relative {{ $toolbarButtonHeightClass }} pulse pulse-success" id="kt_drawer_chat_toggle">-->
    <!--        <i class="bi bi-app-indicator fs-2"></i>-->
    <!--        <span class="pulse-ring w-45px h-45px"></span>-->
    <!--    </div>-->

    <!--</div>-->
    <!--end::Chat-->

    <!--begin::Notifications-->
    <!--<div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}">-->

    <!--    <div class="btn btn-icon btn-active-light-primary position-relative {{ $toolbarButtonHeightClass }}" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">-->
    <!--        <i class="bi bi-grid fs-2"></i>-->
    <!--    </div>-->


    <!--</div>-->
    <!--end::Notifications-->

    <!--begin::User-->
    <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}" id="">
        <div class="cursor-pointer topbar_icon">
            <img src="{{ asset(theme()->getMediaUrlPath() . 'icons/moon.svg') }}" alt="image"/>
        </div>
    </div>

    <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}" id="kt_header_user_menu_toggle">
        <div class="cursor-pointer user_avatar_one" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="{{ (theme()->isRtl() ? "bottom-start" : "bottom-end") }}">
            <img src="{{ auth()->user()->image_url }}" alt="image" class="img-fluid rounded-circle"/>
        </div>
        {{ theme()->getView('partials/topbar/_user-menu') }}
    </div>
    <!--end::User -->

    <!--begin::Heaeder menu toggle-->
    <!-- Hiding this one as it currently has no functionality -->
    <div class="d-none">
    @if(theme()->getOption('layout', 'header/left') === 'menu')

            <div class="d-flex align-items-center d-lg-none ms-2" title="Show header menu">
                <div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
                    {!! theme()->getSvgIcon("icons/duotune/text/txt001.svg", "svg-icon-1") !!}
                </div>
            </div>

    @endif
    </div>
    <!--end::Heaeder menu toggle-->
</div>
<!--end::Toolbar wrapper-->
