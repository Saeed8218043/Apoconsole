
<x-base-layout>
<style>
    .apexcharts-tooltip {
    transform: translateY(-100%) !important; /* Move tooltip above cursor */
}
.apexcharts-tooltip-custom {
    background: #fff; /* Customize tooltip background color */
    color: #000; /* Customize tooltip text color */
    padding: 5px;
    border-radius: 3px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

</style>
  @if  (auth()->user()->can('dashboard'))

    <div class="p-6">
        <div class="d-flex align-items-start gap-10 flex-column flex-sm-row">
            <div class="d-flex align-items-center gap-3">
                <figure class="m-0 symbol symbol-30px">
                    <!-- <i class="bi bi-clock"></i> -->
                    <img src="{{ asset(theme()->getMediaUrlPath() . 'icons/us.svg') }}" alt="image" class="img-fluid rounded-circle" style="width: 30px; height: 30px; object-fit: cover;"/>
                </figure>
                <div class="" id="EST">
                    <div class="text-gray fs-8">US Eastern Time</div>
                    <span class="text-dark fs-3 fw-bolder">4/21/2024, 2:37:27 AM</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <figure class="m-0 symbol symbol-30px">
                    <!-- <i class="bi bi-clock"></i> -->
                    <img src="{{ asset(theme()->getMediaUrlPath() . 'icons/pak.svg') }}" alt="image" class="img-fluid rounded-circle" style="width: 30px; height: 30px; object-fit: cover;"/>
                </figure>
                <div class="" id="PST">
                    <div class="text-gray fs-8">Pakistan Standard Time: </div>
                    <span class="text-dark fs-3 fw-bolder">4/21/2024, 2:37:27 AM</span>
                </div>
            </div>
        </div>
    </div>

    <!--begin::Row-->
    <div class="row">
        <!--begin::Col-->
        <div class="col-12">
            @php
            $class = 'card-xxl-stretch';
            $chartColor = 'danger';
            $chartHeight = '200px';

            @endphp


            <div class="card {{ $class }}">

                <!--begin::Body-->
                <div class="card-body">



                    <script>

                        setInterval(function(){
                            let str = new Date().toLocaleString('en-US', { timeZone: 'America/Indiana/Indianapolis' });
                            str = str.split(' ');
                            // str[0] += '';
                            document.querySelector('#EST span').innerText = str.join(' ');


                            let pst = new Date().toLocaleString('en-US', { timeZone: 'Asia/Karachi' });
                            pst = pst.split(' ');
                            // pst[0] += '';
                            document.querySelector('#PST span').innerText = pst.join(' ');
                        },1000);

                    </script>


                    <!--begin::Stats-->
                    <div class="">
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <a href="{{route('order.index') }}" class="card hoverable card-xl-stretch mb-xl-8 bg-white border shadow-sm rounded-3 mb-4">

                                    <div class="card-body status p-4">
                                        <div class="d-flex mb-6 align-items-center gap-2">
                                            <figure class="mb-0 card_icon_one">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="-3 -2 24 24"><path fill="currentColor" d="M12.338 2.395a.228.228 0 0 1 .032.027l1.18 1.171l1.6.12c.073.006.16.061.174.161l2.172 14.693l-6.148 1.33L0 17.771S1.456 6.509 1.511 6.11c.073-.524.091-.541.648-.716l1.796-.557C4.339 3.208 5.565 0 8.13 0c.335 0 .723.18 1.037.594L9.26.591c1.101 0 1.727.939 2.082 1.96l.595-.184c.08-.024.278-.056.4.028zM9.261 7.11s-.513-.297-1.55-.297c-2.692 0-4.026 1.798-4.026 3.656c0 2.208 2.203 2.268 2.203 3.611c0 .325-.23.77-.795.77c-.864 0-1.888-.88-1.888-.88l-.521 1.724s.996 1.212 2.944 1.212c1.623 0 2.827-1.222 2.827-3.12c0-2.413-2.685-2.807-2.685-3.837c0-.19.06-.938 1.254-.938a3.49 3.49 0 0 1 1.478.354zm1.455-4.366c-.243-.743-.621-1.389-1.189-1.46c.141.405.23.916.23 1.55l-.001.208zM8.823 1.41c-.626.268-1.342.98-1.723 2.454l1.983-.614v-.111c0-.766-.102-1.334-.26-1.73zM8.061.688c-1.844 0-2.879 2.42-3.315 3.905l1.567-.486C6.686 2.161 7.567 1.187 8.39.8a.58.58 0 0 0-.33-.11z"/></svg>
                                            </figure>
                                            <h4 class="m-0">Shopify Orders</h4>
                                        </div>

                                        <div class="row gx-2">
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Today</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $order_shopify_30days_today }}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">30 Days</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $order_shopify_30days }}</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </a>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <a href="{{route('order.index') }}" class="card hoverable card-xl-stretch mb-xl-8 bg-white border shadow-sm rounded-3 mb-4">

                                    <div class="card-body p-4">
                                        <div class="d-flex mb-6 align-items-center gap-2">
                                            <figure class="mb-0 card_icon_one">
                                                <i class="bi bi-filetype-csv"></i>
                                            </figure>
                                            <h4 class="m-0">Orders CSV</h4>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Today</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $order_csv_30days_today }}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">30 Days</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $order_csv_30days }}</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </a>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <a href="{{route('order.index') }}" class="card hoverable card-xl-stretch mb-xl-8 bg-white border shadow-sm rounded-3 mb-4">

                                    <div class="card-body p-4">

                                            <div class="d-flex mb-6 align-items-center gap-2">
                                            <figure class="mb-0 card_icon_one">
                                                <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M36.75 11.8125C36.75 10.072 36.0586 8.40282 34.8279 7.17211C33.5972 5.9414 31.928 5.25 30.1875 5.25H11.8125C10.072 5.25 8.40282 5.9414 7.17211 7.17211C5.9414 8.40282 5.25 10.072 5.25 11.8125V30.1875C5.25 31.928 5.9414 33.5972 7.17211 34.8279C8.40282 36.0586 10.072 36.75 11.8125 36.75H17.0625V34.125H11.8125C10.7682 34.125 9.76669 33.7102 9.02827 32.9717C8.28984 32.2333 7.875 31.2318 7.875 30.1875V15.75H34.125V30.1875C34.125 31.2318 33.7102 32.2333 32.9717 32.9717C32.2333 33.7102 31.2318 34.125 30.1875 34.125H24.9375V36.75H30.1875C31.928 36.75 33.5972 36.0586 34.8279 34.8279C36.0586 33.5972 36.75 31.928 36.75 30.1875V11.8125ZM11.8125 7.875H30.1875C31.2318 7.875 32.2333 8.28984 32.9717 9.02827C33.7102 9.76669 34.125 10.7682 34.125 11.8125V13.125H7.875V11.8125C7.875 10.7682 8.28984 9.76669 9.02827 9.02827C9.76669 8.28984 10.7682 7.875 11.8125 7.875ZM21.7376 39.1493C21.9149 39.0288 22.06 38.8668 22.1602 38.6773C22.2604 38.4879 22.3127 38.2768 22.3125 38.0625V29.0535L24.0975 30.5392C24.3659 30.7522 24.707 30.8518 25.0478 30.8167C25.3886 30.7816 25.7022 30.6146 25.9216 30.3513C26.1409 30.0881 26.2487 29.7495 26.2217 29.4079C26.1948 29.0664 26.0354 28.7489 25.7775 28.5233L21.84 25.242C21.6042 25.0456 21.3069 24.938 21 24.938C20.6931 24.938 20.3958 25.0456 20.16 25.242L16.2225 28.5233C16.0854 28.632 15.9714 28.7671 15.8873 28.9206C15.8032 29.0741 15.7506 29.2428 15.7327 29.4169C15.7148 29.591 15.7318 29.7669 15.7829 29.9343C15.834 30.1017 15.918 30.2572 16.03 30.3917C16.1421 30.5261 16.2798 30.6368 16.4353 30.7172C16.5907 30.7976 16.7607 30.8461 16.9352 30.8599C17.1096 30.8736 17.2851 30.8523 17.4512 30.7973C17.6173 30.7422 17.7708 30.6545 17.9025 30.5392L19.6875 29.0535V38.0625C19.6875 38.4088 19.8243 38.741 20.0682 38.9869C20.3121 39.2327 20.6432 39.3722 20.9895 39.375H21.0105C21.2699 39.3732 21.5229 39.2947 21.7376 39.1493ZM22.9688 20.3438C22.9688 20.8659 22.7613 21.3667 22.3921 21.7359C22.0229 22.1051 21.5221 22.3125 21 22.3125C20.4779 22.3125 19.9771 22.1051 19.6079 21.7359C19.2387 21.3667 19.0312 20.8659 19.0312 20.3438C19.0312 19.8216 19.2387 19.3208 19.6079 18.9516C19.9771 18.5824 20.4779 18.375 21 18.375C21.5221 18.375 22.0229 18.5824 22.3921 18.9516C22.7613 19.3208 22.9688 19.8216 22.9688 20.3438Z" fill="#29293A"/></svg>
                                            </figure>
                                            <h4 class="m-0">Total Orders</h4>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Successful</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $today_success_orders }}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Un-successful</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $today_failed_orders }}</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </a>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <a href="{{route('order.index') }}" class="card hoverable card-xl-stretch mb-xl-8 bg-white border shadow-sm rounded-3 mb-4">

                                    <div class="card-body p-4">
                                        <div class="d-flex mb-6 align-items-center gap-2">
                                            <figure class="mb-0 card_icon_one">
                                                <i class="bi bi-cart-check"></i>
                                            </figure>
                                            <h4 class="m-0">Successful Orders</h4>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Csv</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $today_orders_csv }}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Shopify</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $today_orders_shopify }}</div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </a>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <a href="{{route('order.index') }}" class="card hoverable card-xl-stretch mb-xl-8 bg-white border shadow-sm rounded-3 mb-4">

                                    <div class="card-body p-4">
                                        <div class="d-flex mb-6 align-items-center gap-2">
                                            <figure class="mb-0 card_icon_one">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48"><g fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"><path d="M25.5 37H21L11 42V37H4V7H44V18"/><path d="M12 15H15L18 15"/><path d="M12 21H18L24 21"/><path d="M32 25L44 37"/><path d="M44 25L32 37"/></g></svg>
                                            </figure>
                                            <h4 class="m-0">Failed Orders</h4>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Csv</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $failed_orders_csv }}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Shopify</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $failed_orders_shopify }}</div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </a>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <a href="{{route('order.index') }}" class="card hoverable card-xl-stretch mb-xl-8 bg-white border shadow-sm rounded-3 mb-4">

                                    <div class="card-body p-4">
                                        <div class="d-flex mb-6 align-items-center gap-2">
                                            <figure class="mb-0 card_icon_one">
                                                <i class="bi bi-cloud-upload"></i>
                                            </figure>
                                            <h4 class="m-0">FTP File Update Time</h4>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Trusted Parts</div>
                                                    <div class="text-black fw-light fs-3 lh-1 mt-4">{{ \Carbon\Carbon::parse((isset(\DB::table('trq')->first()->created_at)) ? \DB::table('trq')->first()->created_at : '01-01-1940')->diffForHumans();  }}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Perfect Fit</div>
                                                <div class="text-black fw-light fs-3 lh-1 mt-4">
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

                                                    if (strlen($file_time) > 0){
                                                    echo Carbon\Carbon::parse($file_time)->diffForHumans();

                                                    }
                                                    ?>
                                                </div>
                                                </div>
                                                </div>
                                            </div>

                                        </div>

                                </a>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <a href="{{ route('inventoryprice.index')  }}" class="card hoverable card-xl-stretch mb-xl-8 bg-white border shadow-sm rounded-3 mb-4">

                                    <div class="card-body p-4">
                                        <div class="d-flex mb-6 align-items-center gap-2">
                                            <figure class="mb-0 card_icon_one">
                                                <i class="bi bi-cash-stack"></i>
                                            </figure>
                                            <h4 class="m-0">Purchase Value</h4>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Today</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ number_format($total_purchase_value_today,2) }}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">30 days</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ number_format($total_purchase_value,2) }}</div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                </a>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <a href="{{ route('inventoryprice.index')  }}" class="card hoverable card-xl-stretch mb-xl-8 bg-white border shadow-sm rounded-3 mb-4">

                                    <div class="card-body p-4">
                                        <div class="d-flex mb-6 align-items-center gap-2">
                                            <figure class="mb-0 card_icon_one">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="-3 -2 24 24"><path fill="currentColor" d="M12.338 2.395a.228.228 0 0 1 .032.027l1.18 1.171l1.6.12c.073.006.16.061.174.161l2.172 14.693l-6.148 1.33L0 17.771S1.456 6.509 1.511 6.11c.073-.524.091-.541.648-.716l1.796-.557C4.339 3.208 5.565 0 8.13 0c.335 0 .723.18 1.037.594L9.26.591c1.101 0 1.727.939 2.082 1.96l.595-.184c.08-.024.278-.056.4.028zM9.261 7.11s-.513-.297-1.55-.297c-2.692 0-4.026 1.798-4.026 3.656c0 2.208 2.203 2.268 2.203 3.611c0 .325-.23.77-.795.77c-.864 0-1.888-.88-1.888-.88l-.521 1.724s.996 1.212 2.944 1.212c1.623 0 2.827-1.222 2.827-3.12c0-2.413-2.685-2.807-2.685-3.837c0-.19.06-.938 1.254-.938a3.49 3.49 0 0 1 1.478.354zm1.455-4.366c-.243-.743-.621-1.389-1.189-1.46c.141.405.23.916.23 1.55l-.001.208zM8.823 1.41c-.626.268-1.342.98-1.723 2.454l1.983-.614v-.111c0-.766-.102-1.334-.26-1.73zM8.061.688c-1.844 0-2.879 2.42-3.315 3.905l1.567-.486C6.686 2.161 7.567 1.187 8.39.8a.58.58 0 0 0-.33-.11z"/></svg>
                                            </figure>
                                            <h4 class="m-0">Products on Shopify</h4>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Trusted Parts</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ \DB::table('shopify_product_details')->count() }}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Perfect Fit</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ 0 }}</div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </a>

                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <a href="{{ route('inventoryprice.index')  }}" class="card hoverable card-xl-stretch mb-xl-8 bg-white border shadow-sm rounded-3 mb-4">

                                    <div class="card-body p-4">
                                        <div class="d-flex mb-6 align-items-center gap-2">
                                            <figure class="mb-0 card_icon_one">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256"><path fill="currentColor" d="M24 128a72.08 72.08 0 0 1 72-72h96V40a8 8 0 0 1 13.66-5.66l24 24a8 8 0 0 1 0 11.32l-24 24A8 8 0 0 1 192 88V72H96a56.06 56.06 0 0 0-56 56a8 8 0 0 1-16 0m200-8a8 8 0 0 0-8 8a56.06 56.06 0 0 1-56 56H64v-16a8 8 0 0 0-13.66-5.66l-24 24a8 8 0 0 0 0 11.32l24 24A8 8 0 0 0 64 216v-16h96a72.08 72.08 0 0 0 72-72a8 8 0 0 0-8-8"/></svg>
                                            </figure>
                                            <h4 class="m-0">Total Products Synced</h4>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Trusted Parts</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $total_products_synced[0] }}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2 bg-light border border-secondary rounded-2">
                                                    <div class="fw-bold text-dark fs-7 mb-2">Perfect Fit</div>
                                                    <div class="text-black fw-light fs-2x lh-1">{{ $total_products_synced[1] }}</div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </a>

                            </div>
                        </div>

                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 2-->
        </div>





        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <!--<div class="col-xxl-4">-->
        <!--     theme()->getView('partials/widgets/lists/_widget-5', array('class' => 'card-xxl-stretch')) -->
        <!--</div>-->
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-12">

    @php
    $chartColor =  'primary';
    $chartHeight = $chartHeight ?? '175px';
@endphp

<!--begin::Mixed Widget 10-->
<div class="card card-xxl-stretch-50 mb-5 mb-xl-8">
    <!--begin::Body-->
    <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
        <!--begin::Hidden-->
        <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-9 pb-3">
            <div class="me-2">
                <span class="fw-bolder text-gray-800 d-block fs-3">Orders Shopify 30 Days</span>

                <span class="text-gray-400 fw-bold"></span>
            </div>

            <div class="fw-bolder fs-3 text-{{ $chartColor }}">

            </div>
        </div>
        <!--end::Hidden-->

        <!--begin::Chart-->
        <div class="orders-shopify-chart" data-kt-color="{{ $chartColor }}" data-kt-chart-url="{{ route('profits') }}" style="height: {{ $chartHeight }}"></div>
        <!--end::Chart-->
    </div>
</div>
</div>

<!--end::Mixed Widget 10-->





  @php
    $chartColor =  'success';
    $chartHeight = $chartHeight ?? '175px';
@endphp



<!--begin::Mixed Widget 10-->
<div class="card card-xxl-stretch-50 mb-5 mb-xl-8">
    <!--begin::Body-->
    <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
        <!--begin::Hidden-->
        <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-9 pb-3">
            <div class="me-2">
                <span class="fw-bolder text-gray-800 d-block fs-3">Orders Csv 30 Days</span>

                <span class="text-gray-400 fw-bold"></span>
            </div>

            <div class="fw-bolder fs-3 text-{{ $chartColor }}">

            </div>
        </div>
        <!--end::Hidden-->

        <!--begin::Chart-->
        <div class="orders-csv-chart" data-kt-color="{{ $chartColor }}" data-kt-chart-url="{{ route('profits') }}" style="height: {{ $chartHeight }}"></div>
        <!--end::Chart-->
    </div>
    </div>














<!--begin::Mixed Widget 7-->
<div class="card  card-xxl-stretch-50 mb-5 mb-xl-8">
    <!--begin::Body-->
    <div class="card-body d-flex flex-column p-0">
        <!--begin::Stats-->
        <div class="flex-grow-1 card-p pb-0">
            <div class="d-flex flex-stack flex-wrap">
                <div class="me-2">
                    <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">Purchase Value</a>

                    <div class="text-muted fs-7 fw-bold"></div>
                </div>

                <!--<div class="fw-bolder fs-3 text-{{ $chartColor }}">-->

                <!--</div>-->
            </div>
        </div>
        <!--end::Stats-->

        <!--begin::Chart-->
        <div class="mixed-widget-7-chartt card-rounded-bottom" data-kt-chart-color="{{ $chartColor }}" data-kt-chart-url="{{ route('profits') }}" style="height: {{ $chartHeight }}"></div>
        <!--end::Chart-->
    </div>
    <!--end::Body-->
</div>


</div>







@section('scripts')
<script>
    "use strict";

// Class definition
var KTWidgets = function () {
    // Statistics widgets



    var ordersshopifychart = function() {
        var charts = document.querySelectorAll('.orders-shopify-chart');

        [].slice.call(charts).map(function(element) {
            var height = parseInt(KTUtil.css(element, 'height'));

            if ( !element ) {
                return;
            }

            var color = 'yellow';

            var labelColor = KTUtil.getCssVariableValue('--bs-' + 'gray-800');
            var strokeColor = KTUtil.getCssVariableValue('--bs-' + 'gray-300');
            var baseColor = KTUtil.getCssVariableValue('--bs-' + color);
            var lightColor = KTUtil.getCssVariableValue('--bs-light-' + color);

            var options = {
                series: [{
                    name: 'Sale',
                    data: {{ json_encode($order_shopify_30days_chart) }}
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {},
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 1,
                    colors: [baseColor]
                },
                xaxis: {
                    categories: {!! json_encode($order_shopify_30days_chart_label) !!},
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            color: strokeColor,
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: {{ max($order_shopify_30days_chart)+10 }},
                    labels: {
                        show: false,
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function (val) {
                            return "" + val + " Orders"
                        }
                    }
                },
                colors: [lightColor],
                markers: {
                    colors: [lightColor],
                    strokeColor: [baseColor],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        });
    }




     var orderscsvchart = function() {
        var charts = document.querySelectorAll('.orders-csv-chart');

        [].slice.call(charts).map(function(element) {
            var height = parseInt(KTUtil.css(element, 'height'));

            if ( !element ) {
                return;
            }

            var color = 'red';

            var labelColor = KTUtil.getCssVariableValue('--bs-' + 'gray-800');
            var strokeColor = KTUtil.getCssVariableValue('--bs-' + 'gray-300');
            var baseColor = KTUtil.getCssVariableValue('--bs-' + color);
            var lightColor = KTUtil.getCssVariableValue('--bs-light-' + color);

            var options = {
                series: [{
                    name: 'Sale',
                    data: {{ json_encode($order_csv_30days_chart) }}
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {},
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 1,
                    colors: [baseColor]
                },
                xaxis: {
                    categories: {!! json_encode($order_csv_30days_chart_label) !!},
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            color: strokeColor,
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '10px'
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: {{ max($order_csv_30days_chart)+10 }},
                    labels: {
                        show: false,
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                enabled: true,
                style: {
                    fontSize: '10px'
                },
                y: {
                    formatter: function (val) {
                        return "" + val + " Orders";
                    }
                },
            },
                colors: [lightColor],
                markers: {
                    colors: [lightColor],
                    strokeColor: [baseColor],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        });
    }





    var initMixedWidget7 = function() {
        var charts = document.querySelectorAll('.mixed-widget-7-chartt');

        [].slice.call(charts).map(function(element) {
            var height = parseInt(KTUtil.css(element, 'height'));

            if ( !element ) {
                return;
            }

            var color = element.getAttribute('data-kt-chart-color');

            var labelColor = KTUtil.getCssVariableValue('--bs-' + 'gray-800');
            var strokeColor = KTUtil.getCssVariableValue('--bs-' + 'gray-300');
            var baseColor = KTUtil.getCssVariableValue('--bs-' + color);
            var lightColor = KTUtil.getCssVariableValue('--bs-light-' + color);

            var options = {
                series: [{
                    name: 'Purchase',
                    data: {{ json_encode($total_purchase_value_chart) }}
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {},
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 1,
                    colors: [baseColor]
                },
                xaxis: {
                    categories: {!! json_encode($order_csv_30days_chart_label) !!},
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            color: strokeColor,
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: false,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: {{ isset($total_purchase_value_chart)?max($total_purchase_value_chart)+10:0 }},
                    labels: {
                        show: false,
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function (val) {
                            return "" + val + " Sale"
                        }
                    }
                },
                colors: [lightColor],
                markers: {
                    colors: [lightColor],
                    strokeColor: [baseColor],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        });
    }



    // Public methods
    return {
        init: function () {

           orderscsvchart();
           ordersshopifychart();
            initMixedWidget7();
            // initMixedWidget10();

        }
    }
}();



// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTWidgets.init();
});

</script>
@endsection























    @else


    <h2 style="
    margin: auto;
    width: fit-content;
    color: red;
">Welcome to the Quantum ERP</h2>




  @endif

</x-base-layout>
