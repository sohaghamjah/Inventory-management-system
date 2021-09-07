@extends('layouts.app')
@section('title')
    {{ $page_title }}
@endsection
@push('stylesheet')

@endpush
@section('content')
<div class="dt-content">

    <!-- Grid -->
    <div class="row">

        <div class="col-xl-12">
            <ol class="mb-4 breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $sub_title. ' ('.$data['menu'] -> menu_name.')' }}</li>
            </ol>
        </div>

        <!-- Grid Item -->
        <div class="col-xl-12">

            <!-- Entry Header -->
            <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h3 class="dt-page__title mb-0 text-primary"><i class="{{ $page_icon }}"></i> {{ $sub_title . ' ('.$data['menu'] -> menu_name.')' }}</h3>
                </div>
                <!-- /entry heading -->

                <div>
                    <a href="{{ route('menu') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-arrow-circle-left"></i>
                        Back To Menu List
                    </a>
                    @if (permission('menu-module-add'))
                        <a href="{{ route('menu.module.create', $data['menu']->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-square"></i>
                            Add New
                        </a>
                    @endif
                </div>

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body menu-builder">
                    <h5 class="card-item">Darg and drop the menu item below to re-arragne them</h5>
                    <div class="dd">
                        <x-menu-builder :menuItems="$data['menu']->menuItems"/>
                    </div>
                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->

    </div>
    <!-- /grid -->

</div>
@include('menu.modal')
@endsection
@push('script')

<script>
    // Darg and drop menu order
    $(function (){
        $('.dd').nestable({maxDepth:2});
        $('.dd').on('change', function(){
            $.post('{{ route('menu.order', '$data["menu"]->id') }}', {
                order:JSON.stringify($('.dd').nestable('serialize')),
                _token: _token,
            }, function(){
                notification('success', 'Menu order updated successfull');
            });
        });
    });

    function deleteItem(id)
    {
        Swal.fire({
            title: 'Are you sure to delete?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                document.getElementById('delete_form_'+id).submit();
            }
        });
    }


    // Flash message
    $(document).ready(function ($) {
        @if (session('success'))
            notification('success', "{{ session('success') }}");
        @endif
        @if (session('error'))
            notification('error', "{{ session('error') }}");
        @endif
    });
</script>
@endpush
