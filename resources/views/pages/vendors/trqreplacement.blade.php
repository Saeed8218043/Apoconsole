


                     <div class="modal fade" id="trqreplacement" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-750px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_add_credits_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder" id="order_detail_header" >RMA</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary close" data-bs-toggle="modal"
                                        data-bs-target="#trqreplacement">
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
                                <div class="modal-body  mx-5 mx-xl-15 my-7">
                                    <!--begin::Form-->
                                    <form id="kt_modal_detail_coupon_form"  enctype="multipart/form-data"
                                        class="form" method="post">
                                        <!--begin::Scroll-->
                                        @csrf

                                        <div class="d-flex flex-column  me-n7 pe-7"
                                           >

                                            <!--begin::Input group-->


                                            <table id="item_table"  >
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Sku</th>
      <th scope="col">Title</th>
      <th scope="col">Quantity</th>
       <th scope="col">Weight</th>
        <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody class="trqreplacementitem_table" >

  </tbody>
</table>
<hr></hr>


                                            <div class="mb-3">
                                            <label  class="form-label">ID</label>
                                            <input readonly type="text" name="id"  class="form-control"  >

                                          </div>
                                          <div class="mb-3">
                                            <label  class="form-label">PO</label>
                                            <input readonly type="text" name="po"  class="form-control" >
                                          </div>




                                           <div class="mb-3">
                                            <label  class="form-label">Unique ID For RMA</label>
                                            <input  type="text" name="uniqueId"  class="form-control"  >

                                          </div>

                                           <div class="mb-3">
                                            <label  class="form-label">Reason</label>
                                            <select  type="text" name="reason"  class="form-control form-select" >
                                                <option value="90" >Damaged by carriers</option>
                                                <option value="92" >Missing package no delivery</option>
                                                <option value="103" >IPR picking error</option>
                                                <option value="60" >Defective items within 60 days</option>


                                                </select>
                                          </div>

                                          <input type="hidden" name="operation" value="replacement">

                                            <div class="mb-3 text-center p-5">
                                                <button type="button" class="btn btn-primary" onclick="submitreplacement($(this).closest('form')[0])" >Submit</button>
                                          </div>


<div class="row" >
    <div class="col-8" ></div>
    <div class="col-4" >
        <table  style="width: 100%;">


</table>
    </div>
</div>



<style>
    #item_table th{
        border: 0.5px solid #bbb5b5 !important;
    padding: 5px;
    text-align: center;
    }
    .trqreplacementitem_table td{
        border: 0.5px solid #bbb5b5 !important;
    padding: 5px;
    text-align: center;
    }
    #table_total td{
       border: 0.5px solid #bbb5b5 !important;
    padding: 5px;
    text-align: center;
    }
</style>





                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <!--<button type="reset" class="btn btn-light me-3" data-bs-toggle="modal"-->
                                            <!--    data-bs-target="#kt_modal_detail_coupon">Discard</button>-->

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


