<x-base-layout>
<div class="card ">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            Total Products: {{ \App\Models\Unity::count() }}<br>
            Updated at: {{ \Carbon\Carbon::parse(\App\Models\Unity::latest('updated_at')->value('updated_at'))->timezone('Asia/Karachi')->format('d-m-Y h:ia') }}
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

            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 table-responsive">
              <div class="card-toolbar ">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end button-area tables-buttons" style="display: none !important;" data-kt-user-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3"   data-kt-menu-trigger="click"
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
               <?php
                    $file_name = '';
                    $file_time = '';
                             $files = scandir('./cron/unity/');
                             foreach($files as $file){
                                if (isset(explode('.',$file)[1]) && explode('.',$file)[1] == 'csv'){
                                   $file_name = $file;
                                   $file_time = filemtime('./cron/unity/'.$file_name);
                                   break;
                                }
                             }
                         ?>

                         @if (strlen($file_time) > 0)
                    <a type="button" href="{{ route('download',['name'=>$file_name]) }}" class="btn btn-primary me-3" >
                         <?= $file_name.'<br>' ?>
                         <?= Carbon\Carbon::parse($file_time)->diffForHumans() ?>
                    </a>
                    @endif

                    @php
                    $cmd = shell_exec('ps -ef|grep php');

                    @endphp

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
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_coupons">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-center text-muted fw-bolder fs-7 text-uppercase gs-0">

                        <th class="min-w-50px" style="text-align: center !important;">Part NO</th>
                        <th class="min-w-50px" style="text-align: center !important;">QOC</th>
                        <th class="min-w-50px" style="text-align: center !important;">Cost</th>


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
           <link rel="preload" href="/demo6/plugins/custom/datatables/datatables.bundle.css" as="style" onload="this.onload=null;this.rel='stylesheet'" type="text/css"><noscript><link rel="stylesheet" href="/public/demo6/plugins/custom/datatables/datatables.bundle.css"></noscript>

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
                            url: "<?= route('unityinventory.datatableapi') ?>",
                            data: {
                                found: 1,
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
                                data: 'part_number',
                                name: 'part_number',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'qoc',
                                name: 'qoc',
                                orderable: true,
                                searchable: true,

                            },
                            {
                                data: 'cost',
                                name: 'cost',
                                orderable: true,
                                searchable: true
                            },


                        ],
                        columnDefs: [
                            {
                                className: 'text-center', // Add class 'text-center' to all columns
                                targets: '_all' // Apply to all columns
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
