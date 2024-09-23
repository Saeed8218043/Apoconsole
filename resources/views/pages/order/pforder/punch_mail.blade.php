   
                  

                     <div class="modal fade" id="pf_order_punch_mail" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-850px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Push Order</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#pf_order_punch_mail">
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
                                    <form id="pf_order_punch_mail_form" action="{{ route('order_pf.send_mail') }}" enctype="multipart/form-data"
                                        class="form" method="post">
                                        <!--begin::Scroll-->
                                        @csrf
                                        <input type="hidden" name="order_id"   > 
                                        <div class="d-flex flex-column scroll-y"
                                            id="kt_modal_add_credits_scroll" data-kt-scroll="true"
                                            data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_credits_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_credits_scroll"
                                            data-kt-scroll-offset="300px">
                                    
                                        
                                    
                                
                                            
                                        
                                         <div class="row  mb-3 " >
                                          
                                             <div class="fv-row mb-2 col-12  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Recepient Email</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <select class="form-control form-input" name="recipient_email"  >
                                                    @foreach (\App\Models\Setting::where('key','LIKE','%pf_order_recipient_email%')->get() as $email )
                                                    <option  > {{ $email->value }} </option>
                                                    @endforeach
                                                </select>
                                                 
                                                <!--end::Input-->
                                            </div>
                                            
                                             <div class="fv-row mb-2 col-4  ">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">CC</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input  type="text" name="cc_name"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="CC Name"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-2 col-8  ">
                                                <!--begin::Label-->
                                                <label style="visibility: hidden;" class=" fw-bold fs-6 mb-2">CC</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input  type="text" name="cc_email"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="CC Email"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                          </div>
                                          <div class="row  mb-3 " >
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">PO Number </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="ponumber"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="PO Number"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            
                                          </div>
                                          
                                          
                                           <div class="row mb-3" >
                                               <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="shippingName"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Shipping Name"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">Phone</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input  type="text" name="phone"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Enter Phone / Contact"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                          </div>
                                          
                                          
                                           <div class="row  mb-3 " > 
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Address 1</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="shippingAddress1"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Address 1"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                             <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">Shipping Address 2</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input  type="text" name="shippingAddress2"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Address 2"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            </div>
                                            <div class="row  mb-3 " >
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Postal Code</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="shippingPostalCode"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Postal Code"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping City</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="shippingCity"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Shipping City"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            </div>
                                            <div class="row  mb-3 " >
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Country</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="shippingCountry"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Shipping Country"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Region</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                                <input required type="text" name="shippingRegion"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Shipping Region"  />
                                                 
                                                <!--end::Input-->
                                            </div>
                                            </div>
                                            <div class="row  mb-3 " >
                                            
                                            <!-- <div class="fv-row mb-2 col  ">-->
                                                <!--begin::Label-->
                                            <!--    <label class=" fw-bold fs-6 mb-2">Client Segment (Optional)</label>-->
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                            <!--    <input  type="text" name="clientSegment"-->
                                            <!--        class="form-control form-control-solid mb-3 mb-lg-0"-->
                                            <!--        placeholder="Any Message..."  />-->
                                                 
                                                <!--end::Input-->
                                            <!--</div>-->
                                            </div>
                                            <!--end::Input group-->
                                            
                                             <hr></hr>
                                            
                                            <table class="new_order_item_table">
                                              <thead>
                                                <tr>
                                               <th scope="col">#</th>
                                                  <th scope="col">SKU</th>
                                                  <th scope="col">Brand</th>
                                                  <th scope="col">Quantity</th>
                                                  
                                                </tr>
                                              </thead>
                                                <tbody>
   
                                                </tbody>
                                            </table>
                                            
                                           
                                          
                                            
                                            
                                            <!--begin::Input group-->
                                        
                                          
                                           
                                         

                                            
                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                data-bs-target="#pf_order_punch_mail">Discard</button>
                                            <button type="submit" class="btn btn-primary" id="kt_docs_formvalidation_text_submit" 
                                                data-kt-users-modal-action="submit">
                                                <span class="indicator-label">Punch Order</span>
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


                 