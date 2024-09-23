<a href="#"
            onclick="edit('{{ $row->id }}')"
            data-bs-toggle="modal" data-bs-target="#kt_modal_edit_coupon"
            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
            <span class="svg-icon svg-icon-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3"
                        d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                        fill="black" />
                    <path
                        d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                        fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </a>

<div data-kt-users-table-filter="delete_row" data-id="{{ $row->id }}" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm"> <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg--> <span class="svg-icon svg-icon-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" /> <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" /> <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </div>
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
 @if  ($row->location_inventory_id_check == 0 || 1)                                                           
                                                        
<!--<div  onclick="sync_now('{{ $row->sku }}',this)" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm ms-2">  <span class="svg-icon svg-icon-3"> <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 503.2 503.2" style="enable-background:new 0 0 503.2 503.2;" xml:space="preserve">-->
<path style="fill:red;" d="M479.2,227.6c-13.6,0-24,10.4-24,24c0,112-91.2,203.2-203.2,203.2S48.8,363.6,48.8,251.6
	S140,47.6,252,47.6c58.4,0,113.6,28,152,68h-43.2c-13.6,0-24,10.4-24,24s10.4,24,24,24H484v-124c0-13.6-10.4-24-24-24
	s-24,10.4-24,24V82C388,30,321.6,0.4,251.2,0.4C112.8,0.4,0,113.2,0,251.6s113.6,251.2,252,251.2S503.2,390,503.2,251.6
	C503.2,238,492.8,227.6,479.2,227.6z"></path>
<path style="fill:red;" d="M336.8,139.6c0,13.6,10.4,24,24,24h124.8c-34.4-80-115.2-140-210.4-140
	c-124.8,0-226.4,101.6-226.4,227.2S150.4,478,276,478s227.2-101.6,227.2-227.2c0-1.6,0-4,0-5.6c-3.2-10.4-12-17.6-23.2-17.6
	c-13.6,0-24,10.4-24,24c-0.8,112-92,203.2-204,203.2S48.8,363.6,48.8,251.6S140,47.6,252,47.6c58.4,0,113.6,28,152,68h-43.2
	C347.2,115.6,336.8,126,336.8,139.6z"></path>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </div>
                                                            
                                                        @endif