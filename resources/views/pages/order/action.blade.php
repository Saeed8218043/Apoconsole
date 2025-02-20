 <?php $row = (object)$row;   ?>

 <a href="#" onclick="edit_profit_sheet({{$row->id}} )" data-bs-toggle="modal" data-bs-target="#edit_profit_sheet" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
    <span class="svg-icon svg-icon-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
        </svg>
    </span>
    <!--end::Svg Icon-->
</a>

 <a href="#" onclick="detail('{{ $row->id }}')" data-bs-toggle="modal" data-bs-target="#kt_modal_detail_coupon" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
     <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
     <span class="svg-icon svg-icon-3">
         <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="442.04px" height="442.04px" viewBox="0 0 442.04 442.04" style="enable-background:new 0 0 442.04 442.04;" xml:space="preserve">
             <g>
                 <g>
                     <path d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203
			c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219
			c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367
			c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021
			c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212
			c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071
			c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z" />
                 </g>
                 <g>
                     <path d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188
			c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993
			c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5
			s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z" />
                 </g>
                 <g>
                     <path d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z" />
                 </g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
             <g>
             </g>
         </svg>

     </span>
     <!--end::Svg Icon-->
 </a>

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

  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-danger fw-bold fs-7 w-125px py-4" data-kt-menu="true">
     <div onclick="rma('{{ $row->id }}')" class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#trqrma">
         <a href="#" class="menu-link px-3">RMA</a>
     </div>
     <div onclick="refund('{{ $row->id }}')" class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#trqrefund">
         <a href="#" class="menu-link px-3">Refund</a>
     </div>
     <div onclick="replacement('{{ $row->id }}')" class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#trqreplacement">
         <a href="#" class="menu-link px-3">replacement</a>
     </div>
     <div onclick="cancel('{{ $row->id }}')" class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#trqcancel">
         <a href="#" class="menu-link px-3">Cancel</a>
     </div>
     @if($row->store ==='')
     <di onclick="select_store('{{ $row->id }}')" class="menu-item px-3" data-bs-toggle="modal" data-bs-target="#select_store" >
        <a href="#" class="menu-link px-3" >store</a>
    </div>
     @endif
 </div>

 @if (!isset(json_decode($row->vendor_json,true)['id']))
 <div data-kt-users-table-filter="delete_row" data-id="{{ $row->id }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
     <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg -->

     <span class="svg-icon svg-icon-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
             <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
             <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
             <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
         </svg>
     </span>

 </div>

 @endif
