<x-base-layout>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="d-flex justify-content-start buttonGroupWrap">

                <div class="btn-group" role="group" aria-label="Large button group">
                    <button type="button" id="new_setup" data-toggle="modal" data-target="#m_modal_5" class="m-btn btn btn-outline-primary border">Inventory Approval</button>
                    <button type="button" id="setup" data-toggle="modal" data-target="#m_modal_5" class="m-btn btn btn-outline-primary border active">Inventory</button>
                    <button type="button" id="history" data-toggle="modal" data-target="#m_modal_5" class="m-btn btn btn-outline-primary border">Orders</button>
                    <button type="button" id="returns_approval" data-toggle="modal" data-target="#m_modal_5" class="m-btn btn btn-outline-primary border">Returns Approval</button>
                </div>

            </div>
        </div>
    </div>
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session('title') }}',
            text: '{{ session('success') }}'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '{{ session('title') }}',
            text: '{{ session('success') }}'
        });
    </script>
@endif

    <div class="card ">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {{ $warehouse_name }}
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->

                    <!--end::Svg Icon-->

                </div>
                <!--end::Search-->
            </div>


            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar gap-1">

                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">



                    {{ theme()->getView('pages/warehouse/add_csv',['users'=>$users]) }}


                    <!--begin::Filter-->
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Filter
                    </button>
                    <!--begin::Menu 1-->
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
                                <select id="status" class="form-select form-select-solid fw-bolder" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
                                    <option></option>
                                    <option value="1">Stocked In</option>
                                    <option value="2">Stocked Out</option>
                                    <option value="4">Low quantity</option>

                                </select>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-bold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                <button type="submit" class="btn btn-primary fw-bold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Filter-->

                    {{-- {{ theme()->getView('pages/warehouse/pf_warehouse_add',['users'=>$users,'warehouse' =>$warehouse]) }} --}}
                    {{ theme()->getView('pages/warehouse/pf_warehouse_edit',['users'=>$users,'warehouse' =>$warehouse]) }}
                    {{ theme()->getView('pages/warehouse/pf_warehouse_return',['users'=>$users,'warehouse' =>$warehouse]) }}
                    {{ theme()->getView('pages/warehouse/pf_warehouse_ship',['users'=>$users,'warehouse' =>$warehouse]) }}
                    {{ theme()->getView('pages/warehouse/pf_warehouse_reOrder',['users'=>$users,'warehouse' =>$warehouse]) }}




                    <!--begin::Export-->
                    <button type="button" class="btn btn-light-primary me-3" style="display: none;" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="black" />
                                <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="black" />
                                <path d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#C4C4C4" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Export
                    </button>
                    <!--end::Export-->
                    <!--begin::Add user-->


                    <!--end::Add user-->


                    <!-- Modal -->
                    <div class="modal fade" id="ImageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div id="mediaContainer" style="text-align: center"></div>
                                    <a id="downloadButton" href="#" class="btn btn-primary" style="display: none;">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Toolbar-->

                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bolder me-5"><span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
                    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                    <button type="button" class="btn btn-primary" data-kt-user-table-select="ship_selected">Ship Selected</button>
                    <button type="button" class="btn btn-primary" data-kt-user-table-select="return_selected">Return Selected</button>
                </div>

                <button type="button" class="btn btn-primary" id="download_report">Download CSV</button>

            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">

        <div class="bg-light rounded p-3 mb-4 mt-4 border border-secondary">
            <div class="row gx-2">
                @foreach($statusCounts as $statusCount)
                <div class="col-md-3 col-sm-6 col-6">
                    <label class="fw-bold">{{ $statusCount['status'] }}</label>
                    <h5 class="m-0 p-3 bg-opacity-50 status-count
                        @if($statusCount['status'] =='Stocked out') bg-danger
                        @elseif ($statusCount['status'] =='Low quantity') bg-warning
                        @else bg-success
                        @endif
                        rounded mb-1 border">
                        {{ $statusCount['count'] ?? 0 }}
                        </h5>
                </div>
                @endforeach
                <div class="col-md-3 col-sm-6 col-6">
                    <label class="fw-bold">Total Cost</label>
                    <h5 class="m-0 p-3 bg-secondary rounded mb-1 border">{{ $net_price ?? 0 }}</h5>
                </div>
            </div>
        </div>


            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_coupons">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_coupons .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-125px text-dark " style="align:center">ACTION</th>
                            {{-- <th class="min-w-50px text-dark " >ID</th> --}}
                            {{-- <th class="min-w-125px text-dark ">Market Place</th> --}}
                            <th class="min-w-100px text-dark ">ASIN/Item ID</th>
                            <th class="min-w-100px text-dark ">Part Number</th>
                            <th class="min-w-100px text-dark ">Part Picture</th>
                            <th class="min-w-100px text-dark ">Title</th>
                            <th class="min-w-100px text-dark">Cost per unit</th>
                            <th class="min-w-100px text-dark">Total Cost</th>
                            {{-- <th class="min-w-100px text-dark ">Average Price</th> --}}
                            <th class="min-w-100px text-dark ">Status</th>
                            <th class="min-w-100px text-dark ">Monthly Orders</th>
                            <th class="min-w-100px text-dark ">All Orders</th>
                            <th class="min-w-100px text-dark ">Inventory count</th>



                            <!--<th class="min-w-125px">CREATED AT</th>-->


                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->

                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
        </div>
        <!--end::Card body-->
    </div>


    @section('scripts')


    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="preload" href="/demo6/plugins/custom/datatables/datatables.bundle.css" as="style" onload="this.onload=null;this.rel='stylesheet'" type="text/css"><noscript>
        <link rel="stylesheet" href="https://autooutletllc.com/miniapp/public/demo6/plugins/custom/datatables/datatables.bundle.css"></noscript>

    <script src="/demo6/js/custom/widgets.js"></script>
    <script src="/demo6/plugins/custom/datatables/datatables.bundle.js"></script>


    <script id="usertable">
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
                        url: "<?= route('pf_warehouse.datatableapi') ?>"
                        , data: {
                            found: 1,
                            name : "{{$warehouse_name}}",
                            status: document.getElementById('status').value,



                        }
                        , type: 'POST'
                        , headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    , },

                    processing: true
                    , serverSide: true
                    , info: false
                    , order: []
                    , retrieve: true
                    , paging: true
                    , lengthMenu: [10, 50, 60, 80, 100, 500]
                    , pageLength: 100
                    , lengthChange: true
                    , columns: [

                        {
                            data: 'checkbox'
                            , name: 'checkbox'
                            , orderable: false
                            , searchable: false
                        }
                        , {
                            data: 'action'
                            , name: 'action'
                            , orderable: false
                            , searchable: false
                        },

                        {
                            data: 'ASINItem_ID'
                            , name: 'ASINItem_ID'
                            , orderable: true,

                        }
                        , {
                            data: 'Part'
                            , name: 'Part'
                            , orderable: true,

                        }
                        , {
                            data: 'Picture'
                            , name: 'Picture'
                            , orderable: false
                            , searchable: false
                            , render: function(data, type, row) {
                                var image = data.split(',');
                                return '<img class="img-click" src="' + image[0] + '" style="border-radius: 10px; border: solid 1px #ddd; width: 80px; height: 80px; padding: 4px;" onclick="openModal(\'' + image + '\', \'image\');">';
                            }
                        },
                        {
                            data: 'Title',
                            name: 'Title',
                            orderable: false,
                            render: function (data, type, row) {
                                function decodeHtmlEntities(str) {
                                    var txt = document.createElement("textarea");
                                    txt.innerHTML = str;
                                    return txt.value;
                                }

                                // Decode HTML entities recursively if needed
                                function recursiveDecode(str) {
                                    var decoded = decodeHtmlEntities(str);
                                    while (decoded !== str) {
                                        str = decoded;
                                        decoded = decodeHtmlEntities(str);
                                    }
                                    return decoded;
                                }

                                // Decode the data
                                var decodedData = recursiveDecode(data);

                                // Ensure the text is left-aligned
                                return '<div style="font-size: 12px; text-align: left;">' + decodedData + '</div>';
                            },
                            createdCell: function (td) {
                                $(td).addClass('text-center');
                            }
                        },


                        {
                            data: 'price_per_unit'
                            , name: 'price_per_unit'
                            , orderable: true,
                            createdCell: function (td) {
                                $(td).addClass('text-center');
                            }

                        },
                        {
                            data: 'price'
                            , name: 'price'
                            , orderable: true,
                            createdCell: function (td) {
                                    $(td).addClass('text-center');
                                }

                        },
                        // {
                        //     data: 'average'
                        //     , name: 'average'
                        //     , orderable: true,
                        //     createdCell: function (td) {
                        //         $(td).addClass('text-center');
                        //     }

                        // },
                        {
                            data: 'status'
                            , name: 'status'
                            , orderable: true,
                            createdCell: function (td) {
                                $(td).addClass('text-center');
                            }

                        },
                        {
                            data: 'monthly_order'
                            , name: 'monthly_order'
                            , orderable: true,
                            createdCell: function (td) {
                                $(td).addClass('text-center');
                            }

                        },
                        {
                            data: 'all_orders'
                            , name: 'all_orders'
                            , orderable: true,
                            createdCell: function (td) {
                                $(td).addClass('text-center');
                            }

                        },

                            {
                            data: 'Inventory_count',
                            name: 'Inventory_count',
                            orderable: true,
                            createdCell: function (td) {
                                $(td).addClass('text-center');
                            }

                        },

                        //    {
                        //     data: 'outOrder_ID',
                        //     name: 'outOrder_ID',
                        //     orderable: true,

                        // },






                    ]
                    , columnDefs: [{
                            orderable: false
                            , targets: 0
                        }, // Disable ordering on column 0 (checkbox)
                        {
                            orderable: false
                            , targets: 1
                        } // Disable ordering on column 6 (actions)

                    ],
                    headerCallback: function(thead, data, start, end, display) {
                            $(thead).find('th').addClass('text-center');
                        }
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
            // var handleSearchDatatable = () => {
            //     const filterSearch = document.querySelector(
            //         '[data-kt-user-table-filter="search"]'
            //     )
            //     filterSearch.addEventListener('keyup', function(e) {
            //         datatable.search(e.target.value).draw()
            //     })
            // }

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
                    // console.log(document.getElementById('role_filter').value);
                    // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                    // datatable.search(filterString).draw()
                    initUserTable();
                    // datatable.setAttribute( 'query', 2 );
                    // datatable.draw()
                })
            }

            // Reset Filter
            var handleResetForm = () => {
                    const resetButton = document.querySelector(
                        '[data-kt-user-table-filter="reset"]'
                    )
                    resetButton.addEventListener('click', function() {
                        const filterForm = document.querySelector(
                            '[data-kt-user-table-filter="form"]'
                        )
                        const selectOptions = filterForm.querySelectorAll('select')
                        selectOptions.forEach(select => {
                            $(select)
                                .val('')
                                .trigger('change')
                        })

                        datatable.destroy();
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
                            text: 'Are you sure you want to delete ' + userName + '?'
                            , icon: 'warning'
                            , showCancelButton: true
                            , buttonsStyling: false
                            , confirmButtonText: 'Yes, delete!'
                            , cancelButtonText: 'No, cancel'
                            , customClass: {
                                confirmButton: 'btn fw-bold btn-danger'
                                , cancelButton: 'btn fw-bold btn-active-light-primary'
                            }
                        }).then(function(result) {

                            if (result.value) {
                                Swal.fire({
                                        text: 'You have deleted ' + userName + '!.'
                                        , icon: 'success'
                                        , buttonsStyling: false
                                        , confirmButtonText: 'Ok, got it!'
                                        , customClass: {
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
                                            url: "<?= route('pf_warehouse.delete') ?>"
                                            , type: 'POST'
                                            , data: {
                                                "list": id
                                                , "_token": token
                                            , }
                                            , success: function() {
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
                                    text: customerName + ' was not deleted.'
                                    , icon: 'error'
                                    , buttonsStyling: false
                                    , confirmButtonText: 'Ok, got it!'
                                    , customClass: {
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
                const shipSelected = document.querySelector(
                    '[data-kt-user-table-select="ship_selected"]'
                )
                const returnSelected = document.querySelector(
                    '[data-kt-user-table-select="return_selected"]'
                )
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
            // Remove the loader HTML from the modal
            $(modal+' .modal-loader').remove();
        }

        function openBulkShipModal() {

            var  selectIds = getselected();


                // Make AJAX request
                $.ajax({
                    url: "{{ route('inventory.get_parts_data') }}",
                    type: 'POST',
                    data: {
                        ids : selectIds
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        // Hide loader after successful AJAX request
                        const modalHTML = `<div class="modal fade bulk_ship2" id="bulk_ship2" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_bulk_ship_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bolder">Bulk Ship</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                            data-bs-target="#bulk_ship2">
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
                                        <form id="bulk_ship_form" action="{{ route('inventory.bulk_ship') }}" enctype="multipart/form-data"
                                            class="form bulk_ship_form" method="post">
                                            <!--begin::Scroll-->
                                            @csrf
                                            <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                                id="kt_modal_bulk_ship_scroll" data-kt-scroll="true"
                                                data-kt-scroll-activate="{default: false, lg: true}"
                                                data-kt-scroll-max-height="auto"
                                                data-kt-scroll-dependencies="#kt_modal_add_credits_header"
                                                data-kt-scroll-wrappers="#kt_modal_bulk_ship_scroll"
                                                data-kt-scroll-offset="300px">
                                                <input type="hidden" name="warehouse_name" class="warehouse_name" value='`+"{{$warehouse_name}}"+`'>
                                                <div class="fv-row mb-7">
                                                    <label class="required fw-bold fs-6 mb-2">Order ID</label>
                                                    <input required type="text" name="order_id" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Order ID" accept="application/pdf, application/doc, application/docx" />
                                                </div>

                                                <div class="fv-row mb-7">
                                                    <label class="required fw-bold fs-6 mb-2">Ship by date</label>
                                                    <input required type="date" name="ship_by_date" id="bulk_ship_by_date" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Select date" >
                                                </div>

                                                <div class="fv-row mb-7">
                                                    <label class="required fw-bold fs-6 mb-2">Label price</label>
                                                    <input required
                                                            type="text"
                                                            name="label_price"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Enter price"
                                                            oninput="formatDecimal(this)"
                                                            onkeydown="handleBackspace(event, this)"
                                                    />
                                                </div>

                                                <div class="user-image mb-3 text-center" style="border: 1px solid #d1d1d1;border-radius: 3px;">
                                                    <div class="imgPreview row" style="padding: 8px;"> </div>
                                                </div>
                                                <div class="fv-row mb-7">
                                                    <label class="required fw-bold fs-6 mb-2">Label</label>
                                                    <input  type="file" name="label[]" onchange="multiImgPreview(this, 'div.imgPreview')"  multiple class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Label" accept="image/*" required />
                                                </div>

                                                <div class="fv-row mb-7">
                                                    <label class="required fw-bold fs-6 mb-2">Tracking ID</label>
                                                    <input required type="text" name="tracking" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Tracking_ID"  />
                                                    </div>

                                                <div id ="dynamic_inputs">

                                                    </div>




                                                <style>
                                                    .imgPreview img {
                                                        height: 100px;
                                                        width: 100px;
                                                        margin: 5px;
                                                    }
                                                    .dynamic-inputs {
                                                        margin-bottom: 20px;
                                                        padding: 10px;
                                                        border: 1px solid #ccc;
                                                        border-radius: 5px;
                                                    }

                                                    .dynamic-part-number,
                                                    .dynamic-quantity-to-ship {
                                                        width: 100%;
                                                        padding: 10px;
                                                        border: 1px solid #ccc;
                                                        border-radius: 5px;
                                                        margin-top: 5px;
                                                    }

                                                    .dynamic-part-number:focus,
                                                    .dynamic-quantity-to-ship:focus {
                                                        outline: none;
                                                        border-color: blue;
                                                    }

                                                </style>



                                            </div>
                                            <!--end::Scroll-->
                                            <!--begin::Actions-->
                                            <div class="text-center pt-15">
                                                <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                                            data-bs-target="#csv_file_button">Discard</button>
                                                <button type="submit" class="btn btn-primary bulk_ship_submit" id="bulk_ship_submit"
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

                            `;

                        $('#dynamic_inputs').empty();

                            // Iterate over each part in the response
                            response.forEach(function(part, index) {
                                // Create dynamic input fields for each part
                                var partHtml = `
                                    <div class="dynamic-inputs">
                                        <div class="fv-row mb-7">
                                            <label class="required fw-bold fs-6 mb-2">Part Number ${index + 1}</label>
                                            <input required type="text" name="part[${index + 1}]" class="form-control form-control-solid mb-3 mb-lg-0 dynamic-part-number" value="${part.part}" placeholder="Enter Part Number"  />
                                        </div>
                                        <div class="fv-row mb-7">
                                            <label class="required fw-bold fs-6 mb-2">Quantity to ship ${index + 1}</label>
                                            <input required type="text" name="inventory[${index + 1}]" class="form-control form-control-solid mb-3 mb-lg-0 dynamic-quantity-to-ship" value="" placeholder="Enter quantity" min="1" step="1"  />
                                        </div>
                                    </div>
                                `;

                                // Append the dynamic input fields for the current part
                                $('#dynamic_inputs').append(partHtml);
                            });

                        document.body.insertAdjacentHTML('beforeend', modalHTML);

                        // Trigger the modal
                        const bulkShipModal = new bootstrap.Modal(document.getElementById('bulk_ship2'));
                        bulkShipModal.show();

                        // Remove modal and backdrop on hide
                        bulkShipModal._element.addEventListener('hide.bs.modal', function() {
                            // Remove the modal element
                            this.remove();
                            // Remove the backdrop
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) {
                                backdrop.remove();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Hide loader if there's an error
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
                }

        function openBulkReturnModal() {

            var  selectIds = getselected();


                // Make AJAX request
                $.ajax({
                    url: "{{ route('inventory.get_parts_data') }}",
                    type: 'POST',
                    data: {
                        ids : selectIds
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        // Hide loader after successful AJAX request
                        const modalHTML = `<div class="modal fade bulk_return" id="bulk_return" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_bulk_ship_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bolder">Bulk Return</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                            data-bs-target="#bulk_return">
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
                                        <form id="bulk_ship_form" action="{{ route('return.bulk_ship') }}" enctype="multipart/form-data"
                                            class="form bulk_ship_form" method="post">
                                            <!--begin::Scroll-->
                                            @csrf
                                            <input type="hidden" name="warehouse_name" class="warehouse_name" value='`+"{{$warehouse_name}}"+`'>
                                            <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                                id="kt_modal_bulk_ship_scroll" data-kt-scroll="true"
                                                data-kt-scroll-activate="{default: false, lg: true}"
                                                data-kt-scroll-max-height="auto"
                                                data-kt-scroll-dependencies="#kt_modal_add_credits_header"
                                                data-kt-scroll-wrappers="#kt_modal_bulk_ship_scroll"
                                                data-kt-scroll-offset="300px">

                                                <div class="fv-row mb-7">
                                                    <label class="required fw-bold fs-6 mb-2">Order ID</label>
                                                    <input required type="text" name="order_id" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Order ID" accept="application/pdf, application/doc, application/docx" />
                                                </div>

                                                <div class="fv-row mb-7">
                                                    <label class="required fw-bold fs-6 mb-2">Tracking ID</label>
                                                    <input required type="text" name="tracking" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Tracking_ID"  />
                                                    </div>

                                                     <div class="fv-row mb-7">
                                                            <label class=" fw-bold fs-6 mb-2">Price Per Unit</label>
                                                            <input type="text" name="purchase_price"
                                                            oninput="formatDecimal(this)"
                                                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Price"  />
                                                        </div>

                                                        <div class="fv-row mb-7">
                                                            <label class="form-label fs-6 fw-bold">Reason</label>
                                                            <select name="reason"   class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                                                data-placeholder="Select option" data-allow-clear="true"
                                                                data-kt-user-table-filter="role" data-hide-search="true">
                                                                <option></option>
                                                                <option value="Item defective or doesn’t work" selected>Item defective or doesn’t work</option>
                                                                <option value="Incompatible or not useful" >Incompatible or not useful</option>
                                                                <option value="Missing parts or accessories" >Missing parts or accessories</option>
                                                                <option value="Performance or quality not adequate" >Performance or quality not adequate</option>
                                                                <option value="Wrong item was sent" >Wrong item was sent</option>
                                                                <option value="Product damaged, but shipping box OK" >Product damaged, but shipping box OK</option>
                                                                <option value="No longer needed" >No longer needed</option>
                                                                <option value="Others" >Others</option>
                                                            </select>
                                                        </div>

                                                <div id ="dynamic_input">

                                                    </div>




                                                <style>
                                                    .imgPreview img {
                                                        height: 100px;
                                                        width: 100px;
                                                        margin: 5px;
                                                    }
                                                    .dynamic-inputs {
                                                        margin-bottom: 20px;
                                                        padding: 10px;
                                                        border: 1px solid #ccc;
                                                        border-radius: 5px;
                                                    }

                                                    .dynamic-part-number,
                                                    .dynamic-quantity-to-ship {
                                                        width: 100%;
                                                        padding: 10px;
                                                        border: 1px solid #ccc;
                                                        border-radius: 5px;
                                                        margin-top: 5px;
                                                    }

                                                    .dynamic-part-number:focus,
                                                    .dynamic-quantity-to-ship:focus {
                                                        outline: none;
                                                        border-color: blue;
                                                    }

                                                </style>



                                            </div>
                                            <!--end::Scroll-->
                                            <!--begin::Actions-->
                                            <div class="text-center pt-15">
                                                <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                                            data-bs-target="#csv_file_button">Discard</button>
                                                <button type="submit" class="btn btn-primary bulk_ship_submit" id="bulk_ship_submit"
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

                            `;

                        $('#dynamic_input').empty();

                            // Iterate over each part in the response
                            response.forEach(function(part, index) {
                                // Create dynamic input fields for each part
                                var partHtml = `
                                    <div class="dynamic-inputs">
                                        <div class="fv-row mb-7">
                                            <label class="required fw-bold fs-6 mb-2">Part Number ${index + 1}</label>
                                            <input required type="text" name="part[${index + 1}]" class="form-control form-control-solid mb-3 mb-lg-0 dynamic-part-number" value="${part.part}" placeholder="Enter Part Number"  />
                                        </div>
                                        <input type="hidden" name="row_id[${index + 1}]" value="${part.id}">
                                        <div class="fv-row mb-7">
                                            <label class="required fw-bold fs-6 mb-2">Quantity to ship ${index + 1}</label>
                                            <input required type="text" name="inventory[${index + 1}]" class="form-control form-control-solid mb-3 mb-lg-0 dynamic-quantity-to-ship" value="" placeholder="Enter quantity" min="1" step="1"  />
                                        </div>
                                    </div>
                                `;

                                // Append the dynamic input fields for the current part
                                $('#dynamic_input').append(partHtml);
                            });

                        document.body.insertAdjacentHTML('beforeend', modalHTML);

                        // Trigger the modal
                        const bulkShipModal = new bootstrap.Modal(document.getElementById('bulk_return'));
                        bulkShipModal.show();

                        // Remove modal and backdrop on hide
                        bulkShipModal._element.addEventListener('hide.bs.modal', function() {
                            // Remove the modal element
                            this.remove();
                            // Remove the backdrop
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) {
                                backdrop.remove();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Hide loader if there's an error
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
                }

                // Event listener for shipSelected button
                shipSelected.addEventListener('click', function() {
                    // Open the bulk_ship modal
                    openBulkShipModal();
                });

                returnSelected.addEventListener('click', function() {
                    // Open the bulk_ship modal
                    openBulkReturnModal();
                });

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
                        text: 'Are you sure you want to delete selected ?'
                        , icon: 'warning'
                        , showCancelButton: true
                        , buttonsStyling: false
                        , confirmButtonText: 'Yes, delete!'
                        , cancelButtonText: 'No, cancel'
                        , customClass: {
                            confirmButton: 'btn fw-bold btn-danger'
                            , cancelButton: 'btn fw-bold btn-active-light-primary'
                        }
                    }).then(function(result) {
                        if (result.value) {
                            Swal.fire({
                                    text: 'You have deleted all selected !.'
                                    , icon: 'success'
                                    , buttonsStyling: false
                                    , confirmButtonText: 'Ok, got it!'
                                    , customClass: {
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
                                        url: "<?= route('pf_warehouse.delete') ?>"
                                        , type: 'POST'
                                        , data: {
                                            "list": selectedval
                                            , "_token": token
                                        , }
                                        , success: function() {
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
                                text: 'Selected inventory was not deleted.'
                                , icon: 'error'
                                , buttonsStyling: false
                                , confirmButtonText: 'Ok, got it!'
                                , customClass: {
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
                    // handleSearchDatatable()
                    handleResetForm()
                    handleDeleteRows()
                    handleFilterDatatable()
                }
                , reinit: function() {
                    datatable.destroy();
                    initUserTable();
                    data = datatable;
                }
                , getrows: function(id) {
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
        function decodeHtmlEntities(str) {
    var txt = document.createElement("textarea");
    txt.innerHTML = str;
    return txt.value;
}

$('#kt_modal_add_csv_form').on('submit', function(event){

event.preventDefault();
temp=this;
$(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
$(this).find('button[type=submit')[0].disabled = true;

$.ajax({
    url:"{{route('pf.upload-csv')}}",
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
        $('#csv_table').modal('toggle');
  console.log(data);
  var fields = '<option value="-1" >Leave Blank</option>';

   fields = '';
  for(var i=0;i < data.data.fields.length ;i++){
      fields += '<option value="'+i+'" >'+data.data.fields[i]+'</option>';
  }
  $('#csv_table').find('input[name=file_name]').val(data.data.file_name);
  $('#csv_table').find('.csv_fields').html(fields);

    }
});

});


$('#csv_table_form').on('submit', function(event){

event.preventDefault();
temp=this;
$(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
$(this).find('button[type=submit')[0].disabled = true;

$.ajax({
    url:"{{route('pf_warehouse.insert-csv')}}",
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
document.type = data.type;
console.log(document.type);
   Swal.fire({
                        text: data.message,
                         icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function (result) {
                            window.location.reload();
                    });
    }
});

});
        function edit(id) {
            data = KTUsersList.getrows(id);
            $('#inventory_id').val(id);
            var asset_path = "{{ asset('warehousedataimage') }}";
            var image_route = "{{ asset('warehousedataimage') }}";

            $('#kt_modal_edit_coupon_form').find('input[name=status]').val(data['status']);
            // $('#kt_modal_edit_coupon_form').find('input[name=tracking]').val(data['tracking']);
            $('#kt_modal_edit_coupon_form').find('input[name=inventory_count]').val(data['inventory_count']);
            $('#kt_modal_edit_coupon_form').find('input[name=part]').val(data['part']);
            $('#kt_modal_edit_coupon_form').find('input[name=asin]').val(data['asin']);
            $('#kt_modal_edit_coupon_form').find('input[name=title]').val(decodeHtmlEntities(data['title']));
            $('#kt_modal_edit_coupon_form').find('input[name=price]').val(data['price_per_unit']);


            // Clear existing image previews
            $('#kt_modal_edit_coupon_form').find('.imgPreview').html('');

            // Populate image previews with fetched images
            if (data['picture'] !== null) {
                var images = data['picture'].split(',');
                for (var i = 0; i < images.length; i++) {
                    var imageUrl = image_route + '/' + images[i].trim();
                    var imgElement = $('<img>').attr('src', imageUrl);
                    var deleteButton = $('<button>').attr({
                        'type': 'button'
                        , 'aria-label': 'Remove file'
                        , 'title': 'Remove file'
                        , 'style': 'border: none;background: transparent;position: absolute;'
                        , 'onclick': 'del_image_api(this,' + data['id'] + ')'
                    }).html('<svg aria-hidden="true" focusable="false" class="UppyIcon" width="18" height="18" viewBox="0 0 18 18"><path d="M9 0C4.034 0 0 4.034 0 9s4.034 9 9 9 9-4.034 9-9-4.034-9-9-9z"></path><path fill="#FFF" d="M13 12.222l-.778.778L9 9.778 5.778 13 5 12.222 8.222 9 5 5.778 5.778 5 9 8.222 12.222 5l.778.778L9.778 9z"></path></svg>');
                    var columnDiv = $('<div>').addClass('col').append(imgElement, deleteButton);
                    $('#kt_modal_edit_coupon_form').find('.imgPreview').append(columnDiv);
                }
            }

            // Set form action URL

            var url = $('#kt_modal_edit_coupon_form').attr('dt-action');
            $('#kt_modal_edit_coupon_form').attr('action', url);
        }
        $(document).ready(function() {
            var warehouse_name = "{{$warehouse_name}}";
            $('.warehouse_name').val(warehouse_name);
            $('#download_report').on('click', function() {
                    var link = document.createElement('a');
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.href = "{{ route('download.orders.report', ['warehouse' => $warehouse_name]) }}";
                    // link.href = "<?= route('download.orders.report') ?>";

                    link.click();
            });

            function restrictToInteger(inputField) {
                var inputVal = $(inputField).val();
                if (isNaN(inputVal) || inputVal.indexOf('.') !== -1) {
                    // Not a valid integer or contains a decimal point
                    // Remove the last entered character
                    $(inputField).val(function(i, v) {
                        return v.slice(0, -1);
                    });
                }
            }

            // Bind the function to the input event for each input field
            $('input[name="inventory"], input[name="inventory_count"]').on('input', function() {
                restrictToInteger(this);
            });

                            // Attach event listener to the button


        });



        var inventory = document.getElementById('new_setup');
        var inventoryButton = document.getElementById('setup');
        var ordersButton = document.getElementById('history');
        var returns = document.getElementById('returns_approval');

        // Add click event listeners to the buttons
        inventory.addEventListener('click', function() {
            // Add the 'active' class to the inventory button
            inventory.classList.add('active');
            // Remove the 'active' class from the orders button
            ordersButton.classList.remove('active');
            inventoryButton.classList.remove('active');
            returns.classList.remove('active');

            // Redirect to the inventory route
            window.location.href = "{{ url('warehouse/inventory/' . $warehouse_name) }}";

        });
        inventoryButton.addEventListener('click', function() {
            // Add the 'active' class to the inventory button
            inventoryButton.classList.add('active');
            // Remove the 'active' class from the orders button
            ordersButton.classList.remove('active');
            inventory.classList.remove('active');
            returns.classList.remove('active');

            // Redirect to the inventory route
            window.location.href = "{{ url('/' . $warehouse_name) }}";
        });

        ordersButton.addEventListener('click', function() {
            // Add the 'active' class to the orders button
            ordersButton.classList.add('active');
            // Remove the 'active' class from the inventory button
            inventoryButton.classList.remove('active');
            inventory.classList.remove('active');
            returns.classList.remove('active');

            // Redirect to the orders route
            // Replace the URL with the actual route for orders
            window.location.href = "{{ url('/warehouse/orders/' . $warehouse_name) }}";
        });

        returns.addEventListener('click', function() {
            // Add the 'active' class to the orders button
            returns.classList.add('active');
            // Remove the 'active' class from the inventory button
            ordersButton.classList.remove('active');
            inventoryButton.classList.remove('active');
            inventory.classList.remove('active');
            window.location.href = "{{ url('/warehouse/returns/' . $warehouse_name) }}";
        });

        function openModal(url, type) {
            var mediaContainer = document.getElementById('mediaContainer');
            mediaContainer.innerHTML = ''; // Clear any existing content

            var downloadButton = document.getElementById('downloadButton');
            downloadButton.setAttribute('href', url); // Set the download link to the provided URL

            if (type === 'image') {
                var imageUrls = url.split(','); // Split the comma-separated URLs into an array
                imageUrls.forEach(function(imageUrl, index) {
                    var imageElement = document.createElement('img');
                    // Check if the imageUrl starts with "http" or "https"
                    if (imageUrl.startsWith('http')) {
                        imageElement.src = imageUrl;
                    } else {
                        imageElement.src = 'warehousedataimage/' + imageUrl;
                    }
                    imageElement.style.maxWidth = '100%';
                    imageElement.style.maxHeight = '450px';
                    imageElement.style.textAlign = 'center';
                    imageElement.style.margin = '2px';

                    // Append index to imageElement to identify first image
                    imageElement.setAttribute('data-index', index);

                    mediaContainer.appendChild(imageElement);
                });

                downloadButton.style.display = 'none'; // Hide the download button for images
            }

            $('#ImageModal').modal('show');
        }




        $(function() {
            var dateToday = new Date();

            // Format the date as yyyy-mm-dd
            var dateString = dateToday.getFullYear() + '-' + ('0' + (dateToday.getMonth() + 1)).slice(-2) + '-' + ('0' + dateToday.getDate()).slice(-2);

            // Set the default date to the current date
            $('#ship_by_date').attr('value', dateString);

            // Initialize the datepicker
            $('#ship_by_date').datepicker({
                format: 'yyyy-mm-dd'
                , autoclose: true
                , weekStart: 1
            });

        });



        function ship(id) {
            var data = KTUsersList.getrows(id);


            var asset_path = "{{ asset('public/warehousedataimage') }}";

            var currentDate = new Date().toISOString().split('T')[0];

            // Set ship_by_date input field value to current date
            $('#ship_form').find('input[name=ship_by_date]').val(currentDate);

            //   $('#ship_form').find('input[name=tracking]').val(data['Tracking']);
            $('#ship_form').find('input[name=order_id]').val(data['order_id']);
            $('#ship_form').find('input[name=ship_by_date]').val(data['ship_by_date']);
            $('#ship_form').find('input[name=part]').val(data['Part']);
            $('#ship_form').find('input[name=asin]').val(data['ASINItem_ID']);

            $('#ship_form').find('#outlabel').html('');


            $('#ship_form').attr('action');
        }

        function return_item(id) {
            var data = KTUsersList.getrows(id);
              $('#return_form').find('input[name=row_id]').val(id);

            $('#return_form').attr('action');
        }

        function reOrder(id) {
            var data = KTUsersList.getrows(id);
              $('#reOrder_form').find('input[name=row_id]').val(id);

            $('#reOrder_form').attr('action');
        }

        // Define form element
        const update_form = document.getElementById('kt_modal_edit_coupon_form');

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/


        // Submit button handler
        const update_submitButton = document.getElementById('kt_docs_updte_formvalidation_text_submit');
        update_submitButton.addEventListener('click', function(e) {
            // Prevent default button action
            e.preventDefault();

            if (1) {
                // Show loading indication
                update_submitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                update_submitButton.disabled = true;

                // Send ajax request
                axios.post(update_submitButton.closest('form').getAttribute('action'), new FormData(update_form))
                    .then(function(response) {
                        // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: response.data.message
                            , icon: "success"
                            , buttonsStyling: false
                            , confirmButtonText: "Ok, got it!"
                            , customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function(result) {
                            window.location.reload();
                            if (result.isConfirmed) {
                                if (response.data.redirect) {
                                    KTUsersList.reinit();
                                    $('#kt_modal_edit_coupon .close').click();
                                    form.reset();
                                }
                            }
                        });
                    })
                    .catch(function(error) {
                        let dataMessage = error.response.data.message;
                        let dataErrors = error.response.data.errors;

                        for (const errorsKey in dataErrors) {
                            if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                            dataMessage += "\r\n" + dataErrors[errorsKey];
                        }

                        if (error.response) {
                            Swal.fire({
                                text: dataMessage
                                , icon: "error"
                                , buttonsStyling: false
                                , confirmButtonText: "Ok, got it!"
                                , customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    })
                    .then(function() {
                        // always executed
                        // Hide loading indication
                        update_submitButton.removeAttribute('data-kt-indicator');

                        // Enable button
                        update_submitButton.disabled = false;
                    });
            }
        });




        const ship_form = document.getElementById('ship_form');
        const ship_submitButton = document.getElementById('ship_submit');

        ship_submitButton.addEventListener('click', function(e) {
            // Prevent default button action
            e.preventDefault();
            if (ship_form.checkValidity()) {

                if (1) {
                    // Show loading indication
                    ship_submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    ship_submitButton.disabled = true;

                    // Send ajax request
                    axios.post(ship_submitButton.closest('form').getAttribute('action'), new FormData(ship_form))
                        .then(function(response) {
                            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: response.data.message
                                , icon: "success"
                                , buttonsStyling: false
                                , confirmButtonText: "Ok, got it!"
                                , customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function(result) {
                                window.location.reload();
                                if (result.isConfirmed) {
                                    if (response.data.redirect) {
                                        KTUsersList.reinit();
                                        $('#ship .close').click();
                                        form.reset();
                                    }
                                }
                            });
                        })
                        .catch(function(error) {
                            let dataMessage = error.response.data.message;
                            let dataErrors = error.response.data.errors;

                            for (const errorsKey in dataErrors) {
                                if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                                dataMessage += "\r\n" + dataErrors[errorsKey];
                            }

                            if (error.response) {
                                Swal.fire({
                                    text: dataMessage
                                    , icon: "error"
                                    , buttonsStyling: false
                                    , confirmButtonText: "Ok, got it!"
                                    , customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        })
                        .then(function() {
                            // always executed
                            // Hide loading indication
                            ship_submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            ship_submitButton.disabled = false;
                        });
                }

            } else {
                // If form is not valid, trigger browser's native validation messages
                ship_form.reportValidity();
            }
        });


        const reOrder_form = document.getElementById('reOrder_form');
        const reOrder_submit = document.getElementById('reOrder_submit');

        reOrder_submit.addEventListener('click', function(e) {
            // Prevent default button action
            e.preventDefault();
            if (reOrder_form.checkValidity()) {

                if (1) {
                    // Show loading indication
                    reOrder_submit.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    reOrder_submit.disabled = true;

                    // Send ajax request
                    axios.post(reOrder_submit.closest('form').getAttribute('action'), new FormData(reOrder_form))
                        .then(function(response) {
                            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: response.data.message
                                , icon: "success"
                                , buttonsStyling: false
                                , confirmButtonText: "Ok, got it!"
                                , customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function(result) {
                                window.location.reload();
                                if (result.isConfirmed) {
                                    if (response.data.redirect) {
                                        KTUsersList.reinit();
                                        $('#reOrder .close').click();
                                        form.reset();
                                    }
                                }
                            });
                        })
                        .catch(function(error) {
                            let dataMessage = error.response.data.message;
                            let dataErrors = error.response.data.errors;

                            for (const errorsKey in dataErrors) {
                                if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                                dataMessage += "\r\n" + dataErrors[errorsKey];
                            }

                            if (error.response) {
                                Swal.fire({
                                    text: dataMessage
                                    , icon: "error"
                                    , buttonsStyling: false
                                    , confirmButtonText: "Ok, got it!"
                                    , customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        })
                        .then(function() {
                            // always executed
                            // Hide loading indication
                            reOrder_submit.removeAttribute('data-kt-indicator');

                            // Enable button
                            reOrder_submit.disabled = false;
                        });
                }

            } else {
                // If form is not valid, trigger browser's native validation messages
                reOrder_form.reportValidity();
            }
        });


        const return_form = document.getElementById('return_form');
        const return_submitButton = document.getElementById('return_submit');

        return_submitButton.addEventListener('click', function(e) {
            // Prevent default button action
            e.preventDefault();
            if (return_form.checkValidity()) {

                if (1) {
                    // Show loading indication
                    return_submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    return_submitButton.disabled = true;

                    // Send ajax request
                    axios.post(return_submitButton.closest('form').getAttribute('action'), new FormData(return_form))
                        .then(function(response) {
                            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: response.data.message
                                , icon: "success"
                                , buttonsStyling: false
                                , confirmButtonText: "Ok, got it!"
                                , customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function(result) {
                                window.location.reload();
                                if (result.isConfirmed) {
                                    if (response.data.redirect) {
                                        KTUsersList.reinit();
                                        $('#return .close').click();
                                        form.reset();
                                    }
                                }
                            });
                        })
                        .catch(function(error) {
                            let dataMessage = error.response.data.message;
                            let dataErrors = error.response.data.errors;

                            for (const errorsKey in dataErrors) {
                                if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                                dataMessage += "\r\n" + dataErrors[errorsKey];
                            }

                            if (error.response) {
                                Swal.fire({
                                    text: dataMessage
                                    , icon: "error"
                                    , buttonsStyling: false
                                    , confirmButtonText: "Ok, got it!"
                                    , customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        })
                        .then(function() {
                            // always executed
                            // Hide loading indication
                            return_submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            return_submitButton.disabled = false;
                        });
                }

            } else {
                // If form is not valid, trigger browser's native validation messages
                return_form.reportValidity();
            }
        });


        function formatDecimal(input) {
        // Remove any dollar signs
        input.value = input.value.replace('$', '');

        // Check if the input value contains a decimal point
        if (input.value.includes('.')) {
            var parts = input.value.split('.');
            // Limit the decimal places to 2
            if (parts[1].length > 2) {
                parts[1] = parts[1].slice(0, 2);
                input.value = parts.join('.');
            }
        }
        // Ensure the input value is not an empty string and is a valid number
        else if (input.value !== '' && !isNaN(input.value)) {
            input.value = parseFloat(input.value);
        }
        // If input is not a valid number, set the value to an empty string
        else {
            input.value = '';
        }
    }


        function handleBackspace(event, input) {
    // Check if the pressed key is the backspace key
    if (event.key === 'Backspace') {
        // Get the cursor position
        var cursorPosition = input.selectionStart;
        // Check if the cursor is after the decimal point
        if (input.value.includes('.') && cursorPosition > input.value.indexOf('.')) {
            // Allow deleting the digit
            return true;
        }
        // If cursor is before the decimal point, allow default behavior (deleting digits before the decimal point)
        return true;
    }
    // Allow default behavior for other keys
    return true;
}

        var img_num = 0;

        function multiImgPreview(input, imgPreviewPlaceholder) {
            if (input.files) {
                var filesAmount = input.files.length;
                img_num = 0;


                $(imgPreviewPlaceholder).find('button').each(function(index) {
                    if (!$(this).attr('onclick').includes('del_image_api')) {
                        $(this).parent().remove()
                    }
                });


                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        img = '<div class="col"><img src="' + event.target.result + '" /><button  onclick="removeFileFromFileList($(this).parent().parent().parent().next().find(\'input\')[0],' + img_num + ')"  type="button" aria-label="Remove file" title="Remove file" style="border: none;background: transparent;position: absolute;"><svg aria-hidden="true" focusable="false" class="UppyIcon" width="18" height="18" viewBox="0 0 18 18"><path d="M9 0C4.034 0 0 4.034 0 9s4.034 9 9 9 9-4.034 9-9-4.034-9-9-9z"></path><path fill="#FFF" d="M13 12.222l-.778.778L9 9.778 5.778 13 5 12.222 8.222 9 5 5.778 5.778 5 9 8.222 12.222 5l.778.778L9.778 9z"></path></svg></button></div>'

                        $(input).parent().prev().children().append(img)
                        img_num++
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };
        $('#images').on('change', function() {
            multiImgPreview(this, 'div.imgPreview');
        });

        function removeFileFromFileList(input, index) {
            const dt = new DataTransfer()
            const {
                files
            } = input

            for (let i = 0; i < files.length; i++) {
                const file = files[i]
                if (index !== i)
                    dt.items.add(file) // here you exclude the file. thus removing it.
            }

            input.files = dt.files // Assign the updates list

            multiImgPreview(input, 'div.imgPreview');

        }



        function del_image_api(t, id) {
            axios.get("{{ route('warehouses.list.delimage') }}?id=" + id);
            $(t).parent()[0].remove();
        }

        function del_label_api(t, id) {
            axios.get("{{ route('warehouses.list.delinlabel') }}?id=" + id);
            $(t).parent()[0].remove();
        }

    </script>
    @endsection


</x-base-layout>
