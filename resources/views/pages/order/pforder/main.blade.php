


<x-base-layout>
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
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search Inventory Price" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar ">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                
                  

                    {{ theme()->getView('pages/order/edit_niches') }}
                    
                    
                   
                    {{ theme()->getView('pages/order/pforder/detail') }}
                    
                    {{ theme()->getView('pages/order/pforder/punch_mail') }}
                    
                    {{ theme()->getView('pages/order/pforder/add_order') }}
                    
                    
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" style="display: none;"  data-kt-menu-trigger="click"
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
                                <label class="form-label fs-6 fw-bold">Status:</label>
                                <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                    data-placeholder="Select option" data-allow-clear="true"
                                    data-kt-user-table-filter="role" data-hide-search="true">
                                    <option></option>
                                    <option value="1" >Experied</option>
                                    <option value="2" >Valid</option>
                                    
                                </select>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <!-- <div class="mb-10">
                                <label class="form-label fs-6 fw-bold">Two Step Verification:</label>
                                <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                    data-placeholder="Select option" data-allow-clear="true"
                                    data-kt-user-table-filter="two-step" data-hide-search="true">
                                    <option></option>
                                    <option value="Enabled">Enabled</option>
                                </select>
                            </div> -->
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
                    <button type="button" class="btn btn-light-primary me-3"  style="display: none;"  data-bs-toggle="modal"
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
              

            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 table-responsive">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_coupons">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <!--<input class="form-check-input" type="checkbox" data-kt-check="true"-->
                                <!--    data-kt-check-target="#kt_table_coupons .form-check-input" value="1" />-->
                            </div>
                        </th> 
                        
                        <!--<th class="min-w-50px">ID</th>-->
                        <!-- <th class="min-w-50px">Part No</th> -->
                        <th class="min-w-100px" style="text-align:center !important ;">Date</th>
                         <th class="min-w-50px" style="text-align:center !important ;">PO Number</th>
                        
                        <th class="min-w-50px">Shipping Name</th>
                        <th class="min-w-50px" style="padding-left:20px !important ;">City</th>
                        <th class="min-w-50px" style="padding-left:20px !important ;">Address</th>
                        <th class="min-w-50px">Price</th>
                        <th class="min-w-50px">Status</th>
                        <!--<th class="min-w-125px">CREATED AT</th>-->
                        <th class="min-w-125px">Action</th>
               
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
    
    
    <style>
        .del-item {
            cursor: pointer;
            border: 1px solid white;
            background-color: #f84d4d;
            border-radius: 5px;
            color: white;
        }
    </style>


 @section('scripts')

        <script id="usertable">
        
        @php
        $w = '"shipping_lines":[{"id":';
        $a = '"vendor":"AUTOOUTLET"';
        $lastorder = \App\Models\Order::orderBy('id','desc')->where('order_json', 'LIKE', "%{$w}%")->where('order_json', 'LIKE', "%{$a}%")->get();
        $n=0;
        foreach  ($lastorder as $a ){
         if (isset(json_decode($a->order_json,true)['ponumber']) &&  explode('-',json_decode($a->order_json,true)['ponumber'])[0] == 'g' && (int)explode('-',json_decode($a->order_json,true)['ponumber'])[1] > $n){
          $n = (int)explode('-',json_decode($a->order_json,true)['ponumber'])[1];   
        }   
        }
        
      
        
       
         $new_po = "g-".($n + 1);   
       
        
        @endphp
        
        
        var new_po = '{{ $new_po }}';
        
        $(document).ready(function() {
    $('select[name=item]').select2({
    dropdownParent: $('#kt_modal_add_new_order')
});
});



function add_item(sku){
    // console.log(sku);
    // sku = sku.split(',')
    // for (i=0;i<document.querySelectorAll("input[name='items[]']").length;i++){
    //     if (document.querySelectorAll("input[name='items[]']")[i].value == sku[0]){
    //         return ;
    //     }
    // }
    $('.new_order_item_table').append(' <tr><td scope="col"><input type="text" name="items[]" value=""  /></td><td scope="col">AUTOSPARTOUTLET</td><td scope="col"><input type="number" name="quantity[]" min="1"  value="1"  style="max-width: 50px;"  /></td><td scope="col"><button class="del-item" onclick="this.parentElement.parentElement.remove()" >X</button></td></tr>')
}



            var data;
            var KTUsersList = (function() {
                // Define shared variables
                var table = document.getElementById('kt_table_coupons')
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
                        // const joinedDate = moment(
                        //     dateRow[2].innerHTML,
                        //     'DD MMM YYYY, LT'
                        // ).format() // select date from 5th column in table
                        // dateRow[5].setAttribute('data-order', joinedDate)
                    })

                    // Init datatable --- more info on datatables: https://datatables.net/manual/
                    datatable = $(table).DataTable({
                        ajax: {
                            url: "<?= route('order_pf.datatableapi') ?>",
                            data: {
                                // ;
                                // role_filter: document.getElementById('role_filter').value,
                               //  email_verify: document.getElementById('email_verify').value,
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
                        info: false,
                        order: [],
                        retrieve: true,
                        paging: true,
                         lengthMenu: [10, 40, 60, 80, 100, 500],
                        pageLength: 10,
                        lengthChange: true,
                        columns: [
                             {
                                data: 'checkbox',
                                name: 'checkbox',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                orderable: true,
                                searchable: false
                            },
                            // {
                            //     data: 'id',
                            //     name: 'id',
                            //     orderable: true,
                            //     searchable: false
                            // },
                          
                            // {
                            //     data: 'sku',
                            //     name: 'sku',
                            //     orderable: true,
                            //     searchable: true
                            // },
                            {
                                data: 'po_number',
                                name: 'po_number',
                                orderable: true,
                                searchable: true
                            },
                            
                             {
                                data: 'shipper_name',
                                name: 'shipper_name',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'city',
                                name: 'city',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'address',
                                name: 'address',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'price',
                                name: 'price',
                                orderable: true,
                                searchable: true
                            },
                          {
                                data: 'status',
                                name: 'status',
                                orderable: true,
                                searchable: true
                            },
                         
                   
                            // {
                            //     data: 'created_at',
                            //     name: 'created_at',
                            //     orderable: true,
                            //     searchable: false
                            // },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                           
                           
                        ],
                        columnDefs: [{
                                orderable: false,
                                targets: 0
                            }, // Disable ordering on column 0 (checkbox)
                            {
                                orderable: false,
                                targets: 3
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

                            // Get coupon name
                            const userName = parent
                                .querySelectorAll('td')[1].innerText

                            //const id = parent
                             //   .querySelectorAll('td')[0].innerText
                                
                                const id = $(this).attr('data-id');


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
                                                url: "<?= route('order_pf.bulkdelete') ?>",
                                                type: 'POST',
                                                data: {
                                                    "list": id,
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
                            text: 'Are you sure you want to delete selected ?',
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
                                        text: 'You have deleted all selected !.',
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
                                            url: "<?= route('order_pf.bulkdelete') ?>",
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
                    },
                    reinit: function(){
                        datatable.destroy();
                         initUserTable();
                         data = datatable;
                    },
                    getrows: function(id){
                        var a = datatable.context[0].aoData;
                        for (var i = 0; i < a.length; i++) {
                            if (a[i]['_aData']['id'] == id) {
                              return a[i]['_aData'];  
                            }
                        }
                    }
                }
            })()

            // On document ready
            KTUtil.onDOMContentLoaded(function() {
                KTUsersList.init()
            })

            function edit(id){
               var data =  KTUsersList.getrows(id);
               console.log(data);
               $('#kt_modal_edit_coupon_form').find('input[name=part_no]').val(data['part_no']);
               $('#kt_modal_edit_coupon_form').find('input[name=sku]').val(data['sku']);
               $('#kt_modal_edit_coupon_form').find('input[name=cost]').val(data['cost']);
               $('#kt_modal_edit_coupon_form').find('input[name=qty]').val(data['qty']);
               $('#kt_modal_edit_coupon_form').find('input[name=fee]').val(data['fee']);
               $('#kt_modal_edit_coupon_form').find('input[name=commission]').val(data['commission']);
               $('#kt_modal_edit_coupon_form').find('input[name=shipping]').val(data['shipping']);
               $('#kt_modal_edit_coupon_form').find('input[name=profit]').val(data['profit']);
              
               url = $('#kt_modal_edit_coupon_form').attr('dt-action');
               $('#kt_modal_edit_coupon_form').attr('action',url+'/'+id);               
            }
            var c_data='';
            function detail(id){
                
               var data =  KTUsersList.getrows(id);
               c_data = data;
               $('#kt_modal_detail_coupon_form').find('#trq_id').html(data['phone']);
               $('#kt_modal_detail_coupon_form').find('#status').html(data['status_message']);
               $('#kt_modal_detail_coupon_form').find('#po_number').html(data['po_number']);
               $('#kt_modal_detail_coupon_form').find('#name').html(data['shipper_name']);
               $('#kt_modal_detail_coupon_form').find('#total').html(data['total']);
                $('#kt_modal_detail_coupon_form').find('#site_url').html(data['shop_url']);
               
                $('#kt_modal_detail_coupon_form').find('#address1').html(data['address']);
                $('#kt_modal_detail_coupon_form').find('#address2').html(data['address2']);
                $('#kt_modal_detail_coupon_form').find('#city').html(data['city']); 
                $('#kt_modal_detail_coupon_form').find('#zip').html(data['zip']);
                $('#kt_modal_detail_coupon_form').find('#created_at').html(data['created_order']);
                 $('#kt_modal_detail_coupon_form').find('#province_code').html(data['province_code']);
                  $('#kt_modal_detail_coupon_form').find('#contact_email').html(data['contact_email']); 
               console.log("show data");
              console.log(data);
              console.log("show data");
              $('.item_table').find('tbody').html(" ");
              for(i=0;i<data['items'].length;i++){
                $('.item_table').find('tbody').append('<tr><th scope="row">'+i+'</th><td>'+data['items'][i]['sku']+'</td><td>AUTOSPARTOUTLET</td><td>'+data['items'][i]['quantity']+'</td></tr>')  
              }
              
            }
        
  




// *******************************
var temp = '';
var response = '';


var total_orders = 0;
var orders_data = '';
var order_num = 0;





// for(i=0;i<10;i++){
//     $.ajax({
//     url: "/get_php_data",
//     async: false, 
//     dataType: 'json',
//     success: function (json) {
      
//     }
//   });
// }



function punch_order(order){
    if (order_num <= total_orders){
       axios.post("{{ route('csv_punch_order') }}",order).then(function(res){ orders_data[order_num].res = res; }).catch(function (err){  }).then(function () { order_num++; punch_order(orders_data[order_num]); });
       update_punching_order_info();
    } else {
        KTUsersList.reinit();
    }
}

function update_punching_order_info(){
    var so=0;
    var fo=0;
    
    orders_data.forEach(function (a,b){ if (a.res != undefined && a.res.data != undefined && a.res.data.id != undefined ){ so++; } })
    orders_data.forEach(function (a,b){ if (a.res != undefined && a.res.data != undefined && a.res.data.id == undefined ){ fo++; } })
    
    $('.progress-div').find('.order-info').find('tbody').html('<tr><td>Total Orders</td><td>'+total_orders+'</td></tr><tr><td>Success Orders</td><td>'+so+'</td></tr><tr><td>Failed Orders</td><td>'+fo+'</td></tr>')
    var table_data = '';
    for (var i =0;i<order_num;i++){
        if (orders_data[i].res != undefined && orders_data[i].res.data != undefined && orders_data[i].res.data.id != undefined){
          table_data += '<tr><td>'+orders_data[i].poNumber+'</td><td><p style="color: green">Success</p></td><td><p style="color: green">'+orders_data[i].res.data.id+'</p></td></tr>';
        }
        if (orders_data[i].res != undefined && orders_data[i].res.data != undefined && orders_data[i].res.data.id == undefined && orders_data[i].res.data.errors != undefined){
          table_data += '<tr><td>'+orders_data[i].poNumber+'</td><td><p style="color: red">Failed</p></td><td><p style="color: red">'+orders_data[i].res.data.errors[0]+'</p></td></tr>';
        }
         if (orders_data[i].res != undefined && orders_data[i].res.data != undefined && orders_data[i].res.data.id == undefined && orders_data[i].res.data.error != undefined){
          table_data += '<tr><td>'+orders_data[i].poNumber+'</td><td><p style="color: red">Failed</p></td><td><p style="color: red">'+orders_data[i].res.data.error+'</p></td></tr>';
        }
    }
    
    $('.progress-div').find('.order-data').find('tbody').html(table_data)
    $('.progress-div').find('.progress-bar')[0].innerText = (order_num/total_orders*100).toFixed(2);
    $('.progress-div').find('.progress-bar')[0].style.width = (order_num/total_orders*100).toFixed(2)+'%'
}




$(document).ready(function(){

        
        
        
        
        
        
        
        
        
        
        
          $('#pf_order_punch_mail_form').on('submit', function(event){

        event.preventDefault();
        temp=this;
        $(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
        $(this).find('button[type=submit')[0].disabled = true;
        
        

 
     
        
        axios.post('{{ route('order_pf.send_mail') }}',new FormData(this)).then(function (data){
                
       
        $(temp).find('button[type=submit')[0].removeAttribute('data-kt-indicator');
        $(temp).find('button[type=submit')[0].disabled = false;  
        
        console.log(data);
           Swal.fire({
                                text: data.data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                 window.location.reload();
                                
                            });
        }).catch(function (err){
             $(temp).find('button[type=submit')[0].removeAttribute('data-kt-indicator');
        $(temp).find('button[type=submit')[0].disabled = false;  
        
        let message = typeof err.response !== "undefined" ? err.response.data.message : err.message;
  
           Swal.fire({
                                text: message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                // window.location.reload();
                                
                            });
        });

        });
        
        
        
        
        
        
          $('#pf_order_punch_mail_new_order_form').on('submit', function(event){

        event.preventDefault();
        temp=this;
        $(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
        $(this).find('button[type=submit')[0].disabled = true;
        
        

 
     
        
        axios.post('{{ route('order_pf.send_mail') }}',new FormData(this)).then(function (data){
                
       
        $(temp).find('button[type=submit')[0].removeAttribute('data-kt-indicator');
        $(temp).find('button[type=submit')[0].disabled = false;  
        
        console.log(data);
           Swal.fire({
                                text: data.data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                 window.location.reload();
                                
                            });
        }).catch(function (err){
             $(temp).find('button[type=submit')[0].removeAttribute('data-kt-indicator');
        $(temp).find('button[type=submit')[0].disabled = false;  
        
        let message = typeof err.response !== "undefined" ? err.response.data.message : err.message;
  
           Swal.fire({
                                text: message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                // window.location.reload();
                                
                            });
        });

        });
        
        
        
        
        
        
       
        
        
        
        
        
        
        
        

});


 function punch_mail(id){
            
               var data =  KTUsersList.getrows(id);
               document.test = data;

            //   $('#pf_order_punch_mail').find('#trq_id').html(data['trq_id']);
            //   $('#pf_order_punch_mail').find('#status').html(data['status_message']);
            //   $('#pf_order_punch_mail').find('#po_number').html(data['po_number']);
            //   $('#pf_order_punch_mail').find('#name').html(data['shipper_name']);
            //   $('#pf_order_punch_mail').find('#total').html(data['total']);
            //     $('#pf_order_punch_mail').find('#site_url').html(data['shop_url']);
               
            //     $('#pf_order_punch_mail').find('#address1').html(data['address']);
            //     $('#pf_order_punch_mail').find('#address2').html(data['address2']);
            //     $('#pf_order_punch_mail').find('#city').html(data['city']); 
            //     $('#pf_order_punch_mail').find('#zip').html(data['zip']);
            //     $('#pf_order_punch_mail').find('#created_at').html(data['created_order']);
            //      $('#pf_order_punch_mail').find('#province_code').html(data['province_code']);
            //       $('#pf_order_punch_mail').find('#contact_email').html(data['contact_email']); 
            
            
            if (data['po_number'].split('-')[0] == 'g'){
                $('#pf_order_punch_mail').find('input[name=ponumber]').val(data['po_number']);  
            } else {
                $('#pf_order_punch_mail').find('input[name=ponumber]').val(new_po);
            }
            
            
            
            $('#pf_order_punch_mail').find('input[name=phone]').val(data['phone']);
            $('#pf_order_punch_mail').find('input[name=shippingName]').val(data['shippingName']);
            $('#pf_order_punch_mail').find('input[name=shippingAddress1]').val(data['shippingAddress1']);
            $('#pf_order_punch_mail').find('input[name=shippingAddress2]').val(data['shippingAddress2']);
            $('#pf_order_punch_mail').find('input[name=shippingPostalCode]').val(data['shippingPostalCode']);
            $('#pf_order_punch_mail').find('input[name=shippingCity]').val(data['shippingCity']);
            $('#pf_order_punch_mail').find('input[name=shippingCountry]').val(data['shippingCountry']);
            $('#pf_order_punch_mail').find('input[name=shippingRegion]').val(data['shippingRegion']);
            
            
             $('#pf_order_punch_mail').find('input[name=order_id]').val(id);
              
              $('#pf_order_punch_mail').find('tbody').html(" ");
              for(i=0;i<data['items'].length;i++){
                $('#pf_order_punch_mail').find('tbody').append('<tr><th scope="row"><input type="hidden" name="items[]" value="'+data['items'][i]['sku']+'" >'+i+'</th><td>'+data['items'][i]['sku']+'</td><td>AUTOSPARTOUTLET</td><td><input type="hidden" name="qty[]" value="'+data['items'][i]['quantity']+'" >'+data['items'][i]['quantity']+'</td></tr>')  
              }
           
              
              
              
        }
        


        </script>






    @endsection


</x-base-layout>
