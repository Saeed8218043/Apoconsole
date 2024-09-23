
        <a href="#" class="btn btn-light btn-active-light-danger btn-sm" data-kt-menu-trigger="click"
    data-kt-menu-placement="bottom-end">Actions

    <span class="svg-icon svg-icon-5 m-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path
                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                fill="black" />
        </svg>
    </span>
</a>
			<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-danger fw-bold fs-7 w-125px py-4"
    data-kt-menu="true">
    <div  onclick="edit('{{ $row->id }}')" class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_coupon" >
        <a href="#"  class="menu-link px-3">Edit</a>
    </div>
    <div  data-kt-users-table-filter="delete_row" data-id="{{ $row->id }}"   class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#trqrefund" >
        <a href="#" class="menu-link px-3" >Delete</a>
    </div>

    @if ($row->status==="Low quantity" || $row->status==="Stocked out")
    <div  onclick="reOrder('{{ $row->id }}')" class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#reOrder" >
        <a href="#" class="menu-link px-3" >Re-Order</a>
    </div>
    @endif


</div>


