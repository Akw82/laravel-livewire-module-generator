@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">

        @if(isset($title))
        <div class="text-lg">
            {{ $title }}
        </div>
        @endif

        @if(isset($content))
        <div class="mt-4">
            {{ $content }}
        </div>
        @endif
    </div>

    @if(isset($footer))
    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right">
        {{ $footer }}
    </div>
    @endif
</x-jet-modal>