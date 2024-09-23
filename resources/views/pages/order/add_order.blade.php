       @php



$r =  DB::table('inventory_prices')->where('vendor',1)->get() ;


@endphp
                   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_new_order">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                            </svg>
                        </span>
                        Add New Order
                    </button>

                     <div class="modal fade" id="kt_modal_add_new_order" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-850px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Add New Order</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_new_order">
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
                                    <!--begin::Form-->
                                    <form id="kt_modal_add_new_order_form" action="{{ route('inventoryprice.store') }}" enctype="multipart/form-data"
                                        class="form" method="post">
                                        <input type="hidden" value="" id="echStore2" name="store">
                                        <!--begin::Scroll-->
                                        @csrf
                                        <div class="d-flex flex-column scroll-y"
                                            id="kt_modal_add_credits_scroll" data-kt-scroll="true"
                                            data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_credits_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_credits_scroll"
                                            data-kt-scroll-offset="300px">
                                         <div class="row  mb-3 " >
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Po Number</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input required type="text" name="poNumber"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="PO Number"  />

                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input required type="text" name="shippingName"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Shipping Name"  />

                                                <!--end::Input-->
                                            </div>
                                          </div>
                                           <div class="row  mb-3 " >
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Address 1</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input required type="text" name="shippingAddress1"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Address 1"  />

                                                <!--end::Input-->
                                            </div>
                                             <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">Shipping Address 2</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input  type="text" name="shippingAddress2"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Address 2"  />

                                                <!--end::Input-->
                                            </div>
                                            </div>
                                            <div class="row  mb-3 " >
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Postal Code</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input required type="text" name="shippingPostalCode"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Postal Code"  />

                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping City</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input required type="text" name="shippingCity"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Shipping City"  />

                                                <!--end::Input-->
                                            </div>
                                            </div>
                                            <div class="row  mb-3 " >
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Country</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input required type="text" name="shippingCountry"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Shipping Country"  />

                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Region</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input required type="text" name="shippingRegion"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Shipping Region"  />

                                                <!--end::Input-->
                                            </div>
                                            </div>
                                            <div class="row  mb-3 " >
                                             <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class="required fw-bold fs-6 mb-2">Shipping Method</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input required type="text" value="REG" name="shippingMethod"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                      />

                                                <!--end::Input-->
                                            </div>
                                             <div class="fv-row mb-2 col  ">
                                                <!--begin::Label-->
                                                <label class=" fw-bold fs-6 mb-2">Client Segment (Optional)</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input  type="text" name="clientSegment"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Any Message..."  />

                                                <!--end::Input-->
                                            </div>
                                            </div>
                                            <!--end::Input group-->

                                             <hr></hr>

                                            <table class="new_order_item_table">
                                              <thead>
                                                <tr>

                                                  <th scope="col">SKU</th>
                                                  <th scope="col">Brand</th>
                                                  <th scope="col">Quantity</th>
                                                  <th scope="col">Action</th>
                                                </tr>
                                              </thead>
                                                <tbody>

                                                </tbody>
                                            </table>

                                            <hr></hr>

                                            <div class="row" >

                                                <!--<div class="col" >-->
                                                <!--    <select class="form-control form-select"  name="item">-->
                                                <!--          @foreach(array() as $item)-->
                                                <!--          <option value="{{ $item->sku }},{{ $item->qty }}">{{ $item->sku }}</option>-->
                                                <!--          @endforeach-->

                                                <!--    </select>-->
                                                <!--</div>-->
                                                <div class="col" >
                                                <button class="btn btn-primary" type="button" onclick="add_item()"   >Add item row</button>
                                                </div>

                                            </div>


                                            <!--begin::Input group-->






                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_add_new_order">Discard</button>
                                            <button type="submit" class="btn btn-primary" id="kt_docs_formvalidation_text_submit"
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


