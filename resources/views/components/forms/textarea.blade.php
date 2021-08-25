<div class="form-group {{$col ?? ''}} {{$required ?? ''}}" >
    <label for="{{$name}}">{{$labelName}}</label>
    <textarea name="{{$name}}" id="{{$name}}" class="form-control {{$class ?? ''}}"
     placeholder="{{$placeholder ?? ''}}">{{ $value ?? '' }}</textarea>
</div>
