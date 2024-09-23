<x-base-layout>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="d-flex justify-content-start">

                <div class="btn-group" role="group" aria-label="Large button group">
                    <button type="button" id="new_setup" data-toggle="modal" data-target="#m_modal_5" class="m-btn btn btn-outline-primary">Inventory Approval</button>
                    <button type="button" id="setup" data-toggle="modal" data-target="#m_modal_5" class="m-btn btn btn-outline-primary ">Inventory</button>
                    <button type="button" id="history" data-toggle="modal" data-target="#m_modal_5" class="m-btn btn btn-outline-primary">Orders</button>
                    <button type="button" id="returns_approval" data-toggle="modal" data-target="#m_modal_5" class="m-btn btn btn-outline-primary active">Returns Approval</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to download?</p>
            <button id="yesButton" class="btn btn-primary">Yes</button>
            <button id="noButton" class="btn btn-secondary">No</button>
        </div>
    </div>

    <div class="card ">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">

                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->

                    <!--end::Svg Icon-->

                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar ">
                <!--begin::Toolbar-->
                {{-- @if($orders>0) --}}

                {{-- <button type="button" class="btn btn-primary" id="download_labels" data-bs-toggle="modal" data-bs-target="#confirmModal">Download</button> --}}


                {{-- <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#csv_file" style="background-color: #033958;
                margin-right: 0 !important;" id="confirmation">

                    Download labels
                </button> --}}




                {{-- @endif --}}
                <div class="modal fade" id="csv_file" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_add_credits_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder">Confirmation</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal" data-bs-target="#csv_file">
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
                            <div class="modal-body scroll-y mx-3 mx-xl-5 my-3">
                                <p>The status of orders will be shipped after download. Are you sure you want to download the labels?</p>
                            <!--end::Scroll-->
                            <!--begin::Actions-->
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal" data-bs-target="#csv_file_button">Discard</button>
                                <button  class="btn btn-primary" id="download_labels" >
                                    <span class="indicator-label">Yes</span>
                                </button>
                            </div>
                            <!--end::Actions-->
                            <!--end::Form-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">





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
                                <option value="1">Returning</option>
                                <option value="2">Damage</option>
                                <option value="3">Missing</option>
                                <option value="4">Pending</option>


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
                            <button type="reset" class="btn btn-light btn-active-light-primary fw-bold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                            <button type="submit" class="btn btn-primary fw-bold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Menu 1-->
                <!--end::Filter-->

                {{ theme()->getView('pages/warehouse_returns/edit',['users'=>$users,'warehouse' =>$warehouse]) }}
                {{ theme()->getView('pages/warehouse_returns/approve',['users'=>$users,'warehouse' =>$warehouse]) }}


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
                            {{-- <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Viewer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}
                            <div class="modal-body">
                                <div id="mediaContainer" style="text-align: center"></div>
                                <a id="downloadButton" href="#" class="btn btn-primary" style="display: none;">Download</a>
                            </div>
                        </div>
                    </div>
                </div>





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
        <table class="table align-middle table-row-dashed fs-6 gy-5 text-center" id="kt_table_coupons">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_coupons .form-check-input" value="1" />
                        </div>
                    </th>
                    <th class="min-w-125px text-center " style="padding-left: 25px !important;">ACTION</th>
                     <th class="min-w-50px text-center ">Return Date</th>
                     <th class="min-w-50px text-center ">Order ID</th>
                    {{--<th class="min-w-125px text-center ">Part Picture</th>--}}
                    <th class="min-w-125px text-center ">Part Number</th>
                    <th class="min-w-125px text-center ">Parts Status</th>
                    <th class="min-w-125px text-center ">Tracking ID</th>
                    <th class="min-w-125px text-center ">Status</th>
                    <th class="min-w-125px text-center ">Returned count</th>

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
                        url: "<?= route('va.returns.datatableapi') ?>"
                        , data: {
                            found: 1,
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
                    , pageLength: 50
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
                            data: 'return_date'
                            , name: 'return_date'
                            , orderable: false
                            , searchable: true
                        },
                        {
                            data: 'order_id'
                            , name: 'order_id'
                            , orderable: false
                            , searchable: true
                        },

                        // {
                        //     data: 'Picture'
                        //     , name: 'Picture'
                        //     , orderable: true
                        //     , searchable: false
                        //     , render: function(data, type, row) {
                        //         var image = data.split(',');
                        //         return '<img class="img-click" src="' + image[0] + '" style="border-radius: 20px;width: 100px;height: 100px;" onclick="openModal(\'' + image + '\', \'image\');">';
                        //     }
                        // }
                         {
                            data: 'Part'
                            , name: 'Part'
                            , orderable: true
                            , render: function(data, type, full, meta) {
                                return type === 'display' ? data.replace(/,/g, '\n') : data; // Replace <br> with newline character
                            }
                        },
                        {
                            data: 'part_status'
                            , name: 'part_status'
                            , orderable: true
                            , render: function(data, type, full, meta) {
                                return type === 'display' ? data.replace(/,/g, '\n') : data; // Replace <br> with newline character
                            }
                        },

                        //  {
                        //     data: 'part_status'
                        //     , name: 'part_status'
                        //     , orderable: true,

                        // },
                         {
                            data: 'Tracking'
                            , name: 'Tracking'
                            , orderable: true,

                        },

                        {
                            data: 'status'
                            , name: 'status'
                            , orderable: true,

                        },

                        {
                            data: 'returned_count'
                            , name: 'returned_count'
                            , orderable: true,

                        },




                    ]
                    , columnDefs: [{
                            orderable: false
                            , targets: 0
                        }, // Disable ordering on column 0 (checkbox)
                        {
                            orderable: false
                            , targets: 1
                        },
                         {
                            targets: 2, // Index of the column starting from 0
                            width: "10%", // Fixed width for the column
                        },
                        {
                            targets: 3, // Index of the column starting from 0
                            width: "1%", // Fixed width for the column
                        },
                        {
                            targets: 4, // Index of the column starting from 0
                            width: "1%", // Fixed width for the column
                        }

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
                    datatable.destroy();
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
                                            url: "<?= route('return.delete') ?>"
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
                                    text: 'Approval was not deleted.'
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
                                        url: "<?= route('return.delete') ?>"
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
                                text: 'Selected return was not deleted.'
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

        function edit(id) {
            data = KTUsersList.getrows(id);
            console.log(data);
            $('#inventory_id').val(id);
            var image_route = "{{ asset('warehousedataimage') }}";

            $('#kt_modal_edit_coupon_form').find('input[name=customer_name]').val(data['customer_name']);
            $('#kt_modal_edit_coupon_form').find('input[name=status]').val(data['status']);
            $('#kt_modal_edit_coupon_form').find('input[name=tracking]').val(data['tracking']);
            $('#kt_modal_edit_coupon_form').find('input[name=inventory_count]').val(data['returned_count']);
            $('#kt_modal_edit_coupon_form').find('input[name=part]').val(data['part']);
            $('#kt_modal_edit_coupon_form').find('input[name=asin]').val(data['asin']);
            $('#kt_modal_edit_coupon_form').find('input[name=title]').val(data['title']);
            $('#kt_modal_edit_coupon_form').find('input[name=label_price]').val(data['label_price']);

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

        function approve(id){
               var data =  KTUsersList.getrows(id);
               console.log(data);

              var asset_path ="{{ asset('public/warehousedataimage') }}";

              $('#approve_form').find('input[name=tracking]').val(data['Tracking']);
               $('#approve_form').find('input[name=part]').val(data['Part']);
               $('#approve_form').find('input[name=id]').val(data['id']);
                $('#approve_form').find('input[name=inventory_count]').val(data['returned_count']);

                var partsString = data['Part'];
                var quantity = data['returned_count'];
                console.log(partsString);
                generateInputs(partsString,quantity);

              $('#approve_form').find('#outlabel').html('');
              var image_route = "{{ asset('warehousedataimage') }}";

              $('#approve_form').find('.imgPreview2').html('');

            // Populate image previews with fetched images
            if (data['picture'] !== null) {
                            var images = data['picture'].split(',');
                            for (var i = 0; i < images.length; i++) {
                                var imageUrl = image_route + '/' + images[i].trim();
                                var imgElement = $('<img>').attr('src', imageUrl);

                                var columnDiv = $('<div>').addClass('col').append(imgElement);
                                $('#approve_form').find('.imgPreview2').append(columnDiv);
                            }
                        }


               $('#approve_form').attr('action');
            }

            function generateInputs(partsString,quantity) {
    // Split the string into an array of part-quantity pairs
    var partsArray = partsString.split(',');

    // Clear previous inputs
    $('#parts_container').empty();
        console.log(quantity);

    // Populate inputs based on parts and quantities
    partsArray.forEach(function(pair, index) {
        var partQuantity = pair.split(':');
        var part = partQuantity[0].trim();
        var count='';
        if(partQuantity[1] !== undefined && partQuantity[1].trim() !== ''){
            var count = partQuantity[1].trim();
        }else{
            var count = quantity;

        }
        var inputGroup = $('<div>').addClass('input-group mb-3');
        inputGroup.append($('<input>').attr({
            type: 'text',
            class: 'form-control',
            name: 'part[' + index + ']',
            value: part,
            readonly: true
        }));
        inputGroup.append($('<input>').attr({
            type: 'number',
            class: 'form-control',
            name: 'inventory_count[' + index + ']',
            value: count,
            readonly: false
        }));
       // Add options for the select dropdown
            var select = $('<select>').attr({
                class: 'form-control',
                name: 'status[' + index + ']',
                readonly: true
            });
            select.append($('<option>').attr('value', 'Damage part').text('Damage'));
            select.append($('<option>').attr('value', 'approved').text('Approved'));
            select.append($('<option>').attr('value', 'Missing part').text('Missing'));

            inputGroup.append(select);

        $('#parts_container').append(inputGroup);
    });
}

const approve_form = document.getElementById('approve_form');
const approve_submit = document.getElementById('approve_submit');

approve_submit.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (1) {


            if (1) {
                // Show loading indication
                approve_submit.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    approve_submit.disabled = true;

                    // Send ajax request
                    axios.post(approve_submit.closest('form').getAttribute('action'), new FormData(approve_form))
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
                                       $('#approve .close').click();
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
                            approve_submit.removeAttribute('data-kt-indicator');

                            // Enable button
                            approve_submit.disabled = false;
                        });
            }

    }
});

        $(document).ready(function() {

            // Handle click event on Download button
            $('#download_labels').on('click', function() {
                var link = document.createElement('a');
                link.style.display = 'none';
                document.body.appendChild(link);

                link.href = "<?= route('download_labels') ?>";

                link.click();

                $('#csv_file').modal('hide');
                updateDataTable();
                $('#confirmation').hide();
        });

        function updateDataTable() {
            $("#kt_table_coupons").DataTable().ajax.reload();
        }




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
        });
        var inventory = document.getElementById('new_setup');
        var inventoryButton = document.getElementById('setup');
        var ordersButton = document.getElementById('history');

        // Add click event listeners to the buttons
        inventory.addEventListener('click', function() {
            // Add the 'active' class to the inventory button
            inventory.classList.add('active');
            // Remove the 'active' class from the orders button
            ordersButton.classList.remove('active');
            inventoryButton.classList.remove('active');
            returns.classList.remove('active');

            // Redirect to the inventory route
            window.location.href = "{{ url('/va-approval') }}";

        });
        inventoryButton.addEventListener('click', function() {
            // Add the 'active' class to the inventory button
            inventoryButton.classList.add('active');
            // Remove the 'active' class from the orders button
            ordersButton.classList.remove('active');
            inventory.classList.remove('active');
            returns.classList.remove('active');

            // Redirect to the inventory route
            window.location.href = "{{ url('/VaEssandent') }}";
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
            window.location.href = "{{ url('/va-orders') }}";
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
                        imageElement.src = '/warehousedataimage/' + imageUrl;
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


        // Define form element
        const update_form = document.getElementById('kt_modal_edit_coupon_form');

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/


        // Submit button handler
        const update_submitButton = document.getElementById('kt_docs_updte_formvalidation_text_submit');
        update_submitButton.addEventListener('click', function(e) {
            // Prevent default button action
            e.preventDefault();

            if (update_form.checkValidity()) {



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

            } else {
                // If form is not valid, trigger browser's native validation messages
                update_form.reportValidity();
            }
        });






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
