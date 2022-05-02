@props([
'options' => [],
])

<div {{ $attributes->merge(['class' => 'row my-2']) }}>
    <div class="col-12">
        @if(count($options)>0)
        <div class="float-start me-2">
            <select class="form-select" wire:model="perPage">
                @foreach ($options as $value => $option_name)
                <option value="{{$value}}">{{ $option_name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        @if(isset($bulkActions))
        <div id="bulk-select-replace-element me-2">
            <tr class="align-middle">
                {{ $bulkActions }}
            </tr>
        </div>
        @endif
    </div>
</div>