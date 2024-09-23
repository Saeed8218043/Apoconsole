


<x-base-layout>
<div class="card ">



    <div class="p-6 pb-0">

        <div class="row gx-2">
            <div class="col-sm-2">
                <label for="" class="fw-bold">Number of orders</label>
                <h5 class="m-0 p-3 bg-light-success rounded mb-3 border">Today: {{ $orders??0 }}</h5>
                <h5 class="m-0 p-3 bg-light-success rounded mb-3 border">30 Days: {{ $monthlyOrders??0 }}</h5>
            </div>

            <div class="col-sm-2">
                <label for="" class="fw-bold">Cost </label>
                 <h5 class="m-0 p-3 bg-light-success rounded mb-3 border">Today:  ${{ number_format($day_cost ?? 0, 1) }}</h5>
                 <h5 class="m-0 p-3 bg-light-success rounded mb-3 border">30 Days: ${{ number_format($cost_30 ?? 0, 1) }}</h5>
            </div>

            <div class="col-sm-2">
                <label for="" class="fw-bold">Sales</label>
                <h5 class="m-0 p-3 bg-light-success rounded mb-3 border">Today:  ${{ number_format($sales_price ?? 0, 1) }}</h5>
                <h5 class="m-0 p-3 bg-light-success rounded mb-3 border">30 Days: ${{ number_format($sales_30 ?? 0, 1) }}</h5>
            </div>

            <div class="col-sm-2">
                <label class="d-block" for="">&nbsp;</label>
                <a type="button" href="{{ route('exportCsvToday') }}" class="btn btn-primary btn-sm mb-3 d-inline-flex align-items-center" style="height: 40px">Today sheet</a>
                <a type="button" href="{{ route('exportCsvMonth') }}" class="btn btn-primary btn-sm mb-3 d-inline-flex align-items-center" style="height: 40px">Monthly sheet</a>
            </div>
        </div>








    </div>

        <!--begin::Card header-->
        <div class="card-header border-0">
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
            <div class="card-toolbar w-100 align-items-start">

                <a type="button" href="{{ route('exportCsvFiltered') }}" id="exportCsvButton" class="btn btn-primary me-2" >Tracking
                </a>
                <!--begin::Toolbar-->
                <div class="d-flex flex-wrap gap-1 me-0 me-lg-auto mb-2" data-kt-user-table-toolbar="base" data-kt-user-table-filter="form">
                       <select name="status" class="form-select form-control-solid me-2" style="font-size: 12px; width: auto; margin-right: .75rem !important; background-color: #0000001a;">
                        <option>All</option>
                        <option>Open</option>
                        <option>Shipped</option>
                        <option>delivered</option>
                    </select>

                    <input type="date" name="start_date" class="form-control form-control-solid w-auto" style="font-size: 12px; background-color: #0000001a;">

                    <input type="date" name="end_date" class="form-control form-control-solid w-auto" style="font-size: 12px; background-color: #0000001a;">

                    <button type="reset" class="btn btn-light btn-active-light-primary fw-bold" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset" style="font-size: 12px; width: auto;">Reset</button>

                    <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" style="font-size: 12px; width: auto; margin-right: .75rem !important;" data-kt-user-table-filter="filter">Apply</button>

                </div>
                <div class="d-flex flex-wrap gap-1 mb-2" data-kt-user-table-toolbar="base">
                    <a type="button" href="{{ route('exportToCsv') }}" class="btn btn-primary me-2" >{{ $file_name }}
                   </a>
                 {{ theme()->getView('pages/order/select_store') }}
                 {{ theme()->getView('pages/vendors/trqdetail') }}


                 {{ theme()->getView('pages/vendors/trqedit') }}


                    {{ theme()->getView('pages/vendors/trqrma') }}
                    {{ theme()->getView('pages/vendors/trqreplacement') }}


                    {{ theme()->getView('pages/vendors/trqrefund') }}


                    {{ theme()->getView('pages/vendors/trqcancel') }}

                    {{ theme()->getView('pages/order/add_csv',['users'=>$users]) }}


                 {{ theme()->getView('pages/order/add_order',['users'=>$users]) }}

                    {{ theme()->getView('pages/order/edit_niches') }}

                    {{-- {{ theme()->getView('pages/order/detail') }} --}}
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-2" style="display: none;"  data-kt-menu-trigger="click"
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
                            {{-- <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-bold me-2 px-6"
                                    data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                <button type="submit" class="btn btn-primary fw-bold px-6" data-kt-menu-dismiss="true"
                                    data-kt-user-table-filter="filter">Apply</button>
                            </div> --}}
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
                        <th class="min-w-50px" style="text-align:center !important ;">Date</th>
                         <th class="min-w-50px" style="text-align:center !important ;">PO Number</th>

                        <th class="min-w-50px">Shipping Name</th>
                        <th class="min-w-50px" style="padding-left:20px !important ;">City</th>
                        <th class="min-w-50px" style="padding-left:20px !important ;">Address</th>
                        <th class="min-w-50px">Store</th>
                        <th class="min-w-50px">Cost</th>
                        <th class="min-w-50px">Sales price</th>
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

        $(document).ready(function() {
    $('select[name=item]').select2({
    dropdownParent: $('#kt_modal_add_new_order')
});
});


$('#exportCsvButton').on('click', function (e) {
    // Prevent the default link behavior
    e.preventDefault();
   var start_date = document.querySelector('input[name="start_date"]').value;
   var end_date = document.querySelector('input[name="end_date"]').value;
    // Fetch the filtered data and trigger the CSV export
    $.ajax({
        url: "{{ route('exportCsvFiltered') }}",
        type: 'POST',
        data: {
            start_date: document.querySelector('input[name="start_date"]').value,
            end_date: document.querySelector('input[name="end_date"]').value,
            status: document.querySelector('select[name="status"]').value,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // Create a Blob from the response
            var blob = new Blob([response], { type: 'text/csv' });

            // Create a link element and set its attributes
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = (start_date && end_date) ? "filtered_" + start_date + " - " + end_date + ".csv" : "filtered_all_data.csv";

            // Append the link to the document
            document.body.appendChild(link);

            // Trigger a click on the link to start the download
            link.click();

            // Remove the link from the document
            document.body.removeChild(link);
        }
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
    $('.new_order_item_table').append(' <tr><td scope="col"><input type="text" name="items[]" value=""  /></td><td scope="col">TRQ</td><td scope="col"><input type="number" name="quantity[]" min="1"  value="1"  style="max-width: 50px;"  /></td><td scope="col"><button class="del-item" onclick="this.parentElement.parentElement.remove()" >X</button></td></tr>')
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
                            url: "<?= route('order.datatableapi') ?>",
                            data: function (d) {
                                // Add filter parameters only if they are provided
                                if (document.querySelector('input[name="start_date"]').value) {
                                    d.start_date = document.querySelector('input[name="start_date"]').value;
                                }
                                if (document.querySelector('input[name="end_date"]').value) {
                                    d.end_date = document.querySelector('input[name="end_date"]').value;
                                }
                                if (document.querySelector('select[name="status"]').value) {
                                    d.status = document.querySelector('select[name="status"]').value;
                                }
                                if (document.querySelector('[data-kt-user-table-filter="search"]').value) {
                                    d.search = document.querySelector('[data-kt-user-table-filter="search"]').value;
                                }
                                return d;
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
                                data: 'store',
                                name: 'store',
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
                                data: 'sales_price',
                                name: 'sales_price',
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
                    const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
                    filterSearch.addEventListener('keyup', function(e) {
                        const searchTerm = e.target.value;

                        // Use fetch to make an AJAX request
                        fetch(`/order/datatableapi?search=${encodeURIComponent(searchTerm)}`)
                            .then(response => response.json())
                            .then(data => {
                                // Update your DataTable with the new data
                                datatable.clear().rows.add(data).draw();
                            })
                            .catch(error => {
                                console.error('Error fetching data:', error);
                            });
                    });
                };


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
                        //console.log(document.getElementById('role_filter').value);
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
                        const start_date = document.querySelector('input[name="start_date"]')
                        const end_date = document.querySelector('input[name="end_date"]')
                        // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
                        selectOptions.forEach(select => {
                            $(select)
                                .val('All')
                                .trigger('change')
                        })
                        $(start_date).val('').trigger('change')
                        $(end_date).val('').trigger('change')
                        // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()

                        // handleSearchDatatable();
                          datatable.draw()
                         initUserTable();
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
                                                url: "<?= route('order.bulkdelete') ?>",
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
                                            url: "<?= route('order.bulkdelete') ?>",
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

            function select_store(id){
               var data =  KTUsersList.getrows(id);
               console.log(data);
               $('#kt_modal_select_credits_scroll').find('input[name=row_id]').val(id);
            }


            var c_data='';


           function showError(errorMessage) {
    // Display the error message in the designated element
    $('.error-message').text(errorMessage);
}

function edit_profit_sheet(id){
               var data =  KTUsersList.getrows(id);
               console.log(data);
               hideLoader('#edit_profit_sheet');
                 showLoader('#edit_profit_sheet');
                $('#edit_profit_sheet .modal-body').hide();

                 $.ajax({
            url:"{{route('get_profit_sheet')}}",
            method:"GET",
            data:{id:id},
            dataType:'json',
              headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
            success:function(data)
            {
                console.log(data);
                    hideLoader('#edit_profit_sheet');
                    var rawDate = data.data.orderDate;

                    // Parse the raw date string into a Date object
                    var parsedDate = new Date(rawDate);

                    // Format the date using JavaScript's Date methods
                    var formattedDate = parsedDate.toLocaleString();

                    header = 'ID:   '+data.data.id+'<br>PO:  '+data.data.poNumber+'<br>'+'Name: '+data.data.shippingName+'<br>Date: '+formattedDate+'<br>'+data.data.status;
                    $('#order_edit_header').html(header);
                if(data.data.error != undefined){
                    showError(data.data.error);
                }else{

                hideLoader('#edit_profit_sheet');
                var store_val = '{{$store??''}}';
                // Hide the modal body content
                $('#edit_profit_sheet .modal-body').show();
                var name = $('#name');
                var store = $('#store');
                var po_number = $('#po_number');
                var sale_price = $('#sale_price');
                var cost = $('#cost');
                var net_cost = $('#net_cost');
                var selling_fee = $('#selling_fee');
                var net_selling = $('#net_selling_fee');
                var selling_fee_reversal = $('#selling_fee_reversal');
                var shipping = $('#shipping_fee');
                var gross_price = $('#gross_price');
                var cogs = $('#cogs');


                var net_shipping_fee = $('#net_shipping_fee');
                var refund = $('#refund');
                var total_cost = $('#total_cost');
                var adjustment_fee = $('#adjustment_fee');
                var totalCost = (parseFloat(net_selling.val()) || 0) + (parseFloat(net_cost.val()) || 0) + (parseFloat(adjustment_fee.val()) || 0) + (parseFloat(net_shipping_fee.val()) || 0) + (parseFloat(refund.val()) || 0);
                console.log(totalCost);

                store.val(store_val);
                name.val(data.data.shippingName);
                sale_price.val(data.sales_price);
                net_selling.val(parseFloat(selling_fee-selling_fee_reversal)||0);
               po_number.val(data.data.poNumber);
               cost.val(data.data.orderTotal);
               net_cost.val(data.data.orderTotal);
               cogs.val(data.data.orderTotal);
               selling_fee.val(data.data.shippingTax);
               shipping.val(parseFloat(data.data.shippingCost)||0);
               total_cost.val(totalCost);
               calculateValues();

            }
        }
            });
        }

        function calculateValues() {
    var sellingFee = parseFloat($('#selling_fee').val()) || 0;
    var sellingFeeReversal = parseFloat($('#selling_fee_reversal').val()) || 0;
    var netSellingFee = sellingFee - sellingFeeReversal;

    var cost = parseFloat($('#cost').val()) || 0;
    var rtn = parseFloat($('#RTN').val()) || 0;
    var netCost = cost - rtn;

    var shippingFee = parseFloat($('#shipping_fee').val()) || 0;
    var shippingFeeReversal = parseFloat($('#shipping_fee_reversal').val()) || 0;
    var netShippingFeeCharged = shippingFee - shippingFeeReversal;

    var adjustment_fee =parseFloat($('#adjustment_fee').val())||0;
    var refund =parseFloat($('#refund').val())||0;
    // Calculate total cost
    var totalCost = netSellingFee + netCost +  adjustment_fee + netShippingFeeCharged + refund;

    var sale_price = parseFloat($('#sale_price').val()) || 0;
    var revenue_passive = sale_price - totalCost;

    var odrPercentage = (revenue_passive / sale_price) * 100;
    // Update the calculated values in the respective input fields
    $('#net_selling_fee').val(netSellingFee.toFixed(2));
    $('#net_cost').val(netCost.toFixed(2));
    $('#cogs').val(netCost.toFixed(2));
    $('#net_shipping_fee').val(netShippingFeeCharged.toFixed(2));
    $('#total_cost').val(totalCost.toFixed(2));
    $('#revenue_passive').val(revenue_passive.toFixed(2));
    $('#odr').val(odrPercentage.toFixed(2));
    // ... update other fields as needed
}

// Bind the calculateValues function to the input event of relevant input fields
$('#sale_price, #selling_fee, #selling_fee_reversal, #cost, #RTN, #shipping_fee, #shipping_fee_reversal, #adjustment_fee, #refund').on('input', function () {
    calculateValues();
});

            function detail(id){
                hideLoader('#kt_modal_detail_coupon');
                $('.error-message').html('');
                $('#order_detail_header').html('');
                 showLoader('#kt_modal_detail_coupon');
                $('#kt_modal_detail_coupon .modal-body').hide();

                 $.ajax({
            url:"{{route('get_detail')}}",
            method:"POST",
            data:{id:id},
            dataType:'json',
              headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
            success:function(data)
            {
                if(data.error != undefined){
                hideLoader('#kt_modal_detail_coupon');
                    showError(data.error);
                }else{

                hideLoader('#kt_modal_detail_coupon');
                // Hide the modal body content
                $('#kt_modal_detail_coupon .modal-body').show();
               console.log(data);
                  var data2 =  KTUsersList.getrows(data.id);
               c_data = data2;
               header = 'ID:   '+data.id+'<br>PO:  '+data.poNumber+'<br>'+data.status;

               shipto = data.shippingName+'<br>'+data.shippingAddress1+'<br>'+data.shippingAddress2+'<br>'+data.shippingCity+' ,'+data.shippingRegion+' ,'+data.shippingPostalCode+' ,'+data.shippingRegion+'<br> '+data.shippingCountry;

                var orderDate = new Date(data.orderDate);
                const formattedDate = moment(orderDate).format('DD-MM-YYYY hh:mm A');

                var orderdetail = '<strong>Created: </strong>' + formattedDate;

                var track = '';
                var tracking = '';

                // Function to process tracking numbers
                function processTrackingNumbers(items) {
                    let trackingInfo = '';
                    let uniqueTrackingNumbers = new Set();

                    for (var i = 0; i < items.length; i++) {
                        if (items[i].trackingNumbers && items[i].trackingNumbers.length > 0) {
                            for (var j = 0; j < items[i].trackingNumbers.length; j++) {
                                var trackingNumber = items[i].trackingNumbers[j].trackingNumber;
                                if (trackingNumber) {
                                    uniqueTrackingNumbers.add(trackingNumber);
                                }
                            }
                        }
                    }

                    uniqueTrackingNumbers.forEach(trackingNumber => {
                        let trackLink = '<a target="_blank" href="https://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=' + trackingNumber + '" >' + trackingNumber + '</a>';
                        trackingInfo += '<br><strong>Tracking Number: </strong>' + trackLink + '<br>';
                    });

                    return trackingInfo;
                }

                // Process tracking numbers for items
                if (data.items.length > 0) {
                    tracking += processTrackingNumbers(data.items);
                }

                var shippingMethod = '<strong>Shipping Method: </strong>' + data.shippingMethod;

                shippingdetial = shippingMethod + tracking;


               $('#order_detail_header').html(header);
               $('#shipto').html(shipto);
               $('#orderdetail').html(orderdetail);
               $('#shippingdetail').html(shippingdetial);


               $('.item_table').html('');
               for(i=0;i<data.items.length;i++){
                 $('.item_table').append('<tr><td scope="col">'+i+'</td><td scope="col">'+data.items[i].sku+'</td><td scope="col">'+data.items[i].description+'</td><td scope="col">'+data.items[i].quantity+'</td><td scope="col">'+data.items[i].weight+'</td><td scope="col">'+data.items[i].extendedPrice+'</td></tr>');
               }

               $('.shipping_detail').html('');
                if (data.invoices && data.invoices.length > 0) {
                    data.invoices.forEach(invoiceOrder => {
                   const date = new Date(invoiceOrder.orderDate);
                   const formattedDate = moment(date).format('DD-MM-YYYY');
                   $('.shipping_detail').append('<tr><td scope="col">'+invoiceOrder.erpOrderId+'</td><td scope="col">'+formattedDate+'</td><td scope="col">'+invoiceOrder.orderTotal+'</td><td></td></tr>');

               });
            }
                if (data.rmas && data.rmas.length > 0) {
                    data.rmas.forEach(rmasOrder => {
                    $('.shipping_detail').append('<tr><td scope="col">'+rmasOrder.erpOrderId+'</td><td scope="col"></td><td scope="col">'+rmasOrder.orderTotal+'</td><td></td></tr>');
                    })
                }
                if(data.replacements[0]){
                    var tracking ='';
                    if(data.replacements[0].items[0].trackingNumbers.length>0){
                        tracking = data.replacements[0].items[0].trackingNumbers[0].trackingNumber;
                    }else{
                        tracking = "Open";
                    }
                    const date = new Date(data.replacements[0].orderDate);
                    const formattedDate = moment(date).format('DD-MM-YYYY');
                    $('.shipping_detail').append('<tr><td scope="col">'+data.replacements[0].erpOrderId+'</td><td scope="col">'+formattedDate+'</td><td scope="col">'+data.replacements[0].orderTotal+'</td><td scope="col">'+tracking+'</td></tr>');
                }
                if (data.returns && data.returns.length > 0) {
                    data.returns.forEach(returnOrder => {
                        const date = new Date(returnOrder.orderDate);
                        const formattedDate = moment(date).format('DD-MM-YYYY');
                        $('.shipping_detail').append('<tr><td scope="col">' + returnOrder.erpOrderId + '</td><td scope="col">' + formattedDate + '</td><td scope="col">' + returnOrder.orderTotal + '</td><td></td></tr>');
                    });
                }


               $('#table_total').html('');

               total = data.orderTotal+data.shippingTax+data.shippingCost;

               $('#table_total').html('<tr ><td scope="col">SubTotal</td><td scope="col">'+data.orderTotal+'</td></tr><tr ><td scope="col">Discount</td><td scope="col">0.00</td></tr><tr ><td scope="col">Tax</td><td scope="col">'+data.shippingTax+'</td></tr><tr ><td scope="col">Frieght</td><td scope="col">'+data.shippingCost+'</td></tr> <tr ><td scope="col">Total</td><td scope="col">'+total+'</td></tr>');
            }
            }
                 });

            }

            function showLoader(modal) {
    var loaderHtml = '<div class="modal-loader" style="text-align: center; height: 200px;">' +
                        '<div class="spinner-border" role="status" style="text-align: center; margin-top: 50px;">' +
                            '<span class="sr-only">Loading...</span>' +
                        '</div>' +
                    '</div>';

    // Add loader HTML to the modal
    $(modal+' .modal-content').append(loaderHtml);
}

function hideLoader(modal) {
    // Remove loader HTML from the modal
    $(modal+' .modal-loader').remove();
}
        function rma(id) {
                showLoader('#trqrma');
                // Hide the modal body content
                $('#trqrma .modal-body').hide();
  $.ajax({
            url:"{{route('get_rma')}}",
            method:"POST",
            data:{id:id},
            dataType:'json',
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
            success:function(data)
            {
                hideLoader('#trqrma');
                // Hide the modal body content
                $('#trqrma .modal-body').show();

           console.log(data);
            var data2 = KTUsersList.getrows(data);
            c_data = data2;




            $('#trqrma').find('input[name=id]').val(data['id']);
            $('#trqrma').find('input[name=po]').val(data['poNumber']);
            $('#trqrma').find('input[name=uniqueId]').val(data['id']);




            $('.trqrmaitem_table').html('');
            for (i = 0; i < data['items'].length; i++) {
                $('.trqrmaitem_table').append('<tr><td scope="col"><input type="checkbox" checked name="items[]" value="' + data['items'][i]['sku'] + ',' + data['items'][i]['quantity'] + '" ></td><td scope="col">' + data['items'][i]['sku'] + '</td><td scope="col">' + data['items'][i]['description'] + '</td><td scope="col">' + data['items'][i]['quantity'] + '</td><td scope="col">' + data['items'][i]['weight'] + '</td><td scope="col">' + data['items'][i]['extendedPrice'] + '</td></tr>');
            }

            }
        });
        }

        function replacement(id) {
                showLoader('#trqreplacement');
                // Hide the modal body content
                $('#trqreplacement .modal-body').hide();
  $.ajax({
            url:"{{route('get_rma')}}",
            method:"POST",
            data:{id:id},
            dataType:'json',
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
            success:function(data)
            {
                hideLoader('#trqreplacement');
                // Hide the modal body content
                $('#trqreplacement .modal-body').show();

           console.log(data);
            var data2 = KTUsersList.getrows(data);
            c_data = data2;




            $('#trqreplacement').find('input[name=id]').val(data['id']);
            $('#trqreplacement').find('input[name=po]').val(data['poNumber']);
            $('#trqreplacement').find('input[name=uniqueId]').val(data['id']);




            $('.trqreplacementitem_table').html('');
            for (i = 0; i < data['items'].length; i++) {
                $('.trqreplacementitem_table').append('<tr><td scope="col"><input type="checkbox" checked name="items[]" value="' + data['items'][i]['sku'] + ',' + data['items'][i]['quantity'] + '" ></td><td scope="col">' + data['items'][i]['sku'] + '</td><td scope="col">' + data['items'][i]['description'] + '</td><td scope="col">' + data['items'][i]['quantity'] + '</td><td scope="col">' + data['items'][i]['weight'] + '</td><td scope="col">' + data['items'][i]['extendedPrice'] + '</td></tr>');
            }

            }
        });
        }


        var response = '';

        function submitOperation(form, operation) {
    // Set the operation value in the hidden input field
    form.querySelector('input[name="operation"]').value = operation;

    axios.post('{{ route("trqOperation") }}', new FormData(form))
        .then(function(response) {
            console.log(response);
            if (response.data.message != undefined) {
                Swal.fire({
                    text: response.data.message,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
            if (response.data.id != undefined) {
                Swal.fire({
                    text: "Operation Submitted Successfully",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                window.location.reload();
            }
        })
        .catch(function(error) {
            console.error(error);
        });
}

function submitrma(form) {
    submitOperation(form, 'rma');
}

function submitreplacement(form) {
    submitOperation(form, 'replacement');
}

function submitrefund(form) {
    submitOperation(form, 'return');
}


















        function refund(id) {
                showLoader('#trqrefund');
                $('#trqrefund .modal-body').hide();
  $.ajax({
            url:"{{route('order_refund')}}",
            method:"POST",
            data:{id:id},
            dataType:'json',
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
            success:function(data)
            {
               hideLoader('#trqrefund');
                $('#trqrefund .modal-body').show();
           console.log(data);
            var data2 = KTUsersList.getrows(data.id);
            c_data = data2;

            $('#trqrefund').find('input[name=id]').val(data.id);
            $('#trqrefund').find('input[name=po]').val(data.poNumber);
            $('#trqrefund').find('input[name=uniqueId]').val(data.id);




            $('.trqrefunditem_table').html('');
            for (i = 0; i < data['items'].length; i++) {
                $('.trqrefunditem_table').append('<tr><td scope="col"><input type="checkbox" checked name="items[]" value="' + data.items[i].sku + ',' + data.items[i].quantity + '" ></td><td scope="col">' + data.items[i].sku + '</td><td scope="col">' + data.items[i].description + '</td><td scope="col">' + data.items[i].quantity + '</td><td scope="col">' + data.items[i].weight + '</td><td scope="col">' + data.items[i].extendedPrice + '</td></tr>');
            }


            //   $('#trqrmatable_total').html('')

            // //   total = data['orderTotal']+data['shippingTax']+data['shippingCost'];

            //   $('#trqrmatable_total').html('<tr ><td scope="col">SubTotal</td><td scope="col">'+data['orderTotal']+'</td></tr><tr ><td scope="col">Discount</td><td scope="col">0.00</td></tr><tr ><td scope="col">Tax</td><td scope="col">'+data['shippingTax']+'</td></tr><tr ><td scope="col">Frieght</td><td scope="col">'+data['shippingCost']+'</td></tr> <tr ><td scope="col">Total</td><td scope="col">'+total+'</td></tr>')
            }
            });


        }

        const ship_form = document.getElementById('store_form');
const ship_submitButton = document.getElementById('store_submit');

ship_submitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (1) {


            if (1) {
                // Show loading indication
                ship_submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    ship_submitButton.disabled = true;

                    // Send ajax request
                    axios.post(ship_submitButton.closest('form').getAttribute('action'), new FormData(ship_form))
                        .then(function (response) {
                            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: response.data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                window.location.reload();
                                if (result.isConfirmed) {
                                    if (response.data.redirect) {
                                        KTUsersList.reinit();
                                       $('#store .close').click();
                                        form.reset();
                                    }
                                }
                            });
                        })
                        .catch(function (error) {
                            let dataMessage = error.response.data.message;
                            let dataErrors = error.response.data.errors;

                            for (const errorsKey in dataErrors) {
                                if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                                dataMessage += "\r\n" + dataErrors[errorsKey];
                            }

                            if (error.response) {
                                Swal.fire({
                                    text: dataMessage,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        })
                        .then(function () {
                            // always executed
                            // Hide loading indication
                            ship_submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            ship_submitButton.disabled = false;
                        });
            }

    }
});


        function cancel(id) {
             showLoader('#trqcancel');
                $('#trqcancel .modal-body').hide();
 $.ajax({
            url:"{{route('order_cancel')}}",
            method:"POST",
            data:{id:id},
            dataType:'json',
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
            success:function(data)
            {
               hideLoader('#trqcancel');
                $('#trqcancel .modal-body').show();
           console.log(data);
            var data2 = KTUsersList.getrows(data.id);
            c_data = data2;



            $('#trqcancel').find('input[name=id]').val(data.id);
            $('#trqcancel').find('input[name=po]').val(data.poNumber);


            $('.trqcancelitem_table').html('');
            for (i = 0; i < data.items.length; i++) {
                $('.trqcancelitem_table').append('<tr><td scope="col">' + i + '</td><td scope="col">' + data.items[i].sku + '</td><td scope="col">' + data.items[i].description + '</td><td scope="col">' + data.items[i].quantity + '</td><td scope="col">' + data.items[i].weight + '</td><td scope="col">' + data.items[i].extendedPrice + '</td></tr>');
            }

            }
 });
        }


        var response = '';

        function submitcancel(form) {

            console.log(form);

            axios.post('{{ route("trqcancel") }}', new FormData(form))
                .then(function(response) {
                    response = response;
                    console.log(response);
                    if (response.data.message != undefined) {
                        Swal.fire({
                            text: response.data.message
                            , icon: "error"
                            , buttonsStyling: false
                            , confirmButtonText: "Ok, got it!"
                            , customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    } else {
                        Swal.fire({
                            text: "Cancel Request Submitted Successfully"
                            , icon: "success"
                            , buttonsStyling: false
                            , confirmButtonText: "Ok, got it!"
                            , customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        window.location.reload();

                    }

                })
                .catch(function(error) {

                })
                .then(function() {

                });


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
    console.log(order);
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

        $('#kt_modal_add_csv_form').on('submit', function(event){

        event.preventDefault();
        temp=this;
        $(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
        $(this).find('button[type=submit')[0].disabled = true;

        $.ajax({
            url:"{{route('orderupload-csv')}}",
            method:"POST",
            data:new FormData(this),
            dataType:'json',
            contentType:false,
            cache:false,
            processData:false,
            success:function(data)
            {
                $(temp).find('button[type=submit')[0].removeAttribute('data-kt-indicator');
                $(temp).find('button[type=submit')[0].disabled = false;
                  $('#csv_file').modal('toggle');
                $('#csv_table').modal('toggle');
           console.log(data);
           var fields = '<option value="-1" >Leave Blank</option>';


           for(var i=0;i < data.data.fields.length ;i++){
              fields += '<option value="'+i+'" >'+data.data.fields[i]+'</option>';
           }
           $('#csv_table').find('input[name=file_name]').val(data.data.file_name);
           $('#csv_table').find('select').html(fields);

            }
        });

        });






         $('#csv_table_form').on('submit', function(event){

        event.preventDefault();
        temp=this;
        $(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
        $(this).find('button[type=submit')[0].disabled = true;



        // $.ajax({
        //     url:"{{route('orderinsert-csv')}}",
        //     method:"POST",
        //     data:new FormData(this),
        //     dataType:'json',
        //     contentType:false,
        //     cache:false,
        //     processData:false,
        //     success:function(data)
        //     {

        //         response = data;

        //          $(temp).hide();

        //          $(".progress-div")[0].classList.remove('d-none');


        //             total_orders = data.data.length;
        //             orders_data  = data.data;
        //             order_num    = 0;

        //          punch_order(orders_data[order_num]);


        //     }
        // });


        axios.post("{{route('orderinsert-csv')}}",new FormData(this)).then((data) => {

                 response = data;
                 $(temp).hide();
                 $(".progress-div")[0].classList.remove('d-none');
                total_orders = data.data.data.length;
                orders_data  = data.data.data;
                console.log(data);
                order_num    = 0;
                 punch_order(orders_data[order_num]);

        }).catch((err) => {
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

        }).then(()=>{})











        // $.ajax({
        //     url:"{{route('orderinsert-csv')}}",
        //     method:"POST",
        //     data:new FormData(this),
        //     dataType:'json',
        //     contentType:false,
        //     cache:false,
        //     processData:false,
        //     success:function(data)
        //     {


        // $(temp).find('button[type=submit')[0].removeAttribute('data-kt-indicator');
        // $(temp).find('button[type=submit')[0].disabled = false;


        //   Swal.fire({
        //                         text: data.message,
        //                         icon: "success",
        //                         buttonsStyling: false,
        //                         confirmButtonText: "Ok, got it!",
        //                         customClass: {
        //                             confirmButton: "btn btn-primary"
        //                         }
        //                     }).then(function (result) {
        //                         window.location.reload();

        //                     });
        //     }
        // });







        });










          $('#kt_modal_add_new_order_form').on('submit', function(event){

        event.preventDefault();
        temp=this;
        $(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
        $(this).find('button[type=submit')[0].disabled = true;






        axios.post('{{ route('order.insertsingleorder') }}',new FormData(this)).then(function (data){


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
                                // window.location.reload();

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


        </script>






    @endsection


</x-base-layout>
