<x-base-layout>
<!--begin::Basic info-->
<div class="card ">
    <!--begin::Card header-->



    @if(Session::has('success'))
<p class="alert alert-success my-2 mx-2">{{ Session('success') }}</p>
@endif


    <div class="card-header border-0 cursor-pointer" role="button" >
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('Trusted Parts Vendor Settings') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->

    <!--begin::Content-->
    <div id="kt_account_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('trq_settings.store') }}" enctype="multipart/form-data">
        @csrf

        <!--begin::Card body-->

                <div class="card-body">


                <div class="row">
                    <div class="col-xl-6 col-lg-8 col-md-8">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <div class="col-lg-4">
                                <label class="col-form-label fw-bold fs-6">{{ __('UserName / Email') }}</label>
                            </div>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="trq_email" class="form-control form-control-lg form-control-solid" placeholder="Encription Type" value="{{ old('trq_email', \App\Models\Setting::get('trq_email','')) }}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <div class="col-lg-4">
                                <label class="col-form-label fw-bold fs-6">{{ __('Password') }}</label>
                            </div>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="password" name="trq_password" class="form-control form-control-lg form-control-solid" placeholder="Email" value="{{ old('trq_password', 'password') }}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    </div>
                </div>










            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-white btn-active-light-primary me-2">{{ __('Discard') }}</button>

                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                    @include('partials.general._button-indicator', ['label' => __('Save Changes')])
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->


@Section('scripts')
<script>
    function replicate(t){
        if (t.innerText == '-') {
           $(t).parent().parent()[0].remove()
           return 0;
        }

        var a = $(t).parent().parent().clone()[0];
                 $(t).parent().parent().parent().append(a)
        t.innerText = '-'
    }
</script>
@endsection



</x-base-layout>
