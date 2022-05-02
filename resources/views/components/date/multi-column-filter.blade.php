@props([
'label' => '',
'name' => '',
'options' => [],
])

<div {{ $attributes }} wire:ignore>
    @if($options)
    <div class="input-group mb-3">
        <select class="input-group-text" id="inputGroup-sizing-default" wire:model.prevent.lazy="{{ $name }}">
            <option value="">- Select Date Column -</option>
            @foreach ($options as $value => $option_name)
            <option value="{{$value}}">{{ $option_name }}</option>
            @endforeach
        </select>
        <input id="timepicker2" type="text" class="form-control datetimepicker" aria-describedby="inputGroup-sizing-default" data-options='{"mode":"range","dateFormat":"d-m-y","disableMobile":true}'>
    </div>
    @endif
</div>