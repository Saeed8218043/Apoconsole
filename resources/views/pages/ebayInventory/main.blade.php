<x-base-layout>
<div class="card ">
        <!--begin::Card header-->
        <div class="card-header border-0 p-6">

            <h6>
                Total kit: {{ $kit_inventory }}<br>
                @if (isset($latestKitInventory) && $latestKitInventory!=null)
                Updated at: {{ $latestKitInventory }}
                @endif
            </h6>
            <!--begin::Card title-->

            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar m-0">
                <!--begin::Toolbar-->

                <div class="d-flex justify-content-start justify-content-sm-end flex-wrap gap-1 button-area tables-buttons align-items-start" style="display: none !important;" data-kt-user-table-toolbar="base">


                     <?php
                    $file_name = '';
                    $file_time = '';
                             $files = scandir('./cron/pf');
                             foreach($files as $file){
                                if (isset(explode('.',$file)[1]) && explode('.',$file)[1] == 'zip'){
                                   $file_name = $file;
                                   $file_time = filemtime('./cron/pf/'.$file_name);
                                   break;
                                }
                             }
                         ?>
                    @if (strlen($file_time) > 0)
                    <a type="button" href="{{ route('downloadpf',['name'=>$file_name]) }}" class="btn btn-sm btn-secondary me-1 lh-1" >
                         <?= $file_name.'<br>' ?>
                         <?= Carbon\Carbon::parse($file_time)->diffForHumans() ?>
                    </a>
                    @endif

                    <a type="button" id="KitexportButton"  href="{{ route('hybrid.export_inventory') }}" class="btn btn-sm btn-info me-2">
                       Kit Export
                    </a>

                    <a type="button" id="PartexportButton"  href="{{ route('hybrid.parts_export') }}" class="btn btn-sm btn-info me-2">
                        Parts Export
                    </a>

                    {{ theme()->getView('pages/ebayInventory/add_csv',['users'=>$users]) }}

                     <!--theme()->getView('pages/pf/add_niches',['users'=>$users]) -->

                    {{ theme()->getView('pages/ebayInventory/edit_pf') }}
                    {{-- {{ theme()->getView('pages/pf/edit_niches') }} --}}

                    {{ theme()->getView('pages/ebayInventory/pf_vendor_csv') }}

                    {{ theme()->getView('pages/ebayInventory/calculator') }}
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Filter
                    </button>

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
                                    <option value="0">Pending</option>
                                    <option value="1">Out of stock</option>
                                    <option value="2">Robot error</option>
                                    <option value="3">invalid link</option>
                                    <option value="4">Part not exist</option>
                                    <option value="link">Link Not exist</option>
                                    <option value="200">Working</option>

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
                    </div>
                    <!--begin::Export-->
                    <button type="button" class="btn btn-sm btn-light-primary me-2"  style="display: none;"  data-bs-toggle="modal"
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
                    <button type="button" class="btn btn-danger btn-sm" data-kt-user-table-select="delete_selected">Delete
                        Selected</button>
                </div>
                <!--end::Group actions-->


            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 table-responsive">
            <form action="{{route('updateCsvPercentage')}}" method="POST">
                @csrf
                <input type="hidden" value="hybrid" name="warehouse_name">
            <div class="row">
                <!-- Input Groups Start -->
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <label for="walmart-percentage-input">Walmart Percentage</label>
                    <div class="input-group">
                        <input type="number" min="0" max="100" id="walmart-percentage-input" class="form-control" value="{{$walmart_percentage}}" name="walmart_percentage" placeholder="Walmart percentage" aria-label="Walmart percentage" aria-describedby="walmart-percentage">
                        <button type="submit" class="btn btn-secondary" id="walmart-percentage">Save</button>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <label for="pf-percentage-input">PF Percentage</label>
                    <div class="input-group">
                        <input type="number" min="0" max="100" id="pf-percentage-input" class="form-control" value="{{$pf_percentage}}" name="pf_percentage" placeholder="pf percentage" aria-label="profit percentage" aria-describedby="walmart-percentage">
                        <button type="submit" class="btn btn-secondary" id="pf-percentage">Save</button>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <label for="profit-percentage-input">Profit Percentage</label>
                    <div class="input-group">
                        <input type="number" min="0" max="100" id="profit-percentage-input" class="form-control" value="{{$percentage}}" name="percentage"  placeholder="profit percentage" aria-label="profit percentage" aria-describedby="walmart-percentage">
                        <button type="submit" class="btn btn-secondary" id="profit-percentage">Save</button>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <label for="qtyzero-input">QTY to Zero</label>
                    <div class="input-group">
                        <input type="number" min="0" max="100" id="qtyzero-input" class="form-control" placeholder="QTY to Zero" value="{{$zero_qty}}" name="zero_qty" aria-label="QTY to Zero" aria-describedby="qtyzero-input">
                        <button type="submit" class="btn btn-secondary" id="qtyzero-input">Save</button>
                    </div>
                </div>
                <!-- Input Groups Ends -->

            <hr class="my-5"/>

                        </div>
                    </form>


            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_coupons">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                    data-kt-check-target="#kt_table_coupons .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="w-10px pe-2">

                        </th>

                        <th class="min-w-50px">ID</th>
                        <th class="min-w-50px">Item Number</th>

                        <th class="min-w-50px">Cost</th>
                        <th class="min-w-50px">QTY</th>
                        {{-- <th class="min-w-50px">Shipping</th> --}}
                        {{-- <th class="min-w-50px">Handling</th> --}}
                        <th class="min-w-50px">Gross Price</th>
                        <th class="min-w-50px">Profit</th>
                        <th class="min-w-50px">Sale Price</th>
                        <th class="min-w-50px">Status</th>

                        <th class="min-w-50px">ACTION</th>

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
            var data;
            var segment1 = window.location.pathname.split('/')[1];
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
                            url: "<?= route('hybrid.datatableapi') ?>",
                            data: {
                                found: 1,
                                warehouse_name:segment1,
                                status: document.getElementById('status').value,
                                 vendor: 2,
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
                        info: true,
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
                                className: 'dt-control',
                                orderable: false,
                                data: null,
                                defaultContent: ''
                            },
                            {
                                data: 'kid',
                                name: 'kid',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'ksku',
                                name: 'ksku',
                                orderable: true,

                            },
                            {
                                data: 'kcost',
                                name: 'kcost',
                                orderable: true,
                                searchable: false
                            },

                             {
                                data: 'kinventory',
                                name: 'kinventory',
                                orderable: true,
                                searchable: false
                            },


                            // {
                            //     data: 'kshipping',
                            //     name: 'kshipping',
                            //     orderable: true,
                            //     searchable: false
                            // },
                            // {
                            //     data: 'khandling',
                            //     name: 'khandling',
                            //     orderable: true,
                            //     searchable: false
                            // },
                            {
                                data: 'gross',
                                name: 'gross',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'kprofit',
                                name: 'kprofit',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'sale_price',
                                name: 'sale_price',
                                orderable: true,
                                searchable: false
                            },
                             {
                                data: 'status',
                                name: 'status',
                                orderable: false,
                                searchable: false
                            },

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
                    });
                    data = datatable;

                    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                    datatable.on('draw', function() {
                        initToggleToolbar()
                        handleDeleteRows()
                        toggleToolbars()
                        KTMenu.createInstances();
                    })
                }

                // //Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
                // var handleSearchDatatable = () => {
                //     const filterSearch = document.querySelector(
                //         '[data-kt-user-table-filter="search"]'
                //     )
                //     filterSearch.addEventListener('keyup', function(e) {
                //         datatable.search(e.target.value).draw()
                //     })
                // }

                var handleFilterDatatable = () => {
                const filterForm = document.querySelector(
                    '[data-kt-user-table-filter="form"]'
                )
                const filterButton = filterForm.querySelector(
                    '[data-kt-user-table-filter="filter"]'
                )
                const selectOptions = filterForm.querySelectorAll('select')

                filterButton.addEventListener('click', function() {
                    var filterString = ''
                    datatable.destroy();
                    initUserTable();

                })
            }

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
                                                url: "<?= route('hybrid.bulkdelete') ?>",
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
                                            url: "<?= route('hybrid.bulkdelete') ?>",
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
                        //handleSearchDatatable()
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
                KTUsersList.init();

                $('#kt_table_coupons').on('click', 'td.dt-control', function (e) {
                    let tr = e.target.closest('tr');
                    let row = data.row(tr);

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                    }
                    else {
                        // Open this row
                        row.child(format(row.data())).show();
                    }
                });
            })

            function edit(id){

            $.ajax({
                    url: "{{ route('get_hybrid_inventory') }}",
                    method: "GET",
                    data: { id: id },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                    console.log(data);
                    var pfParts = data.pf_parts; // Assuming the parts are in the 'pf_parts' property
                    $('.po_number').text(data.pf_kit.sku);

                    // Clear existing parts before appending new ones
                    $('#dynamic-parts-container').empty();

                    // Loop through pf_parts and append HTML for each part
                    pfParts.forEach(function (part, index) {
                        var partIndex = index + 1;
                        var partDiv = `
                            <div class="fv-row mb-7" id="input_${partIndex}" style="display: flex; gap: 10px; align-items: flex-end;">
                                <div>
                                    <label class="required fw-bold fs-6 mb-2">Part Number ${partIndex}</label>
                                    <input required type="text" name="parts[${partIndex}]" class="form-control form-control-solid mb-3 mb-lg-0" value="${part.part_no}" placeholder="Type..." />
                                </div>
                                <div>
                                    <label class="required fw-bold fs-6 mb-2">Link ${partIndex}</label>
                                    <input required type="text" name="links[${partIndex}]" class="form-control form-control-solid mb-3 mb-lg-0" value="${part.link || ''}" placeholder="Type..." />
                                </div>
                                <div>
                                    <button type="button" class="btn btn-danger remove-input" data-index="${partIndex}">Remove</button>
                                </div>
                            </div>
                        `;

                        // Append the part div to the container
                        $('#dynamic-parts-container').append(partDiv);
                    });
                    $('#kit_id').val(data.pf_kit);
                }

});
            }

            $(document).ready(function() {
                const $exportButton = $('#KitexportButton');
                const $PartexportButton = $('#PartexportButton');
                const $statusSelect = $('#status');

                $statusSelect.on('change', function() {
                    const selectedStatus = $(this).val();
                    const baseUrl1 = '{{ route('hybrid.export_inventory') }}';
                    const url1 = new URL(baseUrl1, window.location.origin);

                    const baseUrl2 = '{{ route('hybrid.parts_export') }}';
                    const url2 = new URL(baseUrl2, window.location.origin);

                    if (selectedStatus) {
                        url1.searchParams.set('status', selectedStatus);
                        url2.searchParams.set('status', selectedStatus);
                    } else {
                        url1.searchParams.delete('status'); // Remove status if no selection
                        url2.searchParams.delete('status'); // Remove status if no selection
                    }

                    $exportButton.attr('href', url1.toString()); // Update button's href
                    $PartexportButton.attr('href', url2.toString()); // Update button's href
                });

    // Trigger change event on page load to set the initial href
    $statusSelect.trigger('change');

                var segment = window.location.pathname.split('/')[1];
                $('.warehouse_name').val(segment);
    var currentIndex = 1; // Initial index

    // Function to add a new input field
    function addInputField() {
    // Get the number of existing input fields
    var numInputs = $('[id^="input_"]').length;

    // Calculate the correct index based on the number of existing input fields
    var newIndex = numInputs + 1;

    var partDiv = `
        <div class="fv-row mb-7 input_${newIndex}" id="input_${newIndex}" style="display: flex; gap: 10px; align-items: flex-end;">
            <div>
                <label class="required fw-bold fs-6 mb-2">Part Number ${newIndex}</label>
                <input required type="text" name="parts[${newIndex}]" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Type...">
            </div>
            <div>
                <label class="required fw-bold fs-6 mb-2">Link ${newIndex}</label>
                <input required type="text" name="links[${newIndex}]" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Type...">
            </div>
            <div>
                <button type="button" class="btn btn-danger remove-input" data-index="${newIndex}">Remove</button>
            </div>
        </div>
    `;

    // Append the part div to the container
    $('#dynamic-parts-container').append(partDiv);
}

    // Function to remove an existing input field
    function removeInputField(index) {
        $('.input_' + index).remove(); // Remove the div with the specified index
        $('#input_' + index).remove(); // Remove the div with the specified index
    }

    // Add button click event
    $('#add-input').click(function() {
        addInputField();
    });

    // Remove button click event
    $(document).on('click', '.remove-input', function() {
        var indexToRemove = $(this).data('index');
        console.log(indexToRemove);
        removeInputField(indexToRemove);
    });
});


        // Define form element
const form = document.getElementById('kt_modal_add_coupon_form');




function format(d) {
    // `d` is the original data object for the row
    return (
        d.detail
    );
}

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
// var validator = FormValidation.formValidation(
//     form,
//     {
//         fields: {
//             'code': {
//                 validators: {
//                     notEmpty: {
//                         message: 'Title is required!'
//                     }
//                 }
//             },


//         },

//         plugins: {
//             trigger: new FormValidation.plugins.Trigger(),
//             bootstrap: new FormValidation.plugins.Bootstrap5({
//                 rowSelector: '.fv-row',
//                 eleInvalidClass: '',
//                 eleValidClass: ''
//             })
//         }
//     }
// );

// // Submit button handler
// const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
// submitButton.addEventListener('click', function (e) {
//     // Prevent default button action
//     e.preventDefault();

//     // Validate form before submit
//     if (validator) {
//         validator.validate().then(function (status) {
//             console.log('validated!');

//             if (status == 'Valid') {
//                 // Show loading indication
//                 submitButton.setAttribute('data-kt-indicator', 'on');

//                     // Disable button to avoid multiple click
//                     submitButton.disabled = true;

//                     // Send ajax request
//                     axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form))
//                         .then(function (response) {
//                             // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
//                             Swal.fire({
//                                 text: response.data.message,
//                                 icon: "success",
//                                 buttonsStyling: false,
//                                 confirmButtonText: "Ok, got it!",
//                                 customClass: {
//                                     confirmButton: "btn btn-primary"
//                                 }
//                             }).then(function (result) {
//                                 window.location.reload();
//                                 if (result.isConfirmed) {
//                                     if (response.data.redirect) {
//                                         KTUsersList.reinit();
//                                         // $('div[data-bs-toggle="modal"]').click();
//                                         $('#kt_modal_add_coupon .close').click();
//                                         form.reset();

//                                     }
//                                 }
//                             });

//                         })
//                         .catch(function (error) {
//                             let dataMessage = error.response.data.message;
//                             let dataErrors = error.response.data.errors;

//                             for (const errorsKey in dataErrors) {
//                                 if (!dataErrors.hasOwnProperty(errorsKey)) continue;
//                                 dataMessage += "\r\n" + dataErrors[errorsKey];
//                             }

//                             if (error.response) {
//                                 Swal.fire({
//                                     text: dataMessage,
//                                     icon: "error",
//                                     buttonsStyling: false,
//                                     confirmButtonText: "Ok, got it!",
//                                     customClass: {
//                                         confirmButton: "btn btn-primary"
//                                     }
//                                 });
//                             }
//                         })
//                         .then(function () {
//                             // always executed
//                             // Hide loading indication
//                             submitButton.removeAttribute('data-kt-indicator');

//                             // Enable button
//                             submitButton.disabled = false;
//                         });

//             }
//         });
//     }
// });

// Define form element
const update_form = document.getElementById('kt_modal_edit_coupon_form');

// // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var update_validator = FormValidation.formValidation(
    update_form,
    {
        fields: {
            'code': {
                validators: {
                    notEmpty: {
                        message: 'Title is required!'
                    }
                }
            },


        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                eleInvalidClass: '',
                eleValidClass: ''
            })
        }
    }
);

// Submit button handler
const update_submitButton = document.getElementById('kt_docs_updte_formvalidation_text_submit');
update_submitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (update_validator) {
        update_validator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                update_submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    update_submitButton.disabled = true;

                    // Send ajax request
                    axios.post(update_submitButton.closest('form').getAttribute('action'), new FormData(update_form))
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
                                      $('#kt_modal_edit_coupon .close').click();
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
                            update_submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            update_submitButton.disabled = false;
                        });

            }
        });
    }
});


// *******************************
var thisss='';
   function sync_now(sku,t){
       thisss=t;

        $(thisss).find('path').css({ fill: 'yellow'});


            axios.get('/miniapp_shopify/cron_job_single_sku__sync_price_quantity_with_Shopify.php?sku_____search='+sku)
  .then(function (response) {
    console.log(response);
    if (response.data == '') {
          Swal.fire({
                                            text: "Product Not Found on Shopiyfy!",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
    } else {
                                     Swal.fire({
                                            text: "Product Sync Successfully!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                         $(thisss).find('path').css({ fill: 'green'});
    }

  })
  .catch(function (error) {

  })
  .then(function () {

  });
    }


var temp = '';
$(document).ready(function(){
    $('#check_stock_form').on('submit', function(event){

        event.preventDefault();
        temp=this;
        $('#cs_response').html(' ');
        $(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
        $(this).find('button[type=submit')[0].disabled = true;

        $.ajax({
            url:"{{ route('vendor_check_stock') }}",
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


                console.log(data);
                temp = data;

                    if (data.data.message != undefined){
                    $('#cs_response').html(' ');
                    $('#cs_response').html('<p style="color: red;" >error: '+data.data.message+'</p>');
                    return;
                   }

                if (data.data[0] != undefined){
                   $('#cs_response').html(' ');
                    $('#cs_response').html('<p><strong>SKU: </strong>'+data.data[0].sku+'</p><p><strong>Brand: </strong>'+data.data[0].brandId+'</p><p><strong>Price: </strong>'+data.data[0].price+'</p><p><strong>Stock: </strong>'+data.data[0].stock+'</p>');
                    return;
                }

            }
        });

        });

        $('#kt_modal_add_csv_form').on('submit', function(event){

        event.preventDefault();
        temp=this;
        $(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
        $(this).find('button[type=submit')[0].disabled = true;

        $.ajax({
            url:"{{route('hybrid.upload-csv')}}",
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
            url:"{{route('hybrid.insert-csv')}}",
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

           Swal.fire({
                                text: data.message,
                                icon: data.type,
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if(document.type == 'success'){
                                    window.location.reload();
                                }


                            });
            }
        });

        });

});



// ---------------------   Vendor Csv Upload -------------------------------------


// $(document).ready(function(){




//          $('#kt_modal_add_csv_form').on('submit', function(event){

//         event.preventDefault();
//         temp=this;
//         $(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
//         $(this).find('button[type=submit')[0].disabled = true;












//         axios.post("{{route('pf.vendor_csv')}}", new FormData(this))
//                         .then(function (response) {
//                             // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
//                             Swal.fire({
//                                 text: response.data.message,
//                                 icon: "success",
//                                 buttonsStyling: false,
//                                 confirmButtonText: "Ok, got it!",
//                                 customClass: {
//                                     confirmButton: "btn btn-primary"
//                                 }
//                             }).then(function (result) {
//                                 window.location.reload();

//                             });
//                         })
//                         .catch(function (error) {
//                             let dataMessage = error.response.data.message;
//                             let dataErrors = error.response.data.errors;

//                             for (const errorsKey in dataErrors) {
//                                 if (!dataErrors.hasOwnProperty(errorsKey)) continue;
//                                 dataMessage += "\r\n" + dataErrors[errorsKey];
//                             }

//                             if (error.response) {
//                                 Swal.fire({
//                                     text: dataMessage,
//                                     icon: "error",
//                                     buttonsStyling: false,
//                                     confirmButtonText: "Ok, got it!",
//                                     customClass: {
//                                         confirmButton: "btn btn-primary"
//                                     }
//                                 });
//                             }
//                         })
//                         .then(function () {
//                             $(temp).find('button[type=submit')[0].removeAttribute('data-kt-indicator');
//         $(temp).find('button[type=submit')[0].disabled = false;
//                         });














//         });

// });





function sync_all_prices(t){
    // $(t).text('Syncing....');

    //  axios.get('https://autooutletllc.com/data.php?step_1=1').then(function (e){
    //      Swal.fire({
    //                             text: "INventory Updated from Latest Csv",
    //                             icon: "success",
    //                             buttonsStyling: false,
    //                             confirmButtonText: "Ok, got it!",
    //                             customClass: {
    //                                 confirmButton: "btn btn-primary"
    //                             }
    //                         })
    //  });
}


        </script>
        <script>
                    $(document).ready(function(){
                        $('.button-area').attr('style','')
                    })
                </script>
    @endsection

</x-base-layout>
