<div class="modal fade" id="select_store" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_credits_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Approve</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                    data-bs-target="#store">
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
                <form id="store_form" action="{{ route('orderSelectStore') }}" enctype="multipart/form-data"
                    class="form" method="post">
                    <!--begin::Scroll-->
                    @csrf
                    <div class="d-flex flex-column scroll-y"
                        id="kt_modal_select_credits_scroll" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_credits_header"
                        data-kt-scroll-wrappers="#kt_modal_select_credits_scroll"
                        data-kt-scroll-offset="300px">


                            <input type="hidden" name="row_id" />
                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Store</label>
                            <select id="store" name="store" class="form-select form-select-solid fw-bolder" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
                                <option></option>
                                <option value="AUTOSPARTOUTLET">AUTOSPARTOUTLET</option>
                                <option value="CARCOMPONENTS">CARCOMPONENTS</option>
                                <option value="PARTSMYTH">PARTSMYTH</option>
                                <option value="E-TRADE">E-TRADE</option>
                                <option value="UNIVERSAL">UNIVERSAL</option>
                                <option value="HYBRID">HYBRID</option>
                                <option value="Flex">Flex</option>
                                <option value="EVOLUTION">EVOLUTION</option>
                                <option value="healthwise">healthwise</option>
                                <option value="EXPRESS">EXPRESS</option>
                            </select>
                        </div>


                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                            data-bs-target="#csv_file_button">Discard</button>
                        <button type="submit" class="btn btn-primary" id="store_submit"
                            data-kt-users-modal-action="submit">
                            <span class="indicator-label">Approve</span>
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
