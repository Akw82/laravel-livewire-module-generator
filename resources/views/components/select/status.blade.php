@props([
'label' => '',
'name' => '',
'labelVisible' => false,
'data' => '',
])

<div {{ $attributes }}>
    <div class="mb-3" wire:ignore>
        @if($labelVisible)<label class="form-label">{!! $label !!} *</label>@endif
        {{ Form::select($name,
        $data, null,
        [
        'wire:model.lazy' => $name,
        'placeholder' => '- Select '.$label.' -',
        'class'=>'form-control form-select select2-selector'
        ]); }}
        @error($name) <div class="text-danger mt-2">{{ $message }}</div> @enderror
    </div>
</div>