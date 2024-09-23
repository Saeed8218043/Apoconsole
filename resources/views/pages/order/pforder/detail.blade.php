           
              

                     <div class="modal fade" id="kt_modal_detail_coupon" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Order Detail</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_detail_coupon">
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
                                    <form id="kt_modal_detail_coupon_form" dt-action="{{ route('inventoryprice.store') }}" enctype="multipart/form-data"
                                        class="form" method="post">
                                        <!--begin::Scroll-->
                                        @csrf
                                        @method('put')
                                        <div class="d-flex flex-column scroll-y"
                                            id="kt_modal_add_credits_scroll" data-kt-scroll="true"
                                            data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_credits_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_credits_scroll"
                                            data-kt-scroll-offset="300px">
                                         
                                            <!--begin::Input group-->
                                            <div class="row" >
                                                 <div class="fv-row col">
                                                    <label class="fw-bold fs-6 mb-2">Status</label>
                                                    <p id="status"></p>
                                                </div>
                                                  <div class="fv-row col">
                                                    <label class="fw-bold fs-6 mb-2">Phone</label>
                                                    <p id="trq_id"></p>
                                                </div>
                                            </div>
                                            
                                           <div class="row" >
                                            <div class="fv-row col">
                                                <label class="fw-bold fs-6 mb-2">PO Number</label>
                                                <p id="po_number"></p>
                                            </div>
                                            <div class="fv-row col">
                                                <label class="fw-bold fs-6 mb-2">Name</label>
                                                <p id="name"></p>
                                            </div>
                                           </div>
                                           <div class="row" >
                                             <div class="fv-row col">
                                                <label class="fw-bold fs-6 mb-2">Contact Email</label>
                                                <p id="contact_email"></p>
                                            </div>
                                            
                                             <div class="fv-row col">
                                                <label class="fw-bold fs-6 mb-2">Address1</label>
                                                <p id="address1"></p>
                                            </div>
                                            </div>
                                            <div class="row" >
                                             <div class="fv-row col">
                                                <label class="fw-bold fs-6 mb-2">Address2</label>
                                                <p id="address2"></p>
                                            </div>
                                             <div class="fv-row col">
                                                <label class="fw-bold fs-6 mb-2">Total</label>
                                                <p id="total"></p>
                                            </div>
                                            </div>
                                            <div class="row" >
                                            <div class="fv-row col">
                                                <label class="fw-bold fs-6 mb-2">City</label>
                                                <p id="city"></p>
                                            </div>
                                             <div class="fv-row col">
                                                <label class="fw-bold fs-6 mb-2">Zip</label>
                                                <p id="zip"></p>
                                            </div>
                                            </div>
                                            <div class="row" >
                                            <div class="fv-row col">
                                                <label class="fw-bold fs-6 mb-2">Province Code</label>
                                                <p id="province_code"></p>
                                            </div>
                                            <div class="fv-row col">
                                                <label class="fw-bold fs-6 mb-2">Created At</label>
                                                <p id="created_at"></p>
                                            </div>
                                            </div>
                                            <hr></hr>
                                            
                                            <table class="item_table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Brand</th>
      <th scope="col">Quantity</th>
    </tr>
  </thead>
  <tbody>
   
  </tbody>
</table>
                                            
                                            
                                            <!--<div class="fv-row mb-7">-->
                                                <!--begin::Label-->
                                            <!--    <label class="required fw-bold fs-6 mb-2">Shipping</label>-->
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                            <!--    <input required type="text" name="shipping"-->
                                            <!--        class="form-control form-control-solid mb-3 mb-lg-0"-->
                                            <!--        placeholder="Type..."  />-->
                                                 
                                                <!--end::Input-->
                                            <!--</div>-->
                                            <!--<div class="fv-row mb-7">-->
                                                <!--begin::Label-->
                                            <!--    <label class="required fw-bold fs-6 mb-2">Profit</label>-->
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                
                                            <!--    <input required type="text" name="profit"-->
                                            <!--        class="form-control form-control-solid mb-3 mb-lg-0"-->
                                            <!--        placeholder="Type..."  />-->
                                                 
                                                <!--end::Input-->
                                            <!--</div>-->
                                          

                                            
                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_detail_coupon">Discard</button>
                                            <!--<button type="submit" class="btn btn-primary" id="kt_docs_updte_formvalidation_text_submit" -->
                                            <!--    data-kt-users-modal-action="submit">-->
                                                <!--<span class="indicator-label">Submit</span>-->
                                            <!--    <span class="indicator-progress">Please wait...-->
                                            <!--        <span-->
                                            <!--            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>-->
                                            <!--</button>-->
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


                