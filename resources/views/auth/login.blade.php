<x-auth-layout>

    <!--begin::Signin Form-->
    <form method="POST" action="{{ theme()->getPageUrl('login') }}" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
    @csrf

    <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark mb-3">
                {{ __('Sign In') }}
            </h1>
            <!--end::Title-->
        </div>
        <!--begin::Heading-->


        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label text-dark">{{ __('Email') }}</label>
            <!--end::Label-->

            <!--begin::Input-->
            <input class="form-control form-control-lg form-control-solid" type="email" name="email" autocomplete="off" value="{{ old('email', '') }}" required autofocus/>
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Wrapper-->
            <div class="mb-2">
                <!--begin::Label-->
                <label class="form-label text-dark">{{ __('Password') }}</label>
                <!--end::Label-->

                <!--begin::Link-->
                @if (Route::has('password.request'))
                    <!--<a href="{{ theme()->getPageUrl('password.request') }}" class="link-primary fs-6 fw-bolder">-->
                    <!--    {{ __('Forgot Password ?') }}-->
                    <!--</a>-->
            @endif
            <!--end::Link-->
            <!--begin::Input-->
            <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" value="" required/>
            <!--end::Input-->
            </div>
            <!--end::Wrapper-->


        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <label class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" name="remember"/>
                <span class="form-check-label fw-bold text-gray-700 fs-6">{{ __('Remember me') }}
            </span>
            </label>
        </div>
        <!--end::Input group-->

        <!--begin::Actions-->
        <div class="text-center">
            <!--begin::Submit button-->
            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                @include('partials.general._button-indicator', ['label' => __('Continue')])
            </button>
            <!--end::Submit button-->

            <!--begin::Separator-->
            <!--<div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>-->
            <!--end::Separator-->

            <!--begin::Google link-->
            <!--<a href="{{ url('/auth/redirect/google') }}?redirect_uri={{ url()->previous() }}" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">-->
            <!--    <img alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'svg/brand-logos/google-icon.svg') }}" class="h-20px me-3"/>-->
            <!--    {{ __('Continue with Google') }}-->
            <!--</a>-->

            <!--<a href="{{ url('/auth/redirect/facebook') }}?redirect_uri={{ url()->previous() }}" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">-->
            <!--    <img alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'svg/brand-logos/facebook-4.svg') }}" class="h-20px me-3"/>-->
            <!--    {{ __('Continue with Facebook') }}-->
            <!--</a>-->
            <!--end::Facebook link-->
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Signin Form-->

</x-auth-layout>
