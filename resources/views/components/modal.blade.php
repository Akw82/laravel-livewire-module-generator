@props([
'formAction' => false,
'id' => '',
'data' => '',
'modalSize' => '',
])

<!-- Modal -->
<div wire:ignore.self id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" {{ $attributes->merge(['class' => 'modal fade']) }}>
    <div class="modal-dialog modal-dialog-centered {{ $modalSize }}" role="document">
        <div class="modal-content position-relative">

            @if(isset($formAction) && $formAction)
            <form wire:submit.prevent="{{ $formAction }}">
                @endif

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" wire:click="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" wire:loading.class.delay="opacity-50">

                    @if(isset($header))
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1">{{ $header }}</h4>
                    </div>
                    @endif

                    @if(isset($content))
                    <div class="px-4 py-2 pb-0 mb-3 content-modal">
                        {{ $content }}
                    </div>

                    <x-table.row>
                        <div wire:loading class="col-5 offset-3 my-5">
                            <img class="d-block h-25 w-25 mx-auto" src="{{ asset('assets/img/animated-icons/truck-01-loading.gif') }}">
                        </div>
                    </x-table.row>
                    @endif

                </div>

                @if(isset($footer))
                <div class="modal-footer">
                    {{ $footer }}
                </div>
                @endif

                @if(isset($formAction))
            </form>
            @endif

        </div>
    </div>
</div>