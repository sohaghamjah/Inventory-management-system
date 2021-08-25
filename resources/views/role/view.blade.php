@extends('layouts.app')
@section('title')
    {{ $page_title }}
@endsection
@push('stylesheet')
<style>
    #permission li{
        font-size: 16px;
        line-height: 28px;
    }
</style>
@endpush
@section('content')
<div class="dt-content">

    <!-- Grid -->
    <div class="row">

        <div class="col-xl-12">
            <ol class="mb-4 breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $sub_title }}</li>
            </ol>
        </div>

        <!-- Grid Item -->
        <div class="col-xl-12">

            <!-- Entry Header -->
            <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h3 class="dt-page__title mb-0 text-primary"><i class="{{ $page_icon }}"></i> {{ $permission_data['role']->role_name }}  {{ $sub_title }}</h3>
                </div>
                <!-- /entry heading -->

                <a href="{{ route('role') }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-arrow-circle-left"></i>
                    Back
                </a>

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <div class="col-md-12">
                        <h2 class="text-center text-primary">
                            {{ $permission_data['role']->role_name }} Role Permissions
                        </h2>
                    </div>
                    <div class="col-md-12">
                        <ul id="permission" class="text-left " style="list-style: none">
                            @if (!$data -> isEmpty())
                                @foreach ($data as $menu)
                                    @if ($menu -> submenu -> isEmpty())
                                        <li>
                                            @if (collect($permission_data['module_role'])->contains($menu->id))
                                            <i class="fas fa-check-circle text-success"></i>
                                            @else
                                            <i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                            {!! $menu->type == 1 ? $menu->divider_name." <small>(Divider)</small>" : $menu->module_name !!}
                                            @if (!$menu->permission -> isEmpty())
                                                <ul class="" style="list-style: none">
                                                    @foreach ($menu->permission as $permission)
                                                        <li>
                                                            @if (collect($permission_data           ['permission_role'])->contains($permission->id))
                                                            <i class="fas fa-check-circle text-success"></i>
                                                            @else
                                                            <i class="fas fa-times-circle text-danger"></i>
                                                            @endif
                                                            {{ $permission -> name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @else
                                       <li>
                                             @if (collect($permission_data['module_role'])->contains($menu->id))
                                             <i class="fas fa-check-circle text-success"></i>
                                             @else
                                             <i class="fas fa-times-circle text-danger"></i>
                                             @endif
                                             {!! $menu->type == 1 ? $menu->divider_name." <small>(Divider)</small>" : $menu->module_name !!}
                                            <ul class="" style="list-style: none">
                                                @foreach ($menu -> submenu as $submenu)
                                                    <li>
                                                        @if (collect($permission_data['module_role'])->contains($submenu->id))
                                                        <i class="fas fa-check-circle text-success"></i>
                                                        @else
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                        @endif
                                                        {{ $submenu -> module_name }}
                                                        @if (!$submenu->permission -> isEmpty())
                                                            <ul class="" style="list-style: none">
                                                                @foreach ($submenu->permission as $permission)
                                                                    <li>
                                                                        @if (collect($permission_data['permission_role'])->contains($permission->id))
                                                                        <i class="fas fa-check-circle text-success"></i>
                                                                        @else
                                                                        <i class="fas fa-times-circle text-danger"></i>
                                                                        @endif
                                                                        {{ $permission -> name }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                       </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
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
@endsection
@push('script')
<script src="{{ asset('assets/default/assets/js/tree.js') }}"></script>
<script>

</script>
@endpush
