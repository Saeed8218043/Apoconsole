


                     <div class="modal fade" id="ship" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Ship</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#ship">
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
                                    <form id="ship_form" action="{{ route('warehouse.order.store') }}" enctype="multipart/form-data"
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
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Order ID</label>
                                                <input required type="text" name="order_id" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Order ID" accept="application/pdf, application/doc, application/docx" />
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Ship by date</label>
                                                <input required type="text" name="ship_by_date" id="ship_by_date" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Select date" >
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="fw-bold fs-6 mb-2">Label price</label>
                                                <input
                                                       type="text"
                                                       name="label_price"
                                                       class="form-control form-control-solid mb-3 mb-lg-0"
                                                       placeholder="Enter price"
                                                       oninput="formatDecimal(this)"
                                                       onkeydown="handleBackspace(event, this)"
                                                />
                                            </div>

                                            <div class="user-image mb-3 text-center" style="border: 1px solid #d1d1d1;border-radius: 3px;">
                                                <div class="imgPreview row" style="padding: 8px;"> </div>
                                            </div>
                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Label</label>
                                                <input  type="file" name="label[]" onchange="multiImgPreview(this, 'div.imgPreview')"  multiple class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Label" accept="image/*" />
                                            </div>


                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Part Number</label>
                                                <input required type="text" name="part" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Part Number"  />
                                            </div>



                                            <div class="fv-row mb-7">
                                                <label class="fw-bold fs-6 mb-2">Tracking ID</label>
                                                <input type="text" name="tracking" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Tracking_ID"  />
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Quantity to ship</label>
                                                <input required type="text" name="inventory" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter quantity" min="1" step="1" pattern="\d+" />
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
                                                data-bs-target="#csv_file_button">Discard</button>
                                            <button type="submit" class="btn btn-primary" id="ship_submit"
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

