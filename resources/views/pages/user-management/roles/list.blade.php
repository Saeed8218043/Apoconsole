<x-base-layout>


    <!--begin::Col-->
       <div class="content p-6" id="kt_content">
        <!--begin::Container-->
        <div class="container-fluid p-0" id="kt_content_container">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->

                @foreach ($data['roles'] as $role)
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-6">
                        <!--begin::Card-->
                        <div class="card h-md-100 border rounded-3 p-6 shadow-sm">
                            <h3 class="mb-2 text-capitalize">{{ $role->name }}</h3>

                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body p-0">
                                <!--begin::Users-->
                                <div class="fs-6 text-gray-600 mb-4">Total users with this role: <strong>{{ count($role->users) }}</strong></div>
                                <!--end::Users-->
                                <!--begin::Permissions-->
                                <div class="d-flex flex-wrap gap-1">
                                    @php $x=0;
                                    $count=count($role->permissions);
                                    if ($count > 5 ){
                                    $count-=5;
                                }
                                    @endphp

                                    @foreach ($role->permissions as $permission)
                                        @php
                                            $x++;
                                            if ($x > 5) {
                                            @endphp
                                                    <a class="btn btn-light btn-sm rounded-pill mb-1 text-capitalize border" href="<?= route('user-management.roles.list.show', ['list' => $role->id]) ?>" >And {{ $count }} more...</a>
                                                @php
                                                break;
                                            }


                                        @endphp

                                            <span class="btn btn-light btn-sm rounded-pill mb-1 text-capitalize border">{{ $permission->friendly_name }}</span>
                                    @endforeach

                                    <!-- <div class='d-flex align-items-center py-2'>

                                    <span class='bullet bg-primary me-3'></span>
                                    <em>and 7 more...</em>
                                </div> -->
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            <div class="card-footer flex-wrap p-0 mt-6 border-top-0">
                            <!--  <a href="<?= route('user-management.roles.list.show', ['list' => $role->id]) ?>"
                                    class="btn btn-light btn-active-primary my-1 me-2">View Role</a> -->
                                <!-- <button type="button" class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Edit Role</button> -->
                                <form method="POST"
                                    action="<?= route('user-management.roles.list.destroy', ['list' => $role->id]) ?>"
                                    accept-charset="UTF-8" style="display:inline">
                                    <input name="_method" type="hidden" value="DELETE">
                                    @csrf
                                    <div class="d-flex" >
                                        <!-- <input class="btn btn-light btn-light my-1 me-2"  type="button" value="Edit"> -->
                                        <a class="btn btn-sm btn-info me-2" href="<?= route('user-management.roles.list.show', ['list' => $role->id]) ?>" ><i class="bi bi-pencil"></i> Edit</a>
                                        <!-- <input class="btn btn-sm btn-danger" type="submit" value="Delete" onclick="return confirm('Are you sure want to delete {{ $role->name }} ?')"> -->
                                        <button class="btn btn-sm btn-danger" type="submit" value="Delete" onclick="return confirm('Are you sure want to delete {{ $role->name }} ?')"><i class="bi bi-trash"></i> Delete</button>

                                    </div>
                                </form>



                            </div>

                            <!--end::Card footer-->
                        </div>
                        <!--end::Card-->
                    </div>
                @endforeach
                <div class="col-xl-4 col-lg-6 col-md-6 mb-6">
                    <div class="card h-md-100 border rounded-3 p-6 shadow-sm d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                            <i class="bi bi-plus-circle"></i> Add New Role
                        </button>
                    </div>
                </div>
                <!--begin::Add new card-->
            </div>
            <!--end::Row-->
            <!--begin::Modals-->
            <!--begin::Modal - Add role-->
            <div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bolder">Add a Role</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_role">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
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
                        <div class="modal-body scroll-y mx-lg-5 my-7">
                            <!--begin::Form-->
                            <form id="kt_modal_add_role_form" class="form" method="post">
                                <!--begin::Scroll-->
                                <div class="d-flex flex-column scroll-y" id="kt_modal_add_role_scroll"
                                    data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                    data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header"
                                    data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bolder form-label mb-2">
                                            <span class="required">Role name</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="Enter a role name"
                                            name="name"  required />
                                        <!--end::Input-->
                                    </div>
                                    @csrf
                                    <!--end::Input group-->
                                    <!--begin::Permissions-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
                                        <!--end::Label-->
                                        <!--begin::Table wrapper-->
                                        @php $x=0; @endphp

                                                @foreach ($data['permissions']->groupBy('module_name') as $key=>$permissionval)
                                                @php $x++; @endphp
                                                                <div class="mb-3 text-gray-800 fw-bold bg-light" style="padding: 13px;border-radius: 8px;display: flex;"   >
                                                                    <label >
                                                                        <input class="form-check-input" type="checkbox" onchange="$('#col-{{ $x }}').find('input[type=checkbox]').prop('checked',this.checked)" value="" id="kt_roles_select_all" > </label>
                                                                    <div style="width: -webkit-fill-available;text-align: center;" data-bs-toggle="collapse" href="#col-{{ $x }}" role="button" aria-expanded="false" aria-controls="col-{{ $x }}"   >
                                                                        <label class="text-gray-800">{{$key}}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="collapse" id="col-{{ $x }}">
                                                <div class="card card-body">
                                                            @foreach ($permissionval as $permission)


                                                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-lg-20">
                                                                    <input class="form-check-input " type="checkbox" name="permission[{{ $permission->name }}]"
                                                                value="{{ $permission->name }}"
                                                                    />
                                                                    <span class="form-check-label">{{ $permission->friendly_name }} </span>
                                                                </label>

                                                            @endforeach
                                                            </div>
                                                </div>
                                                            @endforeach
                                        <!--end::Table wrapper-->
                                    </div>
                                    <!--end::Permissions-->
                                </div>
                                <!--end::Scroll-->
                                <!--begin::Actions-->
                                <div class="text-center pt-15">

                                    <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
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
            <!--end::Modal - Add role-->
            <!--begin::Modal - Update role-->
            <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bolder">Update Role</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
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
                        <div class="modal-body scroll-y mx-5 my-7">
                            <!--begin::Form-->
                            <form id="kt_modal_update_role_form" class="form" action="#">
                                <!--begin::Scroll-->
                                <div class="d-flex flex-column scroll-y" id="kt_modal_update_role_scroll"
                                    data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                    data-kt-scroll-max-height="auto"
                                    data-kt-scroll-dependencies="#kt_modal_update_role_header"
                                    data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bolder form-label mb-2">
                                            <span class="required">Role name</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="Enter a role name"
                                            name="role_name" value="Developer" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Permissions-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
                                        <!--end::Label-->
                                        <!--begin::Table wrapper-->
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-bold">
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <td class="text-gray-800">Administrator Access
                                                            <i class="fas fa-exclamation-circle ms-1 fs-7"
                                                                data-bs-toggle="tooltip"
                                                                title="Allows a full access to the system"></i>
                                                        </td>
                                                        <td>
                                                            <!--begin::Checkbox-->
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                                <input class="form-check-input" type="checkbox" value=""
                                                                    id="kt_roles_select_all" />
                                                                <span class="form-check-label"
                                                                    for="kt_roles_select_all">Select all</span>
                                                            </label>
                                                            <!--end::Checkbox-->
                                                        </td>
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800">User Management</td>
                                                        <!--end::Label-->
                                                        <!--begin::Input group-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox" value=""
                                                                        name="user_management_read" />
                                                                    <span class="form-check-label">Read</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox" value=""
                                                                        name="user_management_write" />
                                                                    <span class="form-check-label">Write</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox" value=""
                                                                        name="user_management_create" />
                                                                    <span class="form-check-label">Create</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Input group-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800">Content Management</td>
                                                        <!--end::Label-->
                                                        <!--begin::Input group-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="content_management_read" />
                                                                    <span class="form-check-label">Read</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="content_management_write" />
                                                                    <span class="form-check-label">Write</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="content_management_create" />
                                                                    <span class="form-check-label">Create</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Input group-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800">Financial Management</td>
                                                        <!--end::Label-->
                                                        <!--begin::Input group-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="financial_management_read" />
                                                                    <span class="form-check-label">Read</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="financial_management_write" />
                                                                    <span class="form-check-label">Write</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="financial_management_create" />
                                                                    <span class="form-check-label">Create</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Input group-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800">Reporting</td>
                                                        <!--end::Label-->
                                                        <!--begin::Input group-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="reporting_read" />
                                                                    <span class="form-check-label">Read</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="reporting_write" />
                                                                    <span class="form-check-label">Write</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="reporting_create" />
                                                                    <span class="form-check-label">Create</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Input group-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800">Payroll</td>
                                                        <!--end::Label-->
                                                        <!--begin::Input group-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="payroll_read" />
                                                                    <span class="form-check-label">Read</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="payroll_write" />
                                                                    <span class="form-check-label">Write</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="payroll_create" />
                                                                    <span class="form-check-label">Create</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Input group-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800">Disputes Management</td>
                                                        <!--end::Label-->
                                                        <!--begin::Input group-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="disputes_management_read" />
                                                                    <span class="form-check-label">Read</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="disputes_management_write" />
                                                                    <span class="form-check-label">Write</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="disputes_management_create" />
                                                                    <span class="form-check-label">Create</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Input group-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800">API Controls</td>
                                                        <!--end::Label-->
                                                        <!--begin::Input group-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="api_controls_read" />
                                                                    <span class="form-check-label">Read</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="api_controls_write" />
                                                                    <span class="form-check-label">Write</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="api_controls_create" />
                                                                    <span class="form-check-label">Create</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Input group-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800">Database Management</td>
                                                        <!--end::Label-->
                                                        <!--begin::Input group-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="database_management_read" />
                                                                    <span class="form-check-label">Read</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="database_management_write" />
                                                                    <span class="form-check-label">Write</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="database_management_create" />
                                                                    <span class="form-check-label">Create</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Input group-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800">Repository Management</td>
                                                        <!--end::Label-->
                                                        <!--begin::Input group-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="repository_management_read" />
                                                                    <span class="form-check-label">Read</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="repository_management_write" />
                                                                    <span class="form-check-label">Write</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="repository_management_create" />
                                                                    <span class="form-check-label">Create</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Input group-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Table wrapper-->
                                    </div>
                                    <!--end::Permissions-->
                                </div>
                                <!--end::Scroll-->
                                <!--begin::Actions-->
                                <div class="text-center pt-15">

                                    <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
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
            <!--end::Modal - Update role-->
            <!--end::Modals-->
        </div>
        <!--end::Container-->

<script type="text/javascript">
    function check_all(check) {
        console.log('run');
        var a = document.getElementsByClassName('checkall');
        if (check == true) {
            for (var i = 0; i < a.length; i++) {
                a[i].checked = true;
            }
        } else {
            for (var i = 0; i < a.length; i++) {
                a[i].checked = false;
            }
        }
    }

function openForm() {
        document.getElementById("popupForm").style.display = "block";
      }
function closeForm() {
document.getElementById("popupForm").style.display = "none";
}
</script>

    </div>
    <!--end::Col-->



</x-base-layout>
