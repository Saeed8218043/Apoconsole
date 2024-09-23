           
                   <!-- <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_coupon">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                            </svg>
                        </span>
                        Add Inventory
                    </button> -->

                     <div class="modal fade" id="kt_modal_add_coupon" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Add Inventory</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_coupon">
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
                                    <form id="kt_modal_add_coupon_form" action="{{ route('inventoryprice.store') }}" enctype="multipart/form-data"
                                        class="form" method="post">
                                        <!--begin::Scroll-->
                                        @csrf
                                        <div class="d-flex flex-column scroll-y"
                                            id="kt_modal_add_credits_scroll" data-kt-scroll="true"
                                            data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_credits_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_credits_scroll"
                                            data-kt-scroll-offset="300px">
                                            
                                            
                                             <div class=" mb-6">
                    <!--begin::Label-->
                    <label class=" col-form-label fw-bold fs-6">
                        <span class="required">{{ __('Vendor') }}</span>

                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('Select Vendor on which inventory you want to apply setting') }}"></i>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class=" fv-row">
                        <select name="vendor" onchange="KTUsersList.reinit()" aria-label="{{ __('Select a Vendor') }}" data-control="select2" data-placeholder="{{ __('Select a Vendor...') }}" class="form-select form-select-solid form-select-lg fw-bold">
                         
                           <option value="1"  selected  >TRQ</option>
                         </select>          
                    </div>
                    <!--end::Col-->
                </div>
                                         
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                
                                               <div class="form-check form-switch">
                                                   <label class="form-check-label" for="flexSwitchCheckDefault">Accept Price Master Rule</label>
                                                    <input class="form-check-input" type="checkbox" name="pricemasterrule" checked >
  
                                                    </div>
                                            </div>
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Part Number</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="part_no"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Type..."  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">SKU</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="sku"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Type..."  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">Cost</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="cost"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Type..."  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                             <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">Quantity</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="qty"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Type..."  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">Fee</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="fee"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Type..."  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">Commission</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="commission"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Type..."  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">Shipping</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="shipping"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Type..."  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">Profit</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="profit"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Type..."  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                        
                                          
                                           
                                         

                                            
                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_add_coupon">Discard</button>
                                            <button type="submit" class="btn btn-primary" id="kt_docs_formvalidation_text_submit" 
                                                data-kt-users-modal-action="submit">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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


                 