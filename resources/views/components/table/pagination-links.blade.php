@props([
'paginationLinks' => false,
])

<div {{ $attributes->merge(['class' => 'align-middle']) }}>
    {!! $paginationLinks !!}
</div>