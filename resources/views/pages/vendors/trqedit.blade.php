<div class="modal fade" id="edit_profit_sheet" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered custom-large-modal">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_edit_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder" id="order_edit_header"></h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal" data-bs-target="#edit_profit_sheet">
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
                <!--begin::Form-->
                <form id="edit_profit_sheet_form" action="{{ route('edit_profit_sheet') }}" enctype="multipart/form-data" class="form" method="POST">
                    <!--begin::Scroll-->
                    @csrf
                    <div class="d-flex flex-column scroll-y" id="kt_modal_edit_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit_header" data-kt-scroll-wrappers="#kt_modal_edit_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->


                        <hr>
                        </hr>
                        <td scope="col"><input type="hidden" name="name" id="name" class="form-control" value=""></td>
                        <td scope="col"><input type="hidden" name="store" id="store" class="form-control" value=""></td>

                        <table id="csv_data_table">
                            <thead>
                                <tr>
                                    <th scope="col" width="10%">PO number</th>
                                    <th scope="col" width="4%">Sale</th>
                                    <th scope="col" width="4%">Selling fee</th>
                                    <th scope="col" width="4%">Selling fee reversal</th>
                                    <th scope="col" width="4%">Net selling fee</th>
                                    <th scope="col" width="4%">cost</th>
                                    <th scope="col" width="4%">RTN</th>
                                    <th scope="col" width="4%">Net cost</th>
                                    <th scope="col" width="4%">Adjustment fee</th>
                                    <th scope="col" width="4%">shipping fee</th>
                                    <th scope="col" width="4%">shipping reversal</th>
                                    <th scope="col" width="4%">Net shipping fee</th>
                                    <th scope="col" width="4%">Rep./Refund</th>
                                </tr>
                            </thead>
                            <tbody class="csv_data_table">
                                <tr>
                                    <td scope="col"><input type="text" name="po_number" id="po_number" class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="sale_price" id="sale_price"  class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="selling_fee" id="selling_fee"  class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="selling_fee_reversal"  id="selling_fee_reversal" class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="net_selling_fee" id="net_selling_fee"  class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="cost" id="cost" class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="RTN" id="RTN"  class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="net_cost" id="net_cost"  class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="adjustment_fee" id="adjustment_fee" class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="shipping_fee" id="shipping_fee"  class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="shipping_fee_reversal" id="shipping_fee_reversal"  class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="net_shipping_fee" id="net_shipping_fee" class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="refund" id="refund" class="form-control" value=""></td>
                                </tr>
                            </tbody>
                        </table>

                        <br>
                        <br>

                        <table id="result_table">
                            <thead>
                                <tr>
                                    <th scope="col">COGS</th>
                                    <th scope="col">Total cost</th>
                                    <th scope="col">Revenue Passive</th>
                                    <th scope="col">ODR %</th>
                                </tr>
                            </thead>
                            <tbody class="csv_data_table">
                                <tr>
                                    <td scope="col"><input type="text" name="cogs" id="cogs"         class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="total_cost" id="total_cost"   class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="revenue_passive" id="revenue_passive" class="form-control" value=""></td>
                                    <td scope="col"><input type="text" name="odr" id="odr" class="form-control" value=""></td>
                                </tr>
                            </tbody>
                        </table>
                        <style>
                            .custom-large-modal {
                                max-width: 1700px; /* Adjust the max-width as needed */
                            }

                            #csv_data_table th,#edit_table th {
                                border: 0.5px solid #bbb5b5 !important;
                                padding: 5px;
                                text-align: center;
                            }

                            .csv_data_table td, .edit_table td{
                                border: 0.5px solid #bbb5b5 !important;
                                padding: 5px;
                                text-align: center;
                            }

                        </style>


                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal" data-bs-target="#edit_profit_sheet">Discard</button>
                       <button type="submit" class="btn btn-primary" id="kt_docs_updte_formvalidation_text_submit"
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
                <div class="error-message" style="height: 42px;text-align: center;color: red;margin-top: 18px;"></div>
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
