 <div class="modal fade" id="kt_modal_edit_price_update" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Edit Inventory</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_edit_price_update">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                    transform="rotate(45 7.41422 6)" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y mx-3 mx-xl-5 my-3">
                                      <!--begin::Form-->
        <form id="kt_price_setting_form" class="form" method="POST" action="{{ route('pricesetting.store') }}" enctype="multipart/form-data">
        @csrf


                        <input type="hidden" name="vendor_id" />

        <!--begin::Card body-->
            <div class="card-body p-0">






                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span class="required">{{ __('Vendor') }}</span>

                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('Select Vendor on which inventory you want to apply setting') }}"></i>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text"   name="vendor" disabled class="form-control form-control-lg form-control-solid" placeholder="Enter Max Quantity (for shopify display)" value="{{ old('fee', $info->fee ?? '') }}"/>

                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->



                 <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Max Quantity (for shopify display)') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row d-flex ">


            <input type="number"   name="max_qty" class="form-control form-control-lg form-control-solid" placeholder="Enter Max Quantity (for shopify display)" value="{{ old('fee', $info->fee ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->



                  <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Fee') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row d-flex ">


            <input type="number"   step="0.01" onkeyup="tp_update()"  name="fee" class="form-control form-control-lg form-control-solid" placeholder="Enter Fee in Percentage of Original Cost" value="{{ old('fee', $info->fee ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->


                  <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Commission') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="number"  step="0.01" onkeyup="tp_update()"  name="commission" class="form-control form-control-lg form-control-solid" placeholder="Enter Commission in Percentage of Original Cost" value="{{ old('commission', $info->commission ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->


                  <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Shipping') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="number"  step="0.01" onkeyup="tp_update()"  name="shipping" class="form-control form-control-lg form-control-solid" placeholder="Enter Shipping in Percentage of Original Cost" value="{{ old('shipping', $info->shipping ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                    <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Price Percentage') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="number"   onkeyup="tp_update()"  name="price_percentage" class="form-control form-control-lg form-control-solid" placeholder="Enter Price per unit in Percentage of Cost" value="{{ old('price_percentage', $info->price_percentage ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->


                  <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Profit') }}</label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="number"  step="0.01" onkeyup="tp_update()"  name="profit" class="form-control form-control-lg form-control-solid" placeholder="Enter Profit in Percentage of Original Cost" value="{{ old('profit', $info->profit ?? '') }}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->




                  <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6 ">Total Price Would be: </label>
                    <!--end::Label-->
                    <div class="col-lg-8 fv-row">
                    <p class="col-lg-4 col-form-label fw-bold fs-6 tp">100%</p>
                        </div>
                </div>
                <!--end::Input group-->






            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer border-top-0 d-flex justify-content-end p-0">
                <!--<button type="reset" class="btn btn-white btn-active-light-primary me-2">{{ __('Discard') }}</button>-->

                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                    @include('partials.general._button-indicator', ['label' => __('Apply Now')])
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
