@props([
'key' => '',
'label' => '',
'name' => '',
'labelVisible' => false,
])

<div {{ $attributes }}>
    <div wire:ignore class="mb-3">
        @if($labelVisible)<label class="form-label">{!! $label !!} *</label>@endif
        {{ Form::select($name, [], '', [
            'id' => $name.$key,
            'data-key' => $name.'.'.$key,
            'class' => 'form-control select-country flight-routed-countries selectpicker
            required',
            'data-placeholder' => '- Select '.$label.' -',
            'title' => '- Select '.$label.' -',
            'data-url' => route('country.index')
        ]) }}
    </div>
    @error($name.'.'.$key) <div class="text-danger mt-2"> {{ $message }} </div> @enderror
</div>