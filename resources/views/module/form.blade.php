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
                <li class="breadcrumb-item active">
                    @if (isset($data['module']))
                      {{ $sub_title }}
                    @else
                      {{ $sub_title. ' To ('.$data['menu']->menu_name. ')' }}
                    @endif
                </li>
            </ol>
        </div>

        <!-- Grid Item -->
        <div class="col-xl-12">

            <!-- Entry Header -->
            <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h3 class="dt-page__title mb-0 text-primary"><i class="{{ $page_icon }}"></i>
                        @if (isset($data['module']))
                            {{ $sub_title }}
                        @else
                            {{ $sub_title. ' To ('.$data['menu']->menu_name. ')' }}
                        @endif
                    </h3>
                </div>
                <!-- /entry heading -->

                <a href="{{ route('menu.builder', $data['menu']->id) }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-arrow-circle-left"></i>
                    Back
                </a>

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <h5 class="card-title">Manage module/item</h5>
                    <form action="{{ route('menu.module.store.or.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="update_id" id="update_id" value="{{ isset($data['module']) ? $data['module']->id : ''}}">
                        <input type="hidden" name="menu_id" id="menu_id" value="{{ $data['menu']->id }}">
                        <div class="form-group required">
                            <label for="">Type</label>
                            <select name="type" id="type" class="form-control selectpicker @error('type') is-invalid @enderror" onchange="setItemType(this.value)">
                                <option value="">Select Please</option>
                                <option value="1" @isset($data['module']) {{ $data['module']->type==1 ? 'selected' : '' }} @endisset {{ old('type') == 1 ? 'selected' : '' }}>Divider</option>
                                <option value="2" @isset($data['module']) {{ $data['module']->type==2 ? 'selected' : '' }} @endisset {{ old('type') == 2 ? 'selected' : '' }}>Menu/Item</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="divider_fields d-none">
                            <div class="form-group required">
                                <label for="">Divider Title</label>
                                <input type="text" name="divider_name" class="form-control @error('divider_name') is-invalid @enderror" id="divider_name" placeholder="Enter Devider Name..." value="{{ isset($data['module']) ? $data['module'] -> divider_name : old('divider_name') }}">
                                @error('divider_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="item_fields d-none">
                            <div class="form-group required">
                                <label for="">Module Name</label>
                                <input type="text" name="module_name" class="form-control @error('module_name') is-invalid @enderror" id="module_name" placeholder="Enter Module Name..." value="{{ isset($data['module']) ? $data['module'] -> module_name : old('module_name') }}">
                                @error('module_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Module URL</label>
                                <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" id="url" placeholder="Enter Module URL..." value="{{ isset($data['module']) ? $data['module'] -> url : old('url') }}">
                                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Font awesome class for the module <a href="https://fontawesome.com/" target="blank">(Use a font awesome font class)</a></label>
                                <input type="text" name="icon_class" class="form-control @error('icon_class') is-invalid @enderror" id="icon_class" placeholder="Enter Module fontawesome classs name..." value="{{ isset($data['module']) ? $data['module']->icon_class : old('icon_class') }}">
                                @error('icon_class')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                <label for="">Open In</label>
                                <select name="target" id="target" class="form-control selectpicker @error('target') is-invalid @enderror">
                                    <option value="">Select Please</option>
                                    <option value="_self" @isset($data['module']) {{ $data['module']->target == '_self' ? 'selected' : '' }} @endisset {{ old('target') == '_self' ? 'selected' : '' }}>Same Tab</option>
                                    <option value="_blank"  @isset($data['module']) {{ $data['module']->target == '_blank' ? 'selected' : '' }} @endisset {{ old('target') == '_blank' ? 'selected' : '' }}>New Tab</option>
                                </select>
                                @error('target')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger btn-sm"><i class="fas fa-redo"></i> Reset</button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                @isset($data['module'])
                                    <i class="fas fa-arrow-circle-up"></i> Update
                                @else
                                    <i class="fas fa-plus-square"></i> Add
                                @endisset
                            </button>
                        </div>
                    </form>
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
    var type = $('#type option:selected').val();
    if(type){
        setItemType(type);
    }
    function setItemType(type){
        if(type == 1){
            $('.divider_fields').removeClass('d-none');
            $('.item_fields').addClass('d-none');
        }else{
            $('.divider_fields').addClass('d-none');
            $('.item_fields').removeClass('d-none');
        }
    }
</script>
@endpush
