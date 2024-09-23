<!--begin::Action--->
<td class="text-end">
  @foreach($roles as $role)
<a href="#" class="badge badge-light-primary fs-7 m-1">@if (isset($role[0])){{ $role[0] }}@endif</a>
  @endforeach
</td>
<!--end::Action--->
