<div class="form-group {{$col ?? ''}}">
    <input type="file" class="dropify" name="{{$name}}" id="{{$name}}" class="{{$class ?? ''}}"
    data-show-errors="true" data-errors-position="outside"
    data-allowed-file-extensions="jpg jpeg png svg webp gif">
    <input type="hidden" name="old_{{$name}}" id="old_{{$name}}">
</div>
