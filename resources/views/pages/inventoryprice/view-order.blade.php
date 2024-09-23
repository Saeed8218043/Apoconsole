
<x-base-layout>

 <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Container-->
                        <div class="container-xxl" id="kt_content_container">
                            <!--begin::Layout-->
                            <div class="d-flex flex-column flex-lg-row">
                                <!--begin::Content-->
                                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                                    <!--begin::Form-->
                                   

                                    @if ($errors->any())
                                      <div class="alert alert-danger">
                                              <ul>
                                         @foreach ($errors->all() as $error)
                                             <li>{{ $error }}</li>
                                          @endforeach
                                                </ul>
                                      </div>
                                    @endif

                                    <form class="form buy_domain_form" method="POST" id="kt_subscriptions_create_new">
                                        @csrf 
                                        @method('put')
                                        <!--begin::Pricing-->
                                        <div class="card card-flush pt-3 mb-5 mb-lg-10">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <h2 class="fw-bolder">Products</h2>
                                                </div>
                                                <!--begin::Card title-->
                                                <!--begin::Card toolbar-->
                                               <!--  <div class="card-toolbar">
                                                    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_product">Add Product</button>
                                                </div> -->
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Table wrapper-->
                                                <div class="table-responsive">
                                                    <!--begin::Table-->
                                                    <table class="table align-middle table-row-dashed fs-6 fw-bold gy-4" id="kt_subscription_products_table">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                                <th class="min-w-100px">Domain Name</th>
                                                                <th class="min-w-100px">Niche</th>
                                                               <!--  <th class="min-w-100px">Language</th>
                                                                <th class="min-w-100px">DR</th>
                                                                <th class="min-w-100px">DA</th>
                                                                <th class="min-w-100px">Niche</th> -->
                                                                
                                                                <th class="min-w-100px">Price</th>
                                                                <th class="min-w-100px ">Site Credit</th>
                                                            </tr>
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody class="text-gray-600">
                                                            <tr>
                                                                @if (auth()->user()->id == $order->seller_id) 
                                                                <td>{{ $data->url }}</td>
                                                                @else 
                                                                <td>{{ preg_replace("/(?!^).(?!$)/", "*", $data->url) }}</td>
                                                                @endif
                                                                <td>{{ $data->get_niche() }}</td>
                                                                
                                                                <td>$ {{ number_format($data->price,2) }}</td>
                                                                <td>Cr {{ number_format($data->credits,2) }}</td>
                                                                
                                                            </tr>
                                                            
                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>
                                                    <!--end::Table-->
                                                </div>
                                                <!--end::Table wrapper-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Pricing-->
                                       
                                        <!--begin::Card-->
                                        <div class="card card-flush pt-3 mb-5 mb-lg-10">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <h2 class="fw-bolder">Advanced Options</h2>
                                                </div>
                                                <!--begin::Card title-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Custom fields-->
                                                <div class="d-flex flex-column mb-15 fv-row">
                                                   
                                                    <!--begin::Table wrapper-->
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table id="kt_create_new_custom_fields" class="table align-middle table-row-dashed fw-bold fs-6 gy-5">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="pt-0">POST's LINKS</th>
                                                                    <th class="pt-0">FOREIGN ARTICLE TITLE</th>
                                                                </tr>
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <input  type="text" class="form-control form-control-solid" name="url" value="{{ $order->url }}" disabled  />
                                                                    </td>
                                                                    <td>
                                                                        <input  type="text" class="form-control form-control-solid" name="title"  placeholder="Foreign article title" value="{{ $order->title }}" disabled  />
                                                                    </td>
                                                                </tr>
                                                                 <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="pt-0">LINK ANCHOR TEXT</th>
                                                                    <th class="pt-0">FOREIGN ARTICLE TITLE</th>
                                                                </tr>
                                                                  <tr>
                                                                    <td>
                                                                        <input required type="text" class="form-control form-control-solid" name="text" placeholder="Anchor text" value="{{ $order->text }}" disabled />
                                                                    </td>
                                                                    <td>
                                                                        <select required name="ftitle" class="form-select form-select-solid"
                                                                            data-control="select2" data-hide-search="true"
                                                                              data-placeholder="Select Traffic">
                                                                           <!-- <option  value="">Select content length</option> -->
                                                                          @if (($order->ftitle == 1)) <option value="1"  >500 words </option> @endif
                                                                          @if (($order->ftitle == 2)) <option value="2"  >750 words </option> @endif
                                                                          @if (($order->ftitle == 3)) <option value="3"  >1000 words </option> @endif
                                                                          @if (($order->ftitle == 5)) <option value="5"  >1500 words </option> @endif
                                                                          @if (($order->ftitle == 4)) <option value="4"  >2000 words </option> @endif                                  
                                                                         </select>
                                                                    </td>
                                                                </tr>
                                                                 <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="pt-0">AUTHORITY LINKS</th>
                                                                    <th class="pt-0">DRIP FEED LINKS</th>
                                                                </tr>
                                                                 <tr>
                                                                    <td>
                                                                        <input required  class="form-check-input" type="checkbox" name="alink" checked disabled />
                                                        <span class="form-check-label text-gray-600"><small>Are you providing the Links for your content?</small></span>
                                                                       
                                                                    </td>
                                                                    <td>
                                                                     
                                                         @if ($order->ftitle == 1) <div>  <input required checked class="form-check-input" type="radio" name="dfl" value="1" /> <span class="form-check-label text-gray-600">1-5 days</span> </div><br>@endif

                                                          @if ($order->ftitle == 2) <div> <input required checked  class="form-check-input" type="radio" name="dfl" value="2" /><span class="form-check-label text-gray-600">6-10 days</span></div><br>@endif
                                                        
                                                       @if ($order->ftitle == 3) <div>  <input required checked  class="form-check-input" type="radio" name="dfl" value="3" />
                                                        <span class="form-check-label text-gray-600">6-10 days</span></div>
                                                        <br>@endif
                                                        

                                                       @if ($order->ftitle == 4) <div>  <input required checked  class="form-check-input" type="radio" name="dfl" value="4" />
                                                        <span class="form-check-label text-gray-600">11-15 days</span></div>
                                                        <br>@endif


                                                       @if ($order->ftitle == 5) <div>  <input required checked  class="form-check-input" type="radio" name="dfl" value="5" />
                                                        <span class="form-check-label text-gray-600">None</span></div> @endif

                                                                    </td>
                                                                   
                                                                </tr>
                                                            </tbody>
                                                          
                                                        </table>
                                                        <!--end:Table-->
                                                        
                                                        
                                                        <div class="mb-0">
                                                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#order_accept" >
                                                    <!--begin::Indicator-->
                                                    <span  class="indicator-label">Accept</span>
                                                    
                                                </button>
                                                <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#reject_accept" >
                                                    <!--begin::Indicator-->
                                                    <span  class="indicator-label">Reject</span>
                                                    
                                                </button>
                                            </div>
                                                       
                                                    </div>
                                                    <!--end::Table wrapper-->
                                                    <!--begin::Add custom field-->
                                                    
                                                    <!--end::Add custom field-->
                                                </div>
                                                <!--end::Custom fields-->
                                                <!--begin::Invoice footer-->
                                               <!--  <div class="d-flex flex-column mb-10 fv-row">
                                                    
                                                    <div class="fs-5 fw-bolder form-label mb-3">REQUESTS
                                                    <i tabindex="0" class="cursor-pointer fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-html="true" data-bs-content="Add an addition invoice footer note."></i></div>
                                                   
                                                    <textarea required class="form-control form-control-solid rounded-3" placeholder="Enter requests..." name="requests" rows="4">{{ $order->requests }}</textarea>
                                                </div> -->
                                                <!--end::Invoice footer-->
                                               
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Content-->
                                <!--begin::Sidebar-->
                                <div class="flex-column flex-lg-row-auto w-100 w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
                                    <!--begin::Card-->
                                    <div class="card card-flush pt-3 mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary" data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <h2>Summary</h2>
                                            </div>
                                            <!--end::Card title-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0 fs-6">
                                            <!--begin::Section-->
                                            <div class="mb-7">
                                                <!--begin::Title-->
                                                <h5 class="mb-3">Customer details</h5>
                                                <!--end::Title-->
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center mb-1">
                                                    <!--begin::Name-->
                                                    <a href="#" class="fw-bold text-gray-600 text-hover-primary">Name: {{ $user->first_name }}</a>
                                                    <!--end::Name-->
                                                    <!--begin::Status-->
                                                    <span class="badge badge-light-success">{{ $user->roles->first()->name }}</span>
                                                    <!--end::Status-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Email-->
                                                <a href="#" class="fw-bold text-gray-600 text-hover-primary">Email: {{ $user->email }}</a>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Section-->
                                            <!--begin::Seperator-->
                                            <div class="separator separator-dashed mb-7"></div>
                                            <!--end::Seperator-->
                                            <!--begin::Section-->
                                            <div class="mb-7">
                                                <!--begin::Title-->
                                                <h5 class="mb-3">Domain details</h5>
                                                <!--end::Title-->
                                                <!--begin::Details-->
                                                <div class="mb-0">
                                                    <!--begin::Plan-->
                                                    <a class="fw-bold text-gray-600 text-hover-primary">Domain: {{ $data->url }}</a>
                                                    <a class="fw-bold text-gray-600 text-hover-primary">Niche: {{ $data->get_niche() }}</a>
                                                    <br>
                                                    <span class="badge badge-light-info me-2">Credits: {{ $data->credits }}</span>
                                                    <!--end::Plan-->
                                                    <!--begin::Price-->
                                                    <span class="fw-bold text-gray-600">Price: {{ number_format($data->price,2) }}</span>
                                                    <!--end::Price-->
                                                </div>
                                                <!--end::Details-->
                                            </div>
                                            <!--end::Section-->
                                            <!--begin::Seperator-->
                                            <div class="separator separator-dashed mb-7"></div>
                                            <!--end::Seperator-->
                                            <!--begin::Section-->
                                             @if ($user->is_affiliated())
                                            <!-- <div class="mb-10">
                                                
                                                <h5 class="mb-3">Payment Details</h5>
                                                
                                                <div class="mb-0">
                                                    
                                                    <div class="fw-bold text-gray-600 d-flex align-items-center">Credits Required: {{ number_format($data->credits,2) }}
                                                    <img src="assets/media/svg/card-logos/mastercard.svg" class="w-35px ms-2" alt="" /></div>
                                                   
                                                    <div class="fw-bold text-gray-600">Your Credits: {{ number_format($user->get_credits(),2) }}</div>
                                                    
                                                </div>
                                                
                                            </div> -->
                                            @endif
                                            
                                             @if ($user->is_nonaffiliated())
                                           <!--  <div class="mb-10">
                                               
                                                <h5 class="mb-3">Payment Details</h5>
                                                
                                                <div class="mb-0">
                                                    
                                                    <div class="fw-bold text-gray-600 d-flex align-items-center">Domain Price: {{ number_format($data->price,2) }}
                                                    <img src="assets/media/svg/card-logos/mastercard.svg" class="w-35px ms-2" alt="" /></div>
                                                    
                                                    <div class="fw-bold text-gray-600">Your Current balance: {{ number_format($user->get_balance(),2) }}</div>
                                                    
                                                </div>
                                                
                                            </div> -->
                                            @endif
                                            <!--end::Section-->
                                            <!--begin::Actions-->
                                           
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <!--end::Sidebar-->
                            </div>
                            <!--end::Layout-->
                            <!--begin::Modals-->
                            <!--begin::Modal - Users Search-->
                           
                            <!--end::Modal - Users Search-->
                            <!--begin::Modal - New Product-->
                          
                            <!--end::Modal - New Product-->
                            <!--begin::Modal - New Card-->
                            <div class="modal fade" id="order_accept" tabindex="-1" aria-hidden="true">
                                            <!--begin::Modal dialog-->
                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                <!--begin::Modal content-->
                                                <div class="modal-content">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header">
                                                        <!--begin::Modal title-->
                                                        <h2 class="fw-bolder">Accept Order</h2>
                                                        <!--end::Modal title-->
                                                        <!--begin::Close-->
                                                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
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
                                                         <form id="kt_modal_export_users_form" class="form" method="post">
                                            @csrf
                                            @method('put')
                                                        <div class="card-body pt-0">
                                                <!--begin::Table wrapper-->
                                                <div class="table-responsive">
                                                    <!--begin::Table-->
                                                    <table class="table align-middle table-row-dashed fs-6 fw-bold gy-4" id="kt_subscription_products_table">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                                <th class="min-w-100px"></th>
                                                                <th class="min-w-100px"></th>
                                                               
                                                            </tr>
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody class="text-gray-600">
                                                            <tr>
                                                              
                                                                <td>Domain Price:</td> 
                                                                <td>$ {{ number_format($data->price,2) }}</td>
                                                                
                                                                
                                                            </tr>

                                                            <tr>
                                                              
                                                                <td>Admin Commision:</td> 
                                                                <td> 10%</td>
                                                                
                                                                
                                                            </tr>

                                                            <tr>
                                                              
                                                                <td>You Will Get:</td> 
                                                                <td>$ {{ number_format(($data->price*.90),2) }}</td>
                                                                
                                                                
                                                            </tr>

                                                            <tr>
                                                              
                                                                <td>Delivery Time:</td> 
                                                                <td><input required type="date" class="form-control form-control-solid" name="delivery"></td>
                                                                
                                                                
                                                            </tr>
                                                            
                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>
                                                    <!--end::Table-->
                                                </div>
                                                <!--end::Table wrapper-->
                                            </div>

                                                            <!--begin::Input group-->
                                                           <input type="hidden" name="action" value="accept">
                                                            <div class="text-center">
                                                                
                                                                <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                                    <span class="indicator-label">Submit</span>
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
                            <!--end::Modal - New Card-->






                            <div class="modal fade" id="reject_accept" tabindex="-1" aria-hidden="true">
                                            <!--begin::Modal dialog-->
                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                <!--begin::Modal content-->
                                                <div class="modal-content">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header">
                                                        <!--begin::Modal title-->
                                                        <h2 class="fw-bolder">Reject Order</h2>
                                                        <!--end::Modal title-->
                                                        <!--begin::Close-->
                                                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
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
                                                        
                                                        <div class="card-body pt-0">
                                                <!--begin::Table wrapper-->
                                                
                                                <!--end::Table wrapper-->
                                            </div>
                                            <form id="kt_modal_export_users_form" class="form" method="post">
                                            @csrf
                                            @method('put')
                                                            <!--begin::Input group-->
                                                           <input type="hidden" name="action" value="reject">
                                                            <div class="fv-row mb-7">
                    <!--begin::Label-->
                                                              <label class="required fs-6 fw-bold mb-2">Reason</label>
                                                          <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Reason for Rejection"></i>
                    <!--end::Label-->
                    <!--begin::Input-->
                                                         <select type="url" required onchange="if (this.value == 'Other') { $('#other-reason').show(); } else { $('#other-reason').hide(); } " class="form-select form-select-solid form-select-lg" placeholder="domain url" name="reason" value="{{ old('url') }}" >
                                           <option value="Domain is no more available" >Domain is no more available</option>
                                           <option value="Fake post links" >Fake post links</option>
                                           <option value="Fake Buyer" >Fake Buyer</option>
                                           <option value="Other" >Other</option>                                           
                                                            </select>

                                                            </div>
                                                            <div class="fv-row mb-7 " id="other-reason" style="display: none;" >
                    <!--begin::Label-->
                                                              <label class="required fs-6 fw-bold mb-2">Describer here</label>
                                                          <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Reason for Rejection"></i>
                    <!--end::Label-->
                    <!--begin::Input-->
                                                        <input type="text"  class="form-control form-control-solid" placeholder="describer here" name="custom_reson" />
                    <!--end::Input-->
                                                            
                                                            </div>
                                                            <div class="text-center">
                                                                
                                                                <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                                    <span class="indicator-label">Submit</span>
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
                            <!--end::Modals-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Content-->
 
 
 
 </x-base-layout>
 