<x-base-layout>
<!--begin::Basic info-->
<div class="card">
    <!--begin::Card header-->



    @if(Session::has('success'))
    <p class="alert alert-success my-2 mx-2">{{ Session('success') }}</p>
    @endif


    <div class="card-header border-0 cursor-pointer" role="button" >
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('Perfect Fit Order Settings') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->

    <!--begin::Content-->
    <div id="kt_account_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('pf_order_setting.store') }}" enctype="multipart/form-data">
        @csrf

        <!--begin::Card body-->
            <div class="card-body">


                @php

                    $recipient_emails = \DB::table('settings')->where('key','LIKE','%pf_order_recipient_email%')->get();

                    $x=1;
                    @endphp


                <div class="row">
                    <div class="col-xl-6 col-lg-8">
                @foreach ($recipient_emails as  $key )


                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <div class="col-lg-4">
                        <label class="col-form-label fw-bold fs-6">{{ __('Recipient Email') }}</label>
                    </div>
                    <!--end::Label-->

                    <!--begin::Col-->




                    <div class="col-lg-8 fv-row">

                    <div class="input-group mb-3">
                        <input type="text" name="pf_order_recipient_email[]" class="form-control form-control-lg form-control-solid" placeholder="Smtp Host" aria-label="Smtp Host" aria-describedby="Smtp Host" value="{{ old('pf_order_recipient_email', $key->value) }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary input-group-button" type="button" onclick="replicate(this)" >{{ ($x == count($recipient_emails)) ? '+' : '-' }}</button>
                        </div>
                        </div>
                        <!-- <input type="text" name="pf_order_recipient_email[]" class="form-control form-control-lg form-control-solid" placeholder="Smtp Host" value="{{ old('pf_order_recipient_email', $key->value) }}"/> -->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                @php  $x++; @endphp
                 @endforeach
                 </div>
                </div>

                <hr class="my-10"/>

                 <h5 class="fw-bolder mb-6">{{ __('Sending Email Detail') }}</h5>
                  <!--begin::Input group-->

                   <div class="row">
                    <div class="col-xl-6 col-lg-8">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <div class="col-lg-4">
                                <label class="col-form-label fw-bold fs-6">{{ __('Host') }}</label>
                            </div>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="pf_order_smtp_host" class="form-control form-control-lg form-control-solid" placeholder="Encription Type" value="{{ old('pf_order_smtp_host', \App\Models\Setting::get('pf_order_smtp_host','')) }}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <div class="row mb-6">
                            <!--begin::Label-->
                            <div class="col-lg-4">
                                <label class="col-form-label fw-bold fs-6">{{ __('Email') }}</label>
                            </div>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="pf_order_smtp_email" class="form-control form-control-lg form-control-solid" placeholder="Email" value="{{ old('pf_order_smtp_email', \App\Models\Setting::get('pf_order_smtp_email','')) }}"/>
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
                                <input type="password" name="pf_order_smtp_password" class="form-control form-control-lg form-control-solid" placeholder="Email" value="{{ old('pf_order_smtp_password', \App\Models\Setting::get('pf_order_smtp_password','')) }}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <div class="col-lg-4">
                                <label class="col-form-label fw-bold fs-6">{{ __('Port') }}</label>
                            </div>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="pf_order_smtp_port" class="form-control form-control-lg form-control-solid" placeholder="Port" value="{{ old('pf_order_smtp_port', \App\Models\Setting::get('pf_order_smtp_port','')) }}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <div class="col-lg-4">
                                <label class="col-form-label fw-bold fs-6">{{ __('Type') }}</label>
                            </div>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="pf_order_smtp_type" class="form-control form-control-lg form-control-solid" placeholder="Encription Type" value="{{ old('pf_order_smtp_type', \App\Models\Setting::get('pf_order_smtp_type','')) }}"/>
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
