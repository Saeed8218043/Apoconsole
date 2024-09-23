
<!--begin::Header-->
<div id="kt_header" style="" class="shadow header {{ theme()->printHtmlClasses('header', false) }} align-items-stretch" {{ theme()->printHtmlAttributes('header') }}>
	<!--begin::Container-->
	<div class="{{ theme()->printHtmlClasses('header-container', false) }} d-flex align-items-stretch justify-content-between">
		<!--begin::Aside mobile toggle-->
		@if (theme()->getOption('layout', 'aside/display') === true)
			<div class="d-flex align-items-center d-lg-none ms-n1 me-2" title="Show aside menu">
				<div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
					{!! theme()->getSvgIcon("icons/duotune/abstract/abs015.svg", "svg-icon-2x mt-1") !!}
				</div>
			</div>
		@endif
		<!--end::Aside mobile toggle-->

		<!--begin::Mobile logo-->
		<div class="d-flex align-items-center ">
			<a href="{{ theme()->getPageUrl('') }}" class="d-lg-none">
				<img alt="Logo" src="{{  asset('quantum/images/featured-item-01.png')}}" class="h-45px"/>
			</a>
		</div>
		<!--end::Mobile logo-->

		<!--begin::Wrapper-->
		<div class="d-flex align-items-stretch justify-content-between flex-grow-1 ms-3">
			<!--begin::Navbar-->
			@if(theme()->getOption('layout', 'header/left') === 'menu')
				<div class="d-flex align-items-stretch" id="kt_header_nav">
				@php
    $pageTitleDisplay = (theme()->getOption('layout', 'page-title/display') && theme()->getOption('layout', 'header/left') !== 'page-title');
@endphp
 @if ($pageTitleDisplay)
            <!--begin::Page title-->
            <div class="flex-grow-1 flex-shrink-0 me-5">
                 <h1 class="d-flex align-items-center text-dark fw-bolder m-0 fs-2 h-100 mainPageTitle">
        {{ theme()->getOption('page', 'title') }}

        @if (!empty(theme()->hasOption('page', 'description')) && theme()->getOption('layout', 'page-title/description') !== false)
            <!--begin::Separator-->
            <!-- <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span> -->
            <!--end::Separator-->

            <!--begin::Description-->
            <!--<small class="text-muted fs-7 fw-bold my-1 ms-1">-->
            <!--    {{ theme()->getOption('page', 'description') }}-->
            <!--</small>-->
            <!--end::Description-->
        @endif
    </h1>
            </div>
            <!--end::Page title-->
        @endif
				</div>
			@elseif(theme()->getOption('layout', 'header/left') === 'page-title')
				<div class="d-flex align-items-center" id="kt_header_nav">

				</div>
			@endif
			<!--end::Navbar-->

			<!--begin::Topbar-->
	        <div class="d-flex align-items-stretch flex-shrink-0">
				{{ theme()->getView('layout/topbar/_base') }}
			</div>
			<!--end::Topbar-->
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Container-->
</div>
<!--end::Header-->
