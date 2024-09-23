


                     <div class="modal fade" id="approve" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Approve/Damage</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#approve">
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
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <!--begin::Form-->
                                    <form id="approve_form" action="{{ route('return.approve') }}" enctype="multipart/form-data"
                                        class="form" method="post">
                                        <!--begin::Scroll-->
                                        @csrf
                                        <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                            id="kt_modal_add_credits_scroll" data-kt-scroll="true"
                                            data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_credits_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_credits_scroll"
                                            data-kt-scroll-offset="300px">

                                            <input type="hidden" name="id">
                                        <input type="hidden" name="warehouse_name" class="warehouse_name">
                                            <div id="parts_container"></div>
                                            {{-- <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Part Number</label>
                                                <input required type="text" name="part" @readonly(true)  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Part"  />
                                            </div> --}}

                                            <div class="user-image mb-3 text-center" style="border: 1px solid #d1d1d1; border-radius: 3px;">
                                                <div class="imgPreview2 row" style="padding: 8px; display: flex; flex-wrap: wrap;"> </div>
                                            </div>

                                            <style>
                                                .imgPreview2 img {
                                                    max-height: 100%;
                                                    max-width: 100%;
                                                    margin: 5px;
                                                }
                                                .imgPreview2 .col {
                                                    flex: 0 0 calc(33.33% - 10px); /* Adjust the percentage as needed */
                                                    max-width: calc(33.33% - 10px);
                                                    margin: 5px;
                                                }
                                            </style>


                                            {{-- <div class="fv-row mb-7">
                                                <label class="required fw-bold fs-6 mb-2">Returned recieved</label>
                                                <input required type="text" name="inventory_count" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter recieved items in warehouse"  step="1" pattern="\d+"/>
                                            </div>

                                            <div class="fv-row mb-7">
                                                <label class="form-label fs-6 fw-bold">Status:</label>
                                                <select name="status"   class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                                    data-placeholder="Select option" data-allow-clear="true"
                                                    data-kt-user-table-filter="role" data-hide-search="true">
                                                    <option></option>
                                                    <option value="Approved" >Approved</option>
                                                    <option value="Damaged" >Damaged</option>
                                                </select>
                                            </div> --}}

                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                data-bs-target="#csv_file_button">Discard</button>
                                            <button type="submit" class="btn btn-primary" id="approve_submit"
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

