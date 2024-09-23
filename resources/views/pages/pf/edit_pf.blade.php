<div class="modal fade" id="kt_modal_edit_coupon" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_credits_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Edit PF inventory</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_coupon">

                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>

                <!--end::Close-->
            </div>
            <h3 class="fw-bolder po_number" style="margin: 25px;"> </h3>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-3 mx-xl-5 my-3">
                <!--begin::Form-->
                <form id="kt_modal_edit_coupon_form" action="{{ route('pf.store') }}" enctype="multipart/form-data" class="form" method="post">
                    <!--begin::Scroll-->
                    @csrf
                    <div class="d-flex flex-column scroll-y" id="kt_modal_add_credits_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_credits_header" data-kt-scroll-wrappers="#kt_modal_add_credits_scroll" data-kt-scroll-offset="300px">




                        <input type="hidden" name="warehouse_name" class="warehouse_name"/>
                        <input type="hidden" name="kit_id" id="kit_id" value="" />
                        <div id="dynamic-parts-container"></div>




                    </div>
                    <button type="button" class="btn btn-success" id="add-input">Add</button>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_coupon">Discard</button>
                        <button type="submit" class="btn btn-primary" id="kt_docs_updte_formvalidation_text_submit" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
