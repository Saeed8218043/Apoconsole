                    <div class="modal fade" id="kt_modal_edit_coupon" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Edit Warehouse</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_edit_coupon">
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
                                    <form id="kt_modal_edit_coupon_form" dt-action="{{ route('warehouse.edit') }}" enctype="multipart/form-data"
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
                                            <input type="hidden" name="inventory_id" id="inventory_id" value="" />

                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Order ID</label>
                                                <input required type="text" name="order_id" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Order ID" accept="application/pdf, application/doc, application/docx" />
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Ship by date</label>
                                                <input required type="date" name="ship_by_date" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter date" accept="application/pdf, application/doc, application/docx" value="{{ date('Y-m-d') }}">
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Label price</label>
                                                <input required type="number" name="label_price" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter price" step="0.01"/>
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class=" fw-bold fs-6 mb-2">Label</label>
                                                <input  type="file" name="label[]" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Picture" accept="image/*" />
                                            </div>


                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Part Number</label>
                                                <input required type="text" name="part" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Part"  />
                                            </div>


                                            <div class="fv-row mb-7">
                                                <label class="form-label fs-6 fw-bold">Status:</label>
                                                <select name="status"   class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                                    data-placeholder="Select option" data-allow-clear="true"
                                                    data-kt-user-table-filter="role" data-hide-search="true">
                                                    <option></option>
                                                    <option value="Out of Stock">Out of Stock</option>
                                                    <option value="Label Downloaded">Label Downloaded</option>
                                                    <option value="Unshipped">Unshipped</option>
                                                    <option value="Shipped" >Shipped</option>
                                                    <option value="Delivery Stuck" >Delivery Stuck</option>
                                                    <option value="Delivered" >Delivered</option>

                                                </select>
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Tracking</label>
                                                <input required type="text" name="tracking" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Tracking_ID"  />
                                            </div>



                                              <style>
                                                .imgPreview img {
                                                    height: 100px;
                                                    width: 100px;
                                                    margin: 5px;
                                                }
                                            </style>




                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_edit_coupon">Discard</button>
                                            <button type="submit" class="btn btn-primary" id="kt_docs_updte_formvalidation_text_submit"
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









