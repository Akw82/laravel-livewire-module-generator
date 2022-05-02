@props([
'total' => 0,
'currentPage' => 0,
'perPage' => 0,
'lastPage' => 0,
'perCount' => 0,
])

<div {{ $attributes->merge(['class' => 'col']) }}>
    <p class="mb-0 fs--1">
        <span class="d-none d-sm-inline-block me-2" data-list-info="data-list-info">
            Showing {{ $perCount }} to {{ ($currentPage == $lastPage) ? $total : $currentPage * $perPage  }} of {{ $total }} Records
            {{ $slot }}
        </span>
    </p>
</div>