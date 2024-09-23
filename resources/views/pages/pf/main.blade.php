<x-base-layout>
<div class="card ">
        <!--begin::Card header-->
        <div class="card-header border-0 p-6">

            <h6>
                Total kit: {{ $kit_inventory }}<br>
                @if (isset($latestKitInventory) && $latestKitInventory!=null)
                Updated at: {{ \Carbon\Carbon::parse($latestKitInventory->latest('created_at')->value('created_at'))->timezone('Asia/Karachi')->format('d-m-Y h:ia') }}
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

                    <a type="button" href="{{ url('pf_export_inventory?warehouse_name=' . $warehouse_name) }}" class="btn btn-sm btn-info me-2">
                        Export
                    </a>

                    {{ theme()->getView('pages/pf/add_csv',['users'=>$users]) }}

                     <!--theme()->getView('pages/pf/add_niches',['users'=>$users]) -->

                    {{ theme()->getView('pages/pf/edit_pf') }}
                    {{-- {{ theme()->getView('pages/pf/edit_niches') }} --}}

                    {{ theme()->getView('pages/pf/pf_vendor_csv') }}

                    {{ theme()->getView('pages/pf/calculator') }}

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



<!--                     <button type="button"  data-bs-toggle="modal" data-bs-target="#pf_vendor_csv" class="btn btn-light-primary" >-->
                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
<!--                        <span class="svg-icon svg-icon-2">-->
<!--                           <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.o1999/xlink" x="0px" y="0px" viewBox="0 0 503.2 503.2" style="enable-background:new 0 0 503.2 503.2;" xml:space="preserve">-->
<!--	<path style="fill: #009ef7;" d="M479.2,227.6c-13.6,0-24,10.4-24,24c0,112-91.2,203.2-203.2,203.2S48.8,363.6,48.8,251.6-->
<!--	S140,47.6,252,47.6c58.4,0,113.6,28,152,68h-43.2c-13.6,0-24,10.4-24,24s10.4,24,24,24H484v-124c0-13.6-10.4-24-24-24-->
<!--	s-24,10.4-24,24V82C388,30,321.6,0.4,251.2,0.4C112.8,0.4,0,113.2,0,251.6s113.6,251.2,252,251.2S503.2,390,503.2,251.6-->
<!--	C503.2,238,492.8,227.6,479.2,227.6z"></path>-->
<!--	<path style="fill: #009ef7;" d="M336.8,139.6c0,13.6,10.4,24,24,24h124.8c-34.4-80-115.2-140-210.4-140-->
<!--	c-124.8,0-226.4,101.6-226.4,227.2S150.4,478,276,478s227.2-101.6,227.2-227.2c0-1.6,0-4,0-5.6c-3.2-10.4-12-17.6-23.2-17.6-->
<!--	c-13.6,0-24,10.4-24,24c-0.8,112-92,203.2-204,203.2S48.8,363.6,48.8,251.6S140,47.6,252,47.6c58.4,0,113.6,28,152,68h-43.2-->
<!--	C347.2,115.6,336.8,126,336.8,139.6z"></path>-->

<!--</svg>-->
<!--                        </span>-->
<!--                      Update From Csv-->

<!--                    </button>-->



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

            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 table-responsive">
            {{-- <div class="card-title mb-3 mb-sm-0">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute">
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
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search PF" />
                </div>
                <!--end::Search-->
            </div> --}}

            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_coupons">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
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
                        <th class="min-w-50px">Original Price</th>
                        <th class="min-w-50px">QTY</th>
                        <th class="min-w-50px">Shipping</th>
                        <th class="min-w-50px">Handling</th>
                        <th class="min-w-50px">Gross Price</th>
                        <th class="min-w-50px">Profit</th>
                        <th class="min-w-50px">Sale Price</th>

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
                            url: "<?= route('pf.datatableapi') ?>",
                            data: {
                                found: 1,
                                warehouse_name:segment1,
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
                            // {
                            //     data: 'vendor',
                            //     name: 'vendor',
                            //     orderable: true,

                            // },
                            {
                                data: 'ksku',
                                name: 'ksku',
                                orderable: true,

                            },
                            // {
                            //     data: 'part_no',
                            //     name: 'part_no',
                            //     orderable: true,

                            // },

                            //  {
                            //     data: 'location_inventory_id_check',
                            //     name: 'location_inventory_id_check',
                            //     orderable: true,

                            // },
                            {
                                data: 'kcost',
                                name: 'kcost',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'koriginal_price',
                                name: 'koriginal_price',
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
                            //     data: 'eqty',
                            //     name: 'eqty',
                            //     orderable: true,
                            //     searchable: false
                            // },


                            {
                                data: 'kshipping',
                                name: 'kshipping',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'khandling',
                                name: 'khandling',
                                orderable: true,
                                searchable: false
                            },
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
                                data: 'total',
                                name: 'total',
                                orderable: true,
                                searchable: false
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

                // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
                // var handleSearchDatatable = () => {
                //     const filterSearch = document.querySelector(
                //         '[data-kt-user-table-filter="search"]'
                //     )
                //     filterSearch.addEventListener('keyup', function(e) {
                //         datatable.search(e.target.value).draw()
                //     })
                // }


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
                                                url: "<?= route('pf.bulkdelete') ?>",
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
                                            url: "<?= route('pf.bulkdelete') ?>",
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
                        // handleResetForm()
                        handleDeleteRows()
                        // handleFilterDatatable()
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
    url: "{{ route('pf.get_pf_inventory') }}",
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
            var partDiv = '<div class="fv-row mb-7 " id="input_'+ (index + 1) + '">' +
                '<label class="required fw-bold fs-6 mb-2">Part Number ' + (index + 1) + '</label>' +
                '<input required type="text" name="parts[' + (index + 1) + ']" class="form-control form-control-solid mb-3 mb-lg-0" value="' + part.part_no + '" placeholder="Type..." />' +
                '<button type="button" class="btn btn-danger remove-input" data-index="' + (index + 1) + '">Remove</button>' +
                '</div>';

            // Append the part div to the container
            $('#dynamic-parts-container').append(partDiv);
        });
        $('#kit_id').val(data.pf_kit);
    }
});
            }

            $(document).ready(function() {
                var segment = window.location.pathname.split('/')[1];
                $('.warehouse_name').val(segment);
    var currentIndex = 1; // Initial index

    // Function to add a new input field
    function addInputField() {
    currentIndex++; // Increment index

    // Get the number of existing input fields
    var numInputs = $('[id^="input_"]').length;

    // Calculate the correct index based on the number of existing input fields
    var newIndex = numInputs + 1;

    var partDiv = '<div class="fv-row mb-7 input_' + newIndex + '" id="input_' + newIndex + '">' +
        '<label class="required fw-bold fs-6 mb-2">Part Number ' + newIndex + '</label>' +
        '<input required type="text" name="parts[' + newIndex + ']" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Type...">' +
        '<button type="button" class="btn btn-danger remove-input" data-index="' + newIndex + '">Remove</button>' +
        '</div>';

    // Append the part div to the container
    $('#dynamic-parts-container').append(partDiv);
}

function addInputFieldInItem() {
    // Increment index
    currentIndex++;

    // Generate the new SKU index
    var newIndex = currentIndex;

    var partDiv = `<div class="row mt-3">
                        <div class="col-6">
                            <label class="fw-bold fs-6 mb-2">SKU ${newIndex}</label>
                        </div>
                        <div class="col-6">
                            <input type="text" name="sku[${newIndex}]"
                                class="required form-control form-control-solid" placeholder="Enter SKU ${newIndex}"  required>
                        </div>
                    </div>`;

    // Append the part div to the container
    $('#single-item-container').append(partDiv);
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

    $('#add-input-sku').click(function() {
        addInputFieldInItem();
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
            url:"{{route('pf.insert-csv')}}",
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

         $('#kt_modal_single_data_form').on('submit', function(event){

        event.preventDefault();
        temp=this;
        $(this).find('button[type=submit')[0].setAttribute('data-kt-indicator', 'on');
        $(this).find('button[type=submit')[0].disabled = true;

        $.ajax({
            url:"{{route('pf.insert-csv')}}",
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
