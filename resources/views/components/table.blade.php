@if(isset($topHeader ))
<tr class="align-middle">
    {{ $topHeader }}
</tr>
@endif

<div>
    <table {{ $attributes }}>
        @if(isset($head))
        <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                {{ $head }}
            </tr>
        </thead>
        @endif

        @if(isset($body))
        <tbody>

            <x-table.row>
                <div wire:loading class="position-absolute col-5 offset-3 my-5">
                    <img class="d-block h-25 w-25 mx-auto" src="{{ asset('assets/img/animated-icons/infinity-01-loading.gif') }}">
                </div>
            </x-table.row>

            {{ $body }}
        </tbody>
        @endif
    </table>
</div>