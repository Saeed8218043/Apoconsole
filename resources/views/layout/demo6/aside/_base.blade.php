<!--begin::Aside-->
<div
	id="kt_aside"
	class="aside pb-5 pt-5 pt-lg-0 {{ theme()->printHtmlClasses('aside', false) }}"
	data-kt-drawer="true"
	data-kt-drawer-name="aside"
	data-kt-drawer-activate="{default: true, lg: false}"
	data-kt-drawer-overlay="true"
	data-kt-drawer-width="{default:'80px', '300px': '100px'}"
	data-kt-drawer-direction="start"
	data-kt-drawer-toggle="#kt_aside_mobile_toggle"
	>

    <!--begin::Brand-->
    <div class="aside-logo" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ theme()->getPageUrl('') }}" class="d-flex align-items-center">
            <img alt="Logo" src="{{ asset('quantum/images/featured-item-01.png') }}" class="logo img-fluid"/>
        </a>
        <!--end::Logo-->
    </div>
    <!--end::Brand-->

    <!--begin::Aside menu-->
	<div class="aside-menu flex-column-fluid" id="kt_aside_menu">
		{{ theme()->getView('layout/aside/_menu') }}
    </div>
    <!--end::Aside menu-->

    <!--begin::Footer-->

    <!--end::Footer-->
</div>
<!--end::Aside-->
