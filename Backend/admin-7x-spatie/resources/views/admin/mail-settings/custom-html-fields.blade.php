<?php
  if (!isset($class)) {
      $class = '';
  }
  $input_id = \str_replace(['[', ']'], '-', \str_replace('/', '.', $name));
?>
@switch($type)
    @case('text')
      <input type="text" name="{{$name}}" value="{{$value}}" placeholder="" class="form-control {{$class}}">
    @break;

    @case('number')
      <input type="number" name="{{$name}}" value="{{$value}}" placeholder="" class="form-control {{$class}}">
    @break;

    @case('textarea')
      <textarea name="{{$name}}" placeholder="" class="form-control {{$class}}">{{$value}}</textarea>
    @break;

    @case('wysiwyg')
      <textarea id="{{$input_id}}" name="{{$name}}" placeholder="" class="form-control wysiwyg {{$class}}">
        {{$value}}
      </textarea>
    @break;

    @case('checkbox')
      @foreach($options as $opt_value => $opt_text)
          <div class="checkbox">
              <label class="form-check-label">
                  <?php $value = (array)$value; ?>
                      <input type="checkbox" name="{{$name}}[]" @if( \in_array($opt_value,$value) ) checked
                         @endif value="{{$opt_value}}" class="{{$class}} form-check-input-styled-primary form-control-uniform">
                      {{$opt_text}}
              </label>
          </div>
      @endforeach
    @break;

    @case('select2')
      <select class="form-control select2" name="{{$name}}[]" multiple>
        <option value="">{{ __('-- Chọn người gửi --') }}</option>
        @if($name == 'default_user')
          @foreach(\App\Domain\SubscribeEmail\Models\SubscribeEmail::all() as $email)
            @if($email->email)
              <?php $data = (array)$value; ?>
              <option value="{{ $email->id }}" {{ \in_array($email->id, $data) ? 'selected' : '' }} >{{ $email->email }}</option>
            @endif
          @endforeach
        @endif
      </select>
    @break;

@endswitch
