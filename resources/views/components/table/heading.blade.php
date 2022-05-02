@props([
'sortable' => null,
'direction' => null,
'multiColumn' => null,
])

<th {{ $attributes->merge(['class' => 'px-6 py-3']) }} scope="col">
    {{ $slot }}
</th>