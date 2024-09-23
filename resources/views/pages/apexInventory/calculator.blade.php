
                   <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#calculator">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->

                        Calculator
                    </button>

                     <div class="modal fade" id="calculator" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">

                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#calculator">
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
                                <div class="modal-body scroll-y mx-3 mx-xl-5 my-3">
                                    <div>
                                        <strong>Total Parts:</strong>  <span id="partCount">0</span>
                                     </div>
                                    <!--begin::Form-->
                                    <form id="kt_modal_add_csv_form" action="{{ route('pf.store') }}" enctype="multipart/form-data"
                                        class="form" method="post">
                                        <!--begin::Scroll-->
                                        @csrf
                                        <div class="d-flex flex-column scroll-y"
                                            id="kt_modal_add_credits_scroll" data-kt-scroll="true"
                                            data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_credits_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_credits_scroll"
                                            data-kt-scroll-offset="300px">
                                            <div class="spinner-border" role="status" id="calculator_loader" style="display: none;">
                                              <span class="sr-only">Loading...</span>
                                            </div>
                                            <table class="calculator_table" >
                                                <thead>
                                                    <tr>
                                                        <th>SKU</th>
                                                        <th>Price</th>
                                                        <th>Shipping</th>
                                                        <th>Handling</th>
                                                        <th>Stock</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                              <tbody>
                                                <tr>
                                                  <td><input type="text" onpaste="pastexls(event)" onchange="calculate_pf()" class="form-control" placeholder="Type Sku..." style="padding: 2px;max-width: 112px;"></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                                                </tr>
                                                <tr>
                                                  <td><input type="text" onpaste="pastexls(event)" onchange="calculate_pf()" class="form-control" placeholder="Type Sku..." style="padding: 2px;max-width: 112px;"></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                                                </tr>
                                                <tr>
                                                  <td><input type="text" onpaste="pastexls(event)" onchange="calculate_pf()" class="form-control" placeholder="Type Sku..." style="padding: 2px;max-width: 112px;"></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                                                </tr>
                                                <tr>
                                                  <td><input type="text" onpaste="pastexls(event)" onchange="calculate_pf()" class="form-control" placeholder="Type Sku..." style="padding: 2px;max-width: 112px;"></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                                                </tr>
                                                <tr>
                                                  <td><input type="text" onpaste="pastexls(event)" onchange="calculate_pf()" class="form-control" placeholder="Type Sku..." style="padding: 2px;max-width: 112px;"></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                                                </tr>




                                              </tbody>
                                              <tfoot>

                                                <tr>
                                                  <td colspan="5" style="text-align: center;" ><button type="button" class="btn btn-sm btn-primary" onclick="add_row()">+ Add Row</button>
                                                    <button type="button" class="btn btn-sm btn-secondary" onclick="clear_filter()">Clear Filter</button></td>
                                                </tr>
                                              </tfoot>
                                            </table>

                                            <style>
                                                .calculator_table td {
                                                    border: 1px solid #cbcbcb;
                                                    padding: 6px;

                                                }
                                                .calculator_table th {
                                                    border: 1px solid #cbcbcb;
                                                    padding: 6px;
                                                    text-align: center;
                                                }
                                            </style>

                                            <script>
                                function pastexls(e) {
                                    console.log(e);
                                            e.preventDefault(); // Prevent the default paste behavior
                                            const text = (e.originalEvent || e).clipboardData.getData('text/plain');
                                            const element = e.target;

                                            // Split the pasted text by both spaces and newlines, filtering out empty strings
                                            const parts = text.split(/\s+/).filter(part => part.trim() !== "");

                                            let currentRow = $(element).closest('tr');
                                            let availableInputs = $('.calculator_table tbody tr input').filter(function() {
                                                return this.value.trim() === ""; // Find empty inputs
                                            });

                                            // Handle the first row where the paste event occurred
                                            if (parts.length > 0) {
                                                $(element).val(parts[0]); // Set the first part in the current input
                                            }

                                            parts.forEach((part, index) => {
                                                if (index < availableInputs.length) {
                                                    // Fill available empty inputs first
                                                    $(availableInputs[index]).val(part);
                                                } else {
                                                    // If no empty inputs are available, create new rows
                                                    currentRow.after(`<tr><td><input type="text" onpaste="pastexls(event)" value="${part}" onchange="calculate_pf()" class="form-control" placeholder="Type Sku..." style="padding: 2px;max-width: 112px;"></td><td></td><td></td><td></td><td></td><td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td></tr>`);
                                                    currentRow = currentRow.next();
                                                }
                                            });

                                            // Update the total count of parts
                                            updatePartCount();

                                            calculate_pf(); // Manually trigger the calculation function after the paste event
                                        }

                                        function updatePartCount() {
                                            // Count all non-empty input fields in the table
                                            let totalParts = $('.calculator_table tbody tr input').filter(function() {
                                                return this.value.trim() !== ""; // Count inputs that are not empty
                                            }).length;

                                            // Update the displayed count
                                            $('#partCount').text(totalParts);
                                        }

                                        function removeRow(button) {
                                            $(button).closest('tr').remove();
                                            calculate_pf();
                                            updatePartCount(); // Recalculate the total parts after a row is removed
                                        }

                                        function calculate_pf() {
                                                $('#calculator_loader').show();

                                                var data = [];
                                                $('.calculator_table input').each(function() {
                                                    data.push($(this).val().trim()); // Collect all part numbers
                                                });

                                                // Remove empty values from the array
                                                var filteredData = data.filter(function(value) {
                                                    console.log(value);
                                                    return value !== '';
                                                });

                                                // Update the part count display
                                                $('#partCount').text(filteredData.length); // Update part count

                                                axios.post('{{ route('calculate_pf') }}', filteredData).then(function(e) {
                                                    if(filteredData.length >0 ){
                                                        $('.calculator_table tbody').html(e.data); // Update table with new data
                                                    }else{
                                                        add_row();
                                                    }
                                                    $('#calculator_loader').hide();
                                                });
                                            }


                                        function add_row() {
                                            $('.calculator_table tbody').prepend(`<tr><td><input type="text" value="" onpaste="pastexls(event)" onchange="calculate_pf()" class="form-control" placeholder="Type Sku..." style="padding: 2px;max-width: 112px;"></td><td></td><td></td><td></td><td></td><td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td></tr>`);
                                        }

                                        function clear_filter() {
                                                // Clear the value of all input fields in the table
                                                $('.calculator_table input').each(function() {
                                                    $(this).val('');
                                                });

                                                // Keep only the first two rows
                                                const rows = $('.calculator_table tbody tr');
                                                    rows.slice().remove(); // Remove all rows after the second one

                                                calculate_pf(); // Recalculate after clearing

                                                // Reset the part count
                                                $('#partCount').text('0');
                                            }

                                            </script>

                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->

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
