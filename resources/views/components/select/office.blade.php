@props([
'label' => '',
'name' => '',
'labelVisible' => false,
])

<div {{ $attributes }}>
    <div wire:ignore class="mb-3">
        @if($labelVisible)<label class="form-label">{!! $label !!} *</label>@endif
        {{ Form::select($name, [], '', [
            'class' => 'form-control select-office destination-office required',
            'data-placeholder' => '- Select '.$label.' -',
            'title' => '- Select '.$label.' -',
            'data-url' => route('office.index')
        ]) }}
    </div>
    @error($name) <div class="text-danger mt-2">{{ $message }}</div> @enderror
</div>