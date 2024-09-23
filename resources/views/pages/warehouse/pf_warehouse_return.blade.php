


<div class="modal fade" id="return" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_credits_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Open Return</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                    data-bs-target="#return">
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
                <form id="return_form" action="{{ route('open_return') }}" enctype="multipart/form-data"
                    class="form" method="post">
                    <!--begin::Scroll-->
                    @csrf
                    <input type="hidden" name="warehouse_name" class="warehouse_name">
                    <div class="d-flex flex-column scroll-y"
                        id="kt_modal_add_credits_scroll" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_credits_header"
                        data-kt-scroll-wrappers="#kt_modal_add_credits_scroll"
                        data-kt-scroll-offset="300px">

                        <input type="hidden" name="row_id">

                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Tracking ID</label>
                            <input required type="text" name="tracking" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Tracking_ID"  />
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Order ID</label>
                            <input required type="text" name="order_id" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Order ID"  />
                        </div>


                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Return Quantity</label>
                            <input required type="text" name="inventory" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter quantity" min="1" step="1" pattern="\d+" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class=" fw-bold fs-6 mb-2">Price Per Unit</label>
                            <input type="text" name="purchase_price"
                            oninput="formatDecimal(this)"
                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Price"  />
                        </div>

                        <div class="fv-row mb-7">
                            <label class="form-label fs-6 fw-bold">Reason</label>
                            <select name="reason"   class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                data-placeholder="Select option" data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="true">
                                <option></option>
                                <option value="Item defective or doesn’t work" selected>Item defective or doesn’t work</option>
                                <option value="Incompatible or not useful" >Incompatible or not useful</option>
                                <option value="Missing parts or accessories" >Missing parts or accessories</option>
                                <option value="Performance or quality not adequate" >Performance or quality not adequate</option>
                                 <option value="Wrong item was sent" >Wrong item was sent</option>
                                <option value="Product damaged, but shipping box OK" >Product damaged, but shipping box OK</option>
                                <option value="No longer needed" >No longer needed</option>
                                <option value="Others" >Others</option>
                            </select>
                        </div>



                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                            data-bs-target="#csv_file_button">Discard</button>
                        <button type="submit" class="btn btn-primary" id="return_submit"
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

