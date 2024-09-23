<x-base-layout>

   <!--begin::Col-->
   <div class="">
   <?php

$default_image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAPFBMVEXm5uampqajo6Pa2trp6emhoaHl5eXg4OCoqKjc3Nzf39/W1tatra2wsLDIyMi8vLy2trbExMTOzs61tbXhv6YVAAAEl0lEQVR4nO2d27aqMAxFpYSbioL+/79uEPEGW4WmSepY8+287Tlikza0OZsNAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKUMcmL4ptUeTDP36JTqc6ted9mTiXOZeU+3N7qja/YtnZHZqyF3ukUy2bQ2ep/ed5Q9tD7V7s7pauPmzjdqS0SebtbpZJk8brSOn5n+g9R/IcqSNVdfZRbyCrq/gcKW+/iN89jm0emSPt9t/7XRz3u6gUqV3md3Fs41Gk/LxcsFM8x/JLpapcI9gplnEkHNqt0huIYTHSbl0Ar2G0r0ipj2CnaL36U+Un2CkaX4tF6SmYJGWhLfGW2jeEXRBrbYk30NFfsFM8mv2d0u7brfZ7MrMJNWfx68m1Vebh+Y32GP2d+pX6F0Wbv9OaTTBJLOZTOvGkmYHsZDCIe0bBJNlr60zgqhQj9ioGca7CntqaYcUbwi6IlbbSM3y1cMRaTcz9zxSvlLY2NozVfsTttKUeWdM9/Ghoq7vInUl7TO1rtgEEk2SrrXWHc9N9x9L2mw5BDA+GDNmr4cXQUkUMkWhMpZoA9b7HUM0vgggmiZ3OqXejex5nZ/Pt+a3iX8NUW+xGyn10Gsjs7EyZz/cwVOD31+Hv59IwRwtLh4vf39PkvN3gkb0dQ2qCnC0aO2eLEG0aW40aOgUxtPR1Jki5MFQsAqUaQ4kmTBvDVBMjyEI0tQzDnPLtnPB7qGEXNFQNL7AfoAwdnQaIe2taGgshe9vbUsP7Ct+VrwFLxXCAd29qaU96g+Hy7B2T12g5V6LBVXiBb3Nq70bUBWJrDGdWL+xzJRuTaeYKw0V241fZedqKdpqIUziuLFi6oDCD/z1ak3dnH6HWTzEznGWu+CVUy2n0hk8UI4hgDx3WKmZGN2sTaPdhkMI8LooXpANUrCj9ri6iEexZnG9cq/0nL2ThyIHYBg700JJPbq6JbhoPbdtFj/Jd2UY1qIbS44KxH1dHd7R6KpxAabPYb3CMYxgPFev8ro7mKwblbea1L82MD6pZPJZmxtFy3aCc6bW61TBSunJqy0SxtJlxfr4jnB9Z3wE31r7MUOGdYp5xe1t1g20JPiiaWoyUMusN2FEM87DLUOc0lKAZxXCCRhSpCubXY2BqFOvH7Sn6n7tzlg9q/+Nq5dIf5m3lk6LuFcX17e3vUW2E+8+f+wbNGXWBXiG8ondZOMwV/Sl6n9wCPeiaUdR64iXzG+3RuUEUZszAPDpn/kJOsFNU2NqEr/VPhgp1X6QUPiiKP6CRDaFGEIVDKB9E6RDKBzHUJIx3iKZTyVo4IlsT2d+PfIPoG5NAgzDekwnuTuXzTI9krgn0/v4Tgu/zA3ZI3yE3Z1DnRyr5MxVqXkwRa2eI79hGpHZuYeYLfGUodMtdaxkKLkStZSjWr9HYdY/I7L7FmohTZNqKeolGKtVIdbpnDUW633qpVCqZss+XX4LILHqV0++IyCmYe7TAMiR2pqLd/FdEuvu/b7jV6NGMZBJvhH/fkP3/6lhkKHFC3GZOD5EY5qkm1i5HAwAAAAAAAAAAAAAAAAAAAACAJf4AKkJE8O36wbkAAAAASUVORK5CYII=';


?>

<!--begin::Content-->
<div class="content p-6" id="kt_content">
    <!--begin::Container-->
    <div class="container-fluid p-0" id="kt_content_container">
        <!--begin::Layout-->
        <div class="">
            <!--begin::Sidebar-->
                <!--begin::Card-->
                <div class="card h-md-100 border rounded-3 p-6 shadow-sm mb-6">

                    <div class="mb-3 d-flex align-items-center gap-2">
                        <h3 class="m-0 text-capitalize">{{ $data->name }} Permissions</h3>
                        <a href="#" onclick="edit()" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </div>



                    <!--begin::Card body-->
                    <div class="card-body p-0">
                        <!--begin::Permissions-->

                        <div class="d-flex flex-wrap gap-1 userRoleBadgesWrap">
                             @php $x=0;
                                $count=count($data->permissions);
                                if ($count > 5 ){
                                $count-=5;
                            }
                                 @endphp

                            @foreach($data->permissions as $role)
                             @php
                            $x++;
                            if($x > 50){
                             @endphp
                                <a class="btn btn-light btn-sm rounded-pill mb-1 text-capitalize border" href="#"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_role"  >and {{ $count }} more...</a>
                            @php
                            break;
                        }
                             @endphp

                            <span class="btn btn-light btn-sm rounded-pill mb-1 text-capitalize border">
                                {{  $role->module_name." ".$role->friendly_name }}
                            </span>


                            @endforeach()
                            <!-- <div class="d-flex align-items-center py-2 d-none">
                                <span class='bullet bg-primary me-3'></span>
                                <em>and 3 more...</em>
                            </div> -->
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer flex-wrap p-0 mt-3 border-top-0">
                        <button type="button" onclick="edit()" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role"><i class="bi bi-pencil"></i> Edit Role</button>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
                <!--begin::Modal-->
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
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
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
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 my-7">
                                <!--begin::Form-->
                                <form id="kt_modal_update_role_form" class="form" method="post" >
                                     @method('put')
                                     @csrf
                                    <!--begin::Scroll-->
                                    <div class="d-flex flex-column scroll-y" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-bolder form-label mb-2">
                                                <span class="required">Role name</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" placeholder="Enter a role name" name="name" value="{{ $data->name }}" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Permissions-->
                                        <div class="fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>











                                            <!--end::Label-->
                                            <!--begin::Table wrapper-->

                                            <!--end::Table wrapper-->



                                            @php $x=0; @endphp

                                             @foreach ($data['permissionss']->groupBy('module_name') as $key=>$permissionval)
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
                                                               {{ in_array($permission->name, $data->permissions->pluck('name')->toArray())
                                                                   ? 'checked'
                                                                     : '' }}  />
                                                                <span class="form-check-label">{{ $permission->friendly_name }} </span>
                                                            </label>

                                                        @endforeach
                                                        </div>
                                            </div>
                                                         @endforeach







                                        </div>
                                        <!--end::Permissions-->
                                    </div>
                                    <!--end::Scroll-->
                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <!-- <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Discard</button> -->
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
                <!--end::Modal-->
            <!--begin::Content-->
            <div class="">
                <!--begin::Card-->
                <div class="card h-md-100 border rounded-3 p-6 shadow-sm">
                    <!--begin::Card header-->
                    <div class="">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h3 class="d-flex align-items-center mb-2 text-capitalize">Users Assigned to {{ $data->name }}
                                <span class="text-gray-600 fs-6 ms-1">({{ count($data->users) }})</span>
                            </h3>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Search-->
                           <!--  <div class="d-flex align-items-center position-relative my-1" data-kt-view-roles-table-toolbar="base">

                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                    </svg>
                                </span>

                                <input type="text" data-kt-roles-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Users" />
                            </div> -->
                            <!--end::Search-->
                            <!--begin::Group actions-->
                            <div class="d-flex justify-content-end align-items-center d-none" data-kt-view-roles-table-toolbar="selected">
                                <div class="fw-bolder me-5">
                                <span class="me-2" data-kt-view-roles-table-select="selected_count"></span>Selected</div>
                                <button type="button" class="btn btn-danger" data-kt-view-roles-table-select="delete_selected">Delete Selected</button>
                            </div>
                            <!--end::Group actions-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-0">
                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_roles_view_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_roles_view_table .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-50px">ID</th>
                                        <th class="min-w-150px">User</th>

                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    @foreach($data->users as $user)
                                    <tr>
                                        <!--begin::Checkbox-->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input " type="checkbox" value="1" />
                                            </div>
                                        </td>
                                        <!--end::Checkbox-->
                                        <!--begin::ID-->
                                        <td>{{ $user->id }}</td>
                                        <!--begin::ID-->
                                        <!--begin::User=-->
                                        <td class="d-flex align-items-center">
                                            <!--begin:: Avatar -->
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <a href="#">
                                                    <div class="symbol-label">
                                                        <img src="@if (isset($user['image']) && !empty($user['image'])) {{ asset('/assets/avatar/'.$user['image']) }} @else {{ $default_image }} @endif" alt="Emma Smith" class="w-100" />
                                                    </div>

                                                </a>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::User details-->
                                            <div class="d-flex flex-column">
                                                <a href="#" class="text-gray-800 text-hover-primary mb-1">{{ $user->name }}</a>
                                                <span>{{ $user->email }}</span>
                                            </div>
                                            <!--begin::User details-->
                                        </td>
                                        <!--end::user=-->
                                        <!--begin::Joined date=-->

                                    </tr>
                                    @endforeach


                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>
    <!--end::Container-->
</div>
<!--end::Content-->




<script type="text/javascript">
    var name= '<?= $data->name ?>';
    var userpermissions = <?= json_encode($data->permissions->pluck('name')->toArray()) ?>;
    function check_all(check){
        console.log('run');
       var a=  document.getElementsByClassName('checkall');
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

    function edit(){
        $('input[name=name]').val(name);
      var a=  document.getElementsByClassName('checkall');
      for (var i = 0; i < a.length; i++) {
             if (userpermissions.includes(a[i].value)) {
                a[i].checked = true;
             } else {
                 a[i].checked = false;
             }
        }
    }
</script>
</div>
<!--end::Col-->



</x-base-layout>
