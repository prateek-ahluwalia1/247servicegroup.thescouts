@section('guard_uniform')
<?php
$item = session()->get('guards_navigation_bar');
// @dd($item);
if (!empty($item)) {
foreach(session()->get('guards_navigation_bar') as $item1) {
	$item = $item1;
}
}else{
	$item['guard_uniform'] = 1;
	$item = json_decode(json_encode($item));
}
?>
@if(isset($item->guard_uniform) && $item->guard_uniform == 1)
<div class="col-md-4">
    <!--begin::Card-->
    <div class="card card-flush h-md-100">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{ config('custom.guard') }} Uniform </h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-1">
            <div class="fw-bolder text-gray-600 mb-5">Optional</div>
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer flex-wrap pt-0">
            {{-- data-bs-target="#guard_avability-modal" --}}
            <button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal"
                id="guard_uniform_button">Check {{ config('custom.guard') }} Uniform</button>
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card-->
</div>
@endif
   
    <div class="modal fade" id="guard_uniform-modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder" id="form_head">
                        {{ config('custom.guard') }} Uniform </h2>

                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">

                        <span class="svg-icon svg-icon-2x">X</span>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 my-7">
                    <!--begin::Form-->
                    <form id="guard_uniform-form" class="form" action="{{ url('guard/update_guard_uniform') }}"
                        method="POST" enctype="multipart/form-data"> @csrf

                        <input type="hidden" class="form-control form-control-md" id="guard_id" name="guard_id"
                            value="{{ $guard_id }}">
                        <div id="uniform_form" class="row">
                            <table class="table table-striped gy-7 gs-7">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                        <th>Status</th>
                                        <th>Uniform Type</th>
                                        <th>Uniform Size</th>
                                        <th>Uniform Quantity</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $uniform_type = ['dress_shirt', 'slacks', 'security_tag', 'vest', 't_shirt', 'polo', 'scrub', 'jacket', 'tie', 'ascot'];
                                    ?>
                                    @foreach ($uniform_type as $uniform)
                                        <tr id="{{ $uniform }}_row">

                                            <td>
                                                <div class="form-check form-check-solid form-switch fv-row">
                                                    <input class="form-check-input w-45px h-30px" type="checkbox"
                                                        id="{{ $uniform }}_uniform_status"
                                                        onchange="toggle_uniform(this,'{{ $uniform }}_uniform_size','{{ $uniform }}_uniform_quantity')"
                                                        name="{{ $uniform }}_uniform_status">
                                                </div>
                                            </td>
                                            <td>
                                                <h5><?php
                                                if (strpos($uniform, '_') !== false) {
                                                    $name = explode('_', $uniform);
                                                    echo ucfirst($name[0]) . ' ' . ucfirst($name[1]);
                                                } else {
                                                    echo ucfirst($uniform);
                                                }
                                                ?></h5>
                                            </td>
                                            <td>
                                                <select style="display:none" id="{{ $uniform }}_uniform_size"
                                                    name="{{ $uniform }}_uniform_size"
                                                    class="form-select form-select-lg form-select-solid"
                                                    data-placeholder="Select Uniform Size" data-allow-clear="true"
                                                    data-hide-search="true">
                                                    <option value="XS"> XS</option>
                                                    <option value="S"> S</option>
                                                    <option value="M"> M</option>
                                                    <option value="L"> L</option>
                                                    <option value="XL"> XL</option>
                                                    <option value="XXL"> XXL</option>
                                                    <option value="XXXL"> XXXL</option>
                                                    <option value="XXXXL"> XXXXL</option>
                                                    <option value="XXXXXL"> XXXXXL</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select style="display:none" id="{{ $uniform }}_uniform_quantity"
                                                    name="{{ $uniform }}_uniform_quantity"
                                                    class="form-select form-select-lg form-select-solid"
                                                    data-placeholder="Select Uniform Quantity" data-allow-clear="true"
                                                    data-hide-search="true">
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                    <option value="4">Four</option>
                                                    <option value="5">Five</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>



                        <div class="row ">
                            <button type="submit" class="btn-primary btn" style="text-align: center;">Submit</button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Update role-->
    <!--end::Modals-->
@stop
