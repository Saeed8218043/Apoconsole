<!--begin::Engage drawers-->
@if(theme()->getOption('layout', 'engage/demos/enabled'))
    {{ theme()->getView('partials/engage/demos/_main') }}
@endif

@if(theme()->getOption('layout', 'engage/help/enabled'))
    {{ theme()->getView('partials/engage/help/_main') }}
@endif
<!--end::Engage drawers-->

<!--begin::Engage toolbar-->
<div class="engage-toolbar d-flex position-fixed px-5 fw-bolder zindex-2 top-50 end-0 transform-90 mt-20 gap-2">
  
</div>
<!--end::Engage toolbar-->
