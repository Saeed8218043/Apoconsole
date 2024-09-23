<x-base-layout>
<div class="card ">
        <!--begin::Card header-->
        <style>



        </style>
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <h6>
                Total Products: {{ \App\Models\InventoryPrice::count() }}<br>
                Updated at: {{ \Carbon\Carbon::parse(\App\Models\InventoryPrice::latest('updated_at')->value('updated_at'))->timezone('Asia/Karachi')->format('d-m-Y h:ia') }}
            </h6>

            <div class="card-title" style="display: none;" >
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
                <div class="d-flex justify-content-end button-area tables-buttons" style="display: none !important;" data-kt-user-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-1 m-3"   data-kt-menu-trigger="click"
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

                                <select class="form-select form-select-solid fw-bolder" data-kt-select2="true" data-hide-search="true" data-allow-clear="true" name="mapped" id="mapped">
                                    <option value="2">All</button>
                                    <option value="0"> Mapped</button>
                                    <option value="1"> unmapped</button>
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
                    <a type="button" href="{{ route('updateCsvWithSalePrice') }}" class="m-3 btn btn-primary" >
                        Percentaged csv
                    </a>
                    <?php
                    $file_name = '';
                    $file_time = '';
                             $files = scandir('./cron/trq_inventory');
                             foreach($files as $file){
                                if (isset(explode('.',$file)[1]) && explode('.',$file)[1] == 'csv'){
                                   $file_name = $file;
                                   $file_time = filemtime('./cron/trq_inventory/'.$file_name);
                                   break;
                                }
                             }
                         ?>

                         @if (strlen($file_time) > 0)
                    <a type="button" href="{{ route('download',['name'=>$file_name]) }}" class="m-3 btn btn-primary" >
                         <?= $file_name.'<br>' ?>
                         <?= Carbon\Carbon::parse($file_time)->diffForHumans() ?>
                    </a>
                    @endif



                    <?php
                    $file_name = '';
                    $file_time = '';
                             $files = scandir('./cron/Tracking');
                             foreach($files as $file){
                                if (isset(explode('.',$file)[1]) && explode('.',$file)[1] == 'csv'){
                                   $file_name = $file;
                                   $file_time = filemtime('./cron/Tracking/'.$file_name);
                                   break;
                                }
                             }
                         ?>

                         @if (strlen($file_time) > 0)
                    <a type="button" href="{{ route('downloadtrack',['name'=>$file_name]) }}" class=" m-2 btn btn-primary" >
                         <?= $file_name.'<br>' ?>
                         <?= Carbon\Carbon::parse($file_time)->diffForHumans() ?>
                    </a>
                    @endif

                    {{ theme()->getView('pages/inventoryprice/check_stock',['users'=>$users]) }}
                    {{ theme()->getView('pages/inventoryprice/add_csv',['users'=>$users]) }}


                    {{ theme()->getView('pages/inventoryprice/add_niches',['users'=>$users, 'vendor'=>$vendor]) }}


                    {{ theme()->getView('pages/inventoryprice/edit_niches') }}



                    <!--begin::Export-->
                    <button type="button" class="btn btn-light-primary me-3"  style="display: none;"  data-bs-toggle="modal"
                        data-bs-target="#kt_modal_export_users">
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
                        Export
                    </button>
                    <!--end::Export-->


                    @php
                    $cmd = shell_exec('ps -ef|grep php');

                    @endphp

                     <!-- <button type="button" onclick="sync_all_prices(this)" class="btn btn-light-primary me-3"   @if (strpos($cmd, 'sync_all_products.php') !== false || strpos($cmd, 'cron_job__sync_price_quantity_with_Shopify.php') !== false) disabled @endif >
                        <span class="svg-icon svg-icon-2">
                           <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 503.2 503.2" style="enable-background:new 0 0 503.2 503.2;" xml:space="preserve">
	<path style="fill: #009ef7;" d="M479.2,227.6c-13.6,0-24,10.4-24,24c0,112-91.2,203.2-203.2,203.2S48.8,363.6,48.8,251.6
	S140,47.6,252,47.6c58.4,0,113.6,28,152,68h-43.2c-13.6,0-24,10.4-24,24s10.4,24,24,24H484v-124c0-13.6-10.4-24-24-24
	s-24,10.4-24,24V82C388,30,321.6,0.4,251.2,0.4C112.8,0.4,0,113.2,0,251.6s113.6,251.2,252,251.2S503.2,390,503.2,251.6
	C503.2,238,492.8,227.6,479.2,227.6z"></path>
	<path style="fill: #009ef7;" d="M336.8,139.6c0,13.6,10.4,24,24,24h124.8c-34.4-80-115.2-140-210.4-140
	c-124.8,0-226.4,101.6-226.4,227.2S150.4,478,276,478s227.2-101.6,227.2-227.2c0-1.6,0-4,0-5.6c-3.2-10.4-12-17.6-23.2-17.6
	c-13.6,0-24,10.4-24,24c-0.8,112-92,203.2-204,203.2S48.8,363.6,48.8,251.6S140,47.6,252,47.6c58.4,0,113.6,28,152,68h-43.2
	C347.2,115.6,336.8,126,336.8,139.6z"></path>

</svg>
                        </span>
                        @if (strpos($cmd, 'sync_all_products.php') !== false || strpos($cmd, 'cron_job__sync_price_quantity_with_Shopify.php') !== false)
                        Syncing....
                        @else
                        Sync All Prices
                        @endif

                    </button> -->



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
            <div style="margin: 20px;width: 200px;">
                <form action="{{route('updateCsvPercentage')}}" method="POST">
                    @csrf
                    <input type="hidden" value="trq" name="warehouse_name">
                    <label for="">Percentage% for csv</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" value="{{$percentage}}" name="percentage" min="0">
                        <div class="input-group-append">
                          <button class="btn btn-secondary" type="submit" style="min-height: -webkit-fill-available;">Save</button>
                        </div>
                      </div>
                </form>
            </div>

            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_coupons">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                    data-kt-check-target="#kt_table_coupons .form-check-input" value="1" />
                            </div>
                        </th>

                        <th class="min-w-50px" style="text-align: center !important;">Vendor</th>
                        <th class="min-w-50px" style="text-align: center !important;">Part No</th>
                        <th class="min-w-50px" style="text-align: center !important;">SKU</th>
                        <th class="min-w-50px" style="text-align: center !important;">Cost</th>
                        <th class="min-w-50px" style="text-align: center !important;">TRQ QTY</th>
                         <th class="min-w-50px" style="text-align: center !important;">EBAY QTY</th>
                        <th class="min-w-50px" style="text-align: center !important;">Fee</th>
                        <th class="min-w-50px" style="text-align: center !important;">Commission</th>
                        <th class="min-w-50px" style="text-align: center !important;">Shipping</th>
                        <th class="min-w-50px" style="text-align: center !important;">Gross Price</th>
                        <th class="min-w-50px" style="text-align: center !important;">mapped</th>
                        <th class="min-w-50px" style="text-align: center !important;">Profit</th>
                        <th class="min-w-50px" style="text-align: center !important;">Net Price</th>
                        <!--<th class="min-w-125px">CREATED AT</th>-->
                        <th class="min-w-125px" style="text-align: center !important;">ACTION</th>

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
                            url: "<?= route('inventoryprice.datatableapi') ?>",
                            data: {
                                found: 1,
                                // ;
                                 //vendor: document.getElementById('vendor_f').value,
                                 mapped: document.getElementById('mapped').value,
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
                                searchable: false,

                            },
                            {
                                data: 'vendor',
                                name: 'vendor',
                                orderable: true,

                            },
                            {
                                data: 'part_no',
                                name: 'part_no',
                                orderable: true,

                            },
                            {
                                data: 'sku',
                                name: 'sku',
                                orderable: true,

                            },
                            {
                                data: 'cost',
                                name: 'cost',
                                orderable: true,
                                searchable: false
                            },
                             {
                                data: 'qty',
                                name: 'qty',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'eqty',
                                name: 'eqty',
                                orderable: true,
                                searchable: false
                            },

                            {
                                data: 'fee',
                                name: 'fee',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'commission',
                                name: 'commission',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'shipping',
                                name: 'shipping',
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
                                data: 'mapped',
                                name: 'mapped',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'profit',
                                name: 'profit',
                                orderable: true,
                                searchable: false
                            },

                            {
                                data: 'total',
                                name: 'total',
                                orderable: true,
                                searchable: false
                            },



                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },


                        ],
                        columnDefs: [
                            {
                                className: 'text-center', // Add class 'text-center' to all columns
                                targets: '_all' // Apply to all columns
                            },
                            {
                                orderable: false,
                                targets: [0, 3] // Disable ordering on column 0 (checkbox) and column 3
                            },
                            {
                            targets: 12, // Replace 13 with the index of the 'profit' column
                                render: function(data, type, row) {
                                    return data.toFixed(2); // Display only two decimal places
                                }
                                },
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
                        // console.log(document.getElementById('role_filter').value);
                        // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                        // datatable.search(filterString).draw()
                        initUserTable();
                        // datatable.setAttribute( 'query', 2 );
                        // datatable.draw()
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
                                                url: "<?= route('inventoryprice.bulkdelete') ?>",
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
                                            url: "<?= route('inventoryprice.bulkdelete') ?>",
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

               $('#kt_modal_edit_coupon_form').find('input[name=pricemasterrule]')[0].checked = parseInt(data['pricemasterrule']);
               $('#kt_modal_edit_coupon_form').find('select[name=vendor]').val(data['vendor_id']);
               $('#kt_modal_edit_coupon_form').find('input[name=part_no]').val(data['sku']);
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

        // Define form element
const form = document.getElementById('kt_modal_add_coupon_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(
    form,
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
const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
submitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (validator) {
        validator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    // Send ajax request
                    axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form))
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
                                        // $('div[data-bs-toggle="modal"]').click();
                                        $('#kt_modal_add_coupon .close').click();
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
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;
                        });

            }
        });
    }
});





// Define form element
const update_form = document.getElementById('kt_modal_edit_coupon_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
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
            url:"{{route('upload-csv')}}",
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
            url:"{{route('insert-csv')}}",
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

});


function sync_all_prices(t){
    $(t).text('Syncing....');

     axios.get('/miniapp_shopify/sync_all_products.php');
}


        </script>

<script>
                    $(document).ready(function(){
                        $('.button-area').attr('style','')
                    })
                </script>




    @endsection


</x-base-layout>
