           
                   <!-- <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#csv_file">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                            </svg>
                        </span>
                        Add CSV
                    </button> -->

                     <div class="modal fade" id="csv_file" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Add CSV</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#csv_file">
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
                                    <form id="kt_modal_add_csv_form" action="{{ route('inventoryprice.store') }}" enctype="multipart/form-data"
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
                                         
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Select File</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="file" name="file"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Type..."  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            
                                      
                                        
                                          
                                           
                                         

                                            
                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                data-bs-target="#csv_file_button">Discard</button>
                                            <button type="submit" class="btn btn-primary" id="" 
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
                    
                    
                    
                    
                    
                    <!--********************************-->
                      <div class="modal fade" id="csv_table" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Select Field</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#csv_table">
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
                                    <form id="csv_table_form" action="{{ route('inventoryprice.store') }}" enctype="multipart/form-data"
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
                                            
                                             
                                             
                                             
                                             <input type="hidden" name="file_name" >
                                             
                                           
                                            
                                            <div class="row mt-3" >
                                                <div class="col-6" >
                                                    <label class="fw-bold fs-6 mb-2">Accept Price Master Rule</label>
                                                </div>
                                                <div class="col-6" >
                                                    <div class="form-check form-switch" >
                                                   <input class="form-check-input" type="checkbox" name="pricemasterrule" checked  >
                                                   </div>
                                                </div>
                                            </div>
                                            
                                            
                                             <div class="row mt-3" >
                                                <div class="col-6" >
                                                    <label class="fw-bold fs-6 mb-2">Vendor</label>
                                                </div>
                                                <div class="col-6" >
                                                    
                                                    <select name="vendor" class="form-control form-control-solid " >
                            <option value="1"  selected  >TRQ</option>
                                   
                        </select>
                                                   
                                                </div>
                                            </div>
                                            
                                            
                                             
                                            <div class="row mt-3" >
                                                <div class="col-6" >
                                                    <label class="fw-bold fs-6 mb-2">Part Number</label>
                                                </div>
                                                <div class="col-6" >
                                                    <select name="part_no" class=" csv_fields form-control form-control-solid " >
                                                        
                                                        </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3" >
                                                <div class="col-6" >
                                                    <label class="fw-bold fs-6 mb-2">SKU</label>
                                                </div>
                                                <div class="col-6" >
                                                    <select name="sku" class=" csv_fields form-control form-control-solid " >
                                                        
                                                        </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3" >
                                                <div class="col-6" >
                                                    <label class="fw-bold fs-6 mb-2">COST</label>
                                                </div>
                                                <div class="col-6" >
                                                    <select name="cost" class=" csv_fields form-control form-control-solid " >
                                                        
                                                        </select>
                                                </div>
                                            </div>
                                             <div class="row mt-3" >
                                                <div class="col-6" >
                                                    <label class="fw-bold fs-6 mb-2">Quantity</label>
                                                </div>
                                                <div class="col-6" >
                                                    <select name="qty" class=" csv_fields form-control form-control-solid " >
                                                        
                                                        </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3" >
                                                <div class="col-6" >
                                                    <label class="fw-bold fs-6 mb-2">FEE</label>
                                                </div>
                                                <div class="col-6" >
                                                    <select name="fee" class=" csv_fields form-control form-control-solid " >
                                                        
                                                        </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3" >
                                                <div class="col-6" >
                                                    <label class="fw-bold fs-6 mb-2">COMMISSION</label>
                                                </div>
                                                <div class="col-6" >
                                                    <select name="commission" class=" csv_fields form-control form-control-solid " >
                                                        
                                                        </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3" >
                                                <div class="col-6" >
                                                    <label class="fw-bold fs-6 mb-2">SHIPPING</label>
                                                </div>
                                                <div class="col-6" >
                                                    <select name="shipping" class=" csv_fields form-control form-control-solid " >
                                                        
                                                        </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3" >
                                                <div class="col-6" >
                                                    <label class="fw-bold fs-6 mb-2">PROFIT</label>
                                                </div>
                                                <div class="col-6" >
                                                    <select name="profit" class=" csv_fields form-control form-control-solid " >
                                                        
                                                        </select>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                          
                                           
                                         

                                            
                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                data-bs-target="#csv_table">Discard</button>
                                            <button type="submit" class="btn btn-primary" id="" 
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


                 