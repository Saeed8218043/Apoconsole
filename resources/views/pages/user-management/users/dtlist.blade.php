<x-base-layout>
    <?php
    $default_image =
        'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAPFBMVEXm5uampqajo6Pa2trp6emhoaHl5eXg4OCoqKjc3Nzf39/W1tatra2wsLDIyMi8vLy2trbExMTOzs61tbXhv6YVAAAEl0lEQVR4nO2d27aqMAxFpYSbioL+/79uEPEGW4WmSepY8+287Tlikza0OZsNAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKUMcmL4ptUeTDP36JTqc6ted9mTiXOZeU+3N7qja/YtnZHZqyF3ukUy2bQ2ep/ed5Q9tD7V7s7pauPmzjdqS0SebtbpZJk8brSOn5n+g9R/IcqSNVdfZRbyCrq/gcKW+/iN89jm0emSPt9t/7XRz3u6gUqV3md3Fs41Gk/LxcsFM8x/JLpapcI9gplnEkHNqt0huIYTHSbl0Ar2G0r0ipj2CnaL36U+Un2CkaX4tF6SmYJGWhLfGW2jeEXRBrbYk30NFfsFM8mv2d0u7brfZ7MrMJNWfx68m1Vebh+Y32GP2d+pX6F0Wbv9OaTTBJLOZTOvGkmYHsZDCIe0bBJNlr60zgqhQj9ioGca7CntqaYcUbwi6IlbbSM3y1cMRaTcz9zxSvlLY2NozVfsTttKUeWdM9/Ghoq7vInUl7TO1rtgEEk2SrrXWHc9N9x9L2mw5BDA+GDNmr4cXQUkUMkWhMpZoA9b7HUM0vgggmiZ3OqXejex5nZ/Pt+a3iX8NUW+xGyn10Gsjs7EyZz/cwVOD31+Hv59IwRwtLh4vf39PkvN3gkb0dQ2qCnC0aO2eLEG0aW40aOgUxtPR1Jki5MFQsAqUaQ4kmTBvDVBMjyEI0tQzDnPLtnPB7qGEXNFQNL7AfoAwdnQaIe2taGgshe9vbUsP7Ct+VrwFLxXCAd29qaU96g+Hy7B2T12g5V6LBVXiBb3Nq70bUBWJrDGdWL+xzJRuTaeYKw0V241fZedqKdpqIUziuLFi6oDCD/z1ak3dnH6HWTzEznGWu+CVUy2n0hk8UI4hgDx3WKmZGN2sTaPdhkMI8LooXpANUrCj9ri6iEexZnG9cq/0nL2ThyIHYBg700JJPbq6JbhoPbdtFj/Jd2UY1qIbS44KxH1dHd7R6KpxAabPYb3CMYxgPFev8ro7mKwblbea1L82MD6pZPJZmxtFy3aCc6bW61TBSunJqy0SxtJlxfr4jnB9Z3wE31r7MUOGdYp5xe1t1g20JPiiaWoyUMusN2FEM87DLUOc0lKAZxXCCRhSpCubXY2BqFOvH7Sn6n7tzlg9q/+Nq5dIf5m3lk6LuFcX17e3vUW2E+8+f+wbNGXWBXiG8ondZOMwV/Sl6n9wCPeiaUdR64iXzG+3RuUEUZszAPDpn/kJOsFNU2NqEr/VPhgp1X6QUPiiKP6CRDaFGEIVDKB9E6RDKBzHUJIx3iKZTyVo4IlsT2d+PfIPoG5NAgzDekwnuTuXzTI9krgn0/v4Tgu/zA3ZI3yE3Z1DnRyr5MxVqXkwRa2eI79hGpHZuYeYLfGUodMtdaxkKLkStZSjWr9HYdY/I7L7FmohTZNqKeolGKtVIdbpnDUW633qpVCqZss+XX4LILHqV0++IyCmYe7TAMiR2pqLd/FdEuvu/b7jV6NGMZBJvhH/fkP3/6lhkKHFC3GZOD5EY5qkm1i5HAwAAAAAAAAAAAAAAAAAAAACAJf4AKkJE8O36wbkAAAAASUVORK5CYII=';
    ?>

    <?php
    // print_test(\App\Core\Adapters\Menu::get_permissions('user-management'));
    // print_test(theme()->get_permissions('user-management'),false);
    // print_test(get_permissions('user-management.permissions'),false);
    ?>

    <div class="card ">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="black" />
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search user" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Filter
                    </button>
                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Separator-->
                        <div class="separator border-gray-200"></div>
                        <!--end::Separator-->
                        <!--begin::Content-->
                        <div class="px-7 py-5" data-kt-user-table-filter="form">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-bold">Role:</label>
                                <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                    data-placeholder="Select option" data-allow-clear="true"
                                    data-kt-user-table-filter="role" data-hide-search="true" id="role_filter">
                                    <option></option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>

                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-bold">Email Verification:</label>
                                <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                    data-placeholder="Select option" data-allow-clear="true"
                                    data-kt-user-table-filter="two-step" data-hide-search="true" id="email_verify">
                                    <option></option>
                                    <option value="Verifyed">Verifyed</option>
                                    <option value="Non-Verifyed">Non-Verifyed</option>
                                </select>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-bold me-2 px-6"
                                    data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                <button type="submit" class="btn btn-primary fw-bold px-6" data-kt-menu-dismiss="true"
                                    data-kt-user-table-filter="filter">Apply</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Filter-->
                    <!--begin::Export-->
                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_export_users">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                                    transform="rotate(90 12.75 4.25)" fill="black" />
                                <path
                                    d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                    fill="black" />
                                <path
                                    d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                    fill="#C4C4C4" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Export
                    </button>
                    <!--end::Export-->
                    <!--begin::Add user-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_user">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Add User
                    </button>
                    <!--begin::Modal - Add task-->
                    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_user_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Add User</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_user">
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
                                    <form id="kt_modal_add_user_form" enctype="multipart/form-data"
                                        class="form" method="post">
                                        <!--begin::Scroll-->
                                        @csrf
                                        <div class="d-flex flex-column scroll-y"
                                            id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                            data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                            data-kt-scroll-offset="300px">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="d-block fw-bold fs-6 mb-5">Avatar</label>
                                                <!--end::Label-->
                                                <!--begin::Image input-->
                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                    style="background-image: url(assets/media/avatars/blank.png)">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                        style="background-image: url(assets/media/avatars/150-1.jpg);">
                                                    </div>
                                                    <!--end::Preview existing avatar-->
                                                    <!--begin::Label-->
                                                    <label
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        title="Change avatar">
                                                        <i class="bi bi-pencil-fill fs-7"></i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="avatar_remove" />
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Cancel-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                        title="Cancel avatar">
                                                        <i class="bi bi-x fs-2"></i>
                                                    </span>
                                                    <!--end::Cancel-->
                                                    <!--begin::Remove-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                        title="Remove avatar">
                                                        <i class="bi bi-x fs-2"></i>
                                                    </span>
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                                <!--begin::Hint-->
                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                <!--end::Hint-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">First Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="first_name"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Full name" value="" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Last Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="last_name"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Full name" value="" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Email</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="email" name="email"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="example@domain.com" value="" />
                                                <!--end::Input-->
                                            </div>
                                            
                                             <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Password</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="password"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                     value="" />
                                                <!--end::Input-->
                                            </div>

                                            
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Username</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="username"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Username...." value="" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-7">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-5">Role</label>
                                                <!--end::Label-->
                                                <!--begin::Roles-->
                                                <!--begin::Input row-->
                                                @php $x=0; @endphp
                                                @foreach ($roles as $role)

                                                    <div class="d-flex fv-row">
                                                        <!--begin::Radio-->
                                                        <div class="form-check form-check-custom form-check-solid">
                                                            <!--begin::Input-->
                                                            <input class="form-check-input me-3" name="role[]"
                                                                type="checkbox" value="{{ $role->id }}"
                                                                id="kt_modal_update_role_option_{{ ++$x }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Label-->
                                                            <label class="form-check-label"
                                                                for="kt_modal_update_role_option_{{ $x }}">
                                                                <div class="fw-bolder text-gray-800">{{ $role->name }}
                                                                </div>
                                                                <!-- <div class="text-gray-600">Best for business owners and company administrators</div> -->
                                                            </label>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Radio-->
                                                    </div>
                                                    <!--end::Input row-->
                                                    <div class='separator separator-dashed my-5'></div>
                                                @endforeach
                                                <!--begin::Input row-->

                                                <!--end::Input row-->

                                                <!--begin::Input row-->

                                                <!--end::Input row-->

                                                <!--begin::Input row-->

                                                <!--end::Input row-->
                                                <div class='separator separator-dashed my-5'></div>
                                                <!--begin::Input row-->

                                                <!--end::Input row-->
                                                <!--end::Roles-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_add_user">Discard</button>
                                            <button type="submit" class="btn btn-primary"
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
                    <!--end::Modal - Add task-->
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bolder me-5">
                        <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete
                        Selected</button>
                </div>
                <!--end::Group actions-->
                <!--begin::Modal - Adjust Balance-->
                <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder">Export Users</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_export_users">
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
                                <form id="kt_modal_export_users_form" class="form" action="#">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mb-2">Select Roles:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="role" data-control="select2" data-placeholder="Select a role"
                                            data-hide-search="true" class="form-select form-select-solid fw-bolder">
                                            <option></option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>

                                            @endforeach

                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-bold form-label mb-2">Select Export
                                            Format:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="format" data-control="select2" data-placeholder="Select a format"
                                            data-hide-search="true" class="form-select form-select-solid fw-bolder">
                                            <option></option>
                                            <option value="excel">Excel</option>
                                            <option value="pdf">PDF</option>
                                            <option value="cvs">CVS</option>
                                            <option value="zip">ZIP</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="text-center">
                                        <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_export_users">Discard</button>
                                        <button type="submit" class="btn btn-primary"
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
                <!--end::Modal - New Card-->

            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                    data-kt-check-target="#kt_table_users .form-check-input" value="" />
                            </div>
                        </th>
                        <th class="min-w-125px">User</th>
                        <th class="min-w-125px">Role</th>
                        <th class="min-w-125px">Last login</th>
                        <th class="min-w-125px">Email Verify</th>
                        <th class="min-w-125px">Joined Date</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->

                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>




    @section('scripts')

        <script id="usertable">
            var KTUsersList = (function() {
                // Define shared variables
                var table = document.getElementById('kt_table_users')
                var datatable
                var toolbarBase
                var toolbarSelected
                var selectedCount
                var selectedval

                // Private functions
                var initUserTable = function() {
                    // Set date data order
                    const tableRows = table.querySelectorAll('tbody tr')

                    tableRows.forEach(row => {
                        const dateRow = row.querySelectorAll('td')
                        const lastLogin = dateRow[3].innerText.toLowerCase() // Get last login time
                        let timeCount = 0
                        let timeFormat = 'minutes'

                        // Determine date & time format -- add more formats when necessary
                        if (lastLogin.includes('yesterday')) {
                            timeCount = 1
                            timeFormat = 'days'
                        } else if (lastLogin.includes('mins')) {
                            timeCount = parseInt(lastLogin.replace(/\D/g, ''))
                            timeFormat = 'minutes'
                        } else if (lastLogin.includes('hours')) {
                            timeCount = parseInt(lastLogin.replace(/\D/g, ''))
                            timeFormat = 'hours'
                        } else if (lastLogin.includes('days')) {
                            timeCount = parseInt(lastLogin.replace(/\D/g, ''))
                            timeFormat = 'days'
                        } else if (lastLogin.includes('weeks')) {
                            timeCount = parseInt(lastLogin.replace(/\D/g, ''))
                            timeFormat = 'weeks'
                        }

                        // Subtract date/time from today -- more info on moment datetime subtraction: https://momentjs.com/docs/#/durations/subtract/
                        const realDate = moment()
                            .subtract(timeCount, timeFormat)
                            .format()

                        // Insert real date to last login attribute
                        dateRow[3].setAttribute('data-order', realDate)

                        // Set real date for joined column
                        const joinedDate = moment(
                            dateRow[5].innerHTML,
                            'DD MMM YYYY, LT'
                        ).format() // select date from 5th column in table
                        dateRow[5].setAttribute('data-order', joinedDate)
                    })

                    // Init datatable --- more info on datatables: https://datatables.net/manual/
                    datatable = $(table).DataTable({
                        ajax: {
                            url: "<?= route('user-management.user.list.datatableapi') ?>",
                            data: {
                                // ; 

                                role_filter: document.getElementById('role_filter').value,
                                email_verify: document.getElementById('email_verify').value,
                                // remove_record: getselected(),
                                // departure_today: departure_today

                            },
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        },

                        processing: true,
                        serverSide: true,
                        info: true,
                        order: [],
                        // lengthMenu: [20, 40, 60, 80, 100],
                        pageLength: 10,
                        lengthChange: true,
                        columns: [{
                                data: 'checkbox',
                                name: 'checkbox',
                                'searchable': false
                            },
                            {
                                data: 'first_name',
                                name: 'first_name',
                                orderable: true
                            },
                            {
                                data: 'role',
                                name: 'role',
                                orderable: true
                            },
                            {
                                data: 'updated_at',
                                name: 'updated_at',
                                orderable: true
                            },
                            {
                                data: 'two_step',
                                name: 'two_step',
                                orderable: true
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                orderable: true
                            },
                            {
                                data: 'action',
                                name: 'action',
                                'searchable': false
                            }
                        ],
                        columnDefs: [{
                                orderable: false,
                                targets: 0
                            }, // Disable ordering on column 0 (checkbox)
                            {
                                orderable: false,
                                targets: 6
                            } // Disable ordering on column 6 (actions)
                        ]
                    })

                    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                    datatable.on('draw', function() {
                        initToggleToolbar()
                        handleDeleteRows()
                        toggleToolbars()
                        KTMenu.createInstances();
                    })
                }

                // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
                var handleSearchDatatable = () => {
                    const filterSearch = document.querySelector(
                        '[data-kt-user-table-filter="search"]'
                    )
                    filterSearch.addEventListener('keyup', function(e) {
                        datatable.search(e.target.value).draw()
                    })
                }

                // Filter Datatable
                var handleFilterDatatable = () => {
                    // Select filter options
                    const filterForm = document.querySelector(
                        '[data-kt-user-table-filter="form"]'
                    )
                    const filterButton = filterForm.querySelector(
                        '[data-kt-user-table-filter="filter"]'
                    )
                    const selectOptions = filterForm.querySelectorAll('select')

                    // Filter datatable on submit
                    filterButton.addEventListener('click', function() {
                        var filterString = ''

                        // Get filter values
                        // selectOptions.forEach((item, index) => {
                        //     if (item.value && item.value !== '') {
                        //         if (index !== 0) {
                        //             filterString += ' '
                        //         }
                        //         // Build filter value options
                        //         filterString += item.value
                        //     }
                        // })
                        datatable.destroy();
                        console.log(document.getElementById('role_filter').value);
                        // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                        // datatable.search(filterString).draw()
                        initUserTable();
                        // datatable.setAttribute( 'query', 2 );
                        // datatable.draw()
                    })
                }

                // Reset Filter
                var handleResetForm = () => {
                    // Select reset button
                    const resetButton = document.querySelector(
                        '[data-kt-user-table-filter="reset"]'
                    )

                    // Reset datatable
                    resetButton.addEventListener('click', function() {
                        // Select filter options
                        const filterForm = document.querySelector(
                            '[data-kt-user-table-filter="form"]'
                        )
                        const selectOptions = filterForm.querySelectorAll('select')

                        // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
                        selectOptions.forEach(select => {
                            $(select)
                                .val('')
                                .trigger('change')
                        })

                        // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()

                        // handleSearchDatatable();
                        //  datatable.draw()
                        // initUserTable();
                    })
                }

                // Delete subscirption
                var handleDeleteRows = () => {
                    // Select all delete buttons
                    const deleteButtons = table.querySelectorAll(
                        '[data-kt-users-table-filter="delete_row"]'
                    )

                    deleteButtons.forEach(d => {
                        // Delete button on click
                        d.addEventListener('click', function(e) {
                            e.preventDefault()

                            // Select parent row
                            const parent = e.target.closest('tr')

                            // Get user name
                            const userName = parent
                                .querySelectorAll('td')[1]
                                .querySelectorAll('a')[1].innerText

                            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                            Swal.fire({
                                text: 'Are you sure you want to delete ' + userName + '?',
                                icon: 'warning',
                                showCancelButton: true,
                                buttonsStyling: false,
                                confirmButtonText: 'Yes, delete!',
                                cancelButtonText: 'No, cancel',
                                customClass: {
                                    confirmButton: 'btn fw-bold btn-danger',
                                    cancelButton: 'btn fw-bold btn-active-light-primary'
                                }
                            }).then(function(result) {

                                if (result.value) {
                                    Swal.fire({
                                            text: 'You have deleted ' + userName + '!.',
                                            icon: 'success',
                                            buttonsStyling: false,
                                            confirmButtonText: 'Ok, got it!',
                                            customClass: {
                                                confirmButton: 'btn fw-bold btn-primary'
                                            }
                                        })
                                        .then(function() {

                                            // Remove current row
                                            datatable
                                                .row($(parent)).remove().draw();
                                            // console.log(parent.getAttribute('id'));
                                            var token = $("meta[name='csrf-token']")
                                                .attr("content");

                                            $.ajax({
                                                url: "<?= route('user-management.user.list.bulkdelete') ?>",
                                                type: 'POST',
                                                data: {
                                                    "list": parent.getAttribute('id'),
                                                    "_token": token,
                                                },
                                                success: function() {
                                                    datatable.destroy();
                                                    initUserTable();
                                                }
                                            });
                                        })
                                        .then(function() {
                                            // Detect checked checkboxes
                                            toggleToolbars()
                                        })
                                } else if (result.dismiss === 'cancel') {
                                    Swal.fire({
                                        text: customerName + ' was not deleted.',
                                        icon: 'error',
                                        buttonsStyling: false,
                                        confirmButtonText: 'Ok, got it!',
                                        customClass: {
                                            confirmButton: 'btn fw-bold btn-primary'
                                        }
                                    })
                                }
                            })
                        })
                    })
                }
                var getselected = () => {
                    var checkeval = [];
                    const checkboxes = table.querySelectorAll('[type="checkbox"]');
                    checkboxes.forEach(c => {
                        if (c.checked) {
                            if (c.value != "") {
                                checkeval.push(c.value);
                            }
                            // console.log(c.checked)
                            // console.log(c)
                        }
                    });
                    return checkeval.toString();
                }
                // Init toggle toolbar
                var initToggleToolbar = () => {
                    // Toggle selected action toolbar
                    // Select all checkboxes
                    const checkboxes = table.querySelectorAll('[type="checkbox"]')

                    // Select elements
                    toolbarBase = document.querySelector(
                        '[data-kt-user-table-toolbar="base"]'
                    )
                    toolbarSelected = document.querySelector(
                        '[data-kt-user-table-toolbar="selected"]'
                    )
                    selectedCount = document.querySelector(
                        '[data-kt-user-table-select="selected_count"]'
                    )
                    const deleteSelected = document.querySelector(
                        '[data-kt-user-table-select="delete_selected"]'
                    )

                    // Toggle delete selected toolbar
                    checkboxes.forEach(c => {
                        // Checkbox on click event
                        c.addEventListener('click', function() {
                            setTimeout(function() {
                                toggleToolbars()
                            }, 50)
                        })
                    })

                    // Deleted selected rows
                    deleteSelected.addEventListener('click', function() {
                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: 'Are you sure you want to delete selected customers?',
                            icon: 'warning',
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: 'Yes, delete!',
                            cancelButtonText: 'No, cancel',
                            customClass: {
                                confirmButton: 'btn fw-bold btn-danger',
                                cancelButton: 'btn fw-bold btn-active-light-primary'
                            }
                        }).then(function(result) {
                            if (result.value) {
                                Swal.fire({
                                        text: 'You have deleted all selected customers!.',
                                        icon: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: 'Ok, got it!',
                                        customClass: {
                                            confirmButton: 'btn fw-bold btn-primary'
                                        }
                                    })
                                    .then(function() {
                                        // Remove all selected customers
                                        var checkeval = [];

                                        checkboxes.forEach(c => {
                                            if (c.checked) {
                                                if (c.value != "") {
                                                    checkeval.push(c.value);
                                                }

                                                console.log(c.checked)

                                                console.log(c)
                                                // datatable
                                                //     .row($(c.closest('tbody tr')))
                                                //     .remove()
                                                //     .draw()

                                            }
                                        })

                                        selectedval = checkeval.toString();
                                        // initUserTable();

                                        var token = $("meta[name='csrf-token']").attr(
                                            "content");
                                        $.ajax({
                                            url: "<?= route('user-management.user.list.bulkdelete') ?>",
                                            type: 'POST',
                                            data: {
                                                "list": selectedval,
                                                "_token": token,
                                            },
                                            success: function() {
                                                datatable.destroy();
                                                initUserTable();
                                            }
                                        });
                                        // Remove header checked box
                                        const headerCheckbox = table.querySelectorAll(
                                            '[type="checkbox"]'
                                        )[0]
                                        headerCheckbox.checked = false
                                    })
                                    .then(function() {
                                        toggleToolbars() // Detect checked checkboxes
                                        initToggleToolbar
                                            () // Re-init toolbar to recalculate checkboxes
                                    })
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: 'Selected customers was not deleted.',
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok, got it!',
                                    customClass: {
                                        confirmButton: 'btn fw-bold btn-primary'
                                    }
                                })
                            }
                        })
                    })
                }

                // Toggle toolbars
                const toggleToolbars = () => {
                    // Select refreshed checkbox DOM elements
                    const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]')

                    // Detect checkboxes state & count
                    let checkedState = false
                    let count = 0

                    // Count checked boxes
                    allCheckboxes.forEach(c => {
                        if (c.checked) {
                            checkedState = true
                            count++
                        }
                    })

                    // Toggle toolbars
                    if (checkedState) {
                        selectedCount.innerHTML = count
                        toolbarBase.classList.add('d-none')
                        toolbarSelected.classList.remove('d-none')
                    } else {
                        toolbarBase.classList.remove('d-none')
                        toolbarSelected.classList.add('d-none')
                    }
                }

                return {
                    // Public functions
                    init: function() {
                        if (!table) {
                            return
                        }

                        initUserTable();
                        initToggleToolbar()
                        handleSearchDatatable()
                        handleResetForm()
                        handleDeleteRows()
                        handleFilterDatatable()
                    }
                }
            })()

            // On document ready
            KTUtil.onDOMContentLoaded(function() {
                KTUsersList.init()
            })
        </script>
    @endsection
</x-base-layout>
