<div class="accordion my-3" id="accordionExample">
    <div class="accordion-item bg-white border-0">
        <h2 class="accordion-header" id="heading2">
            <button wire:click.prevent="collapse" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">Advanced Filter</button>
        </h2>
        <div class="accordion-collapse collapsed collapse {{ ($visible) ? 'show' : '' }}" id="collapse2" aria-labelledby="heading2" data-bs-parent="#accordionExample">
            <div class="accordion-body">

                <div class="align-items-center justify-content-start my-3">

                    @if(isset($action))
                    <form wire:submit.prevent="{{ $action }}" class="position-relative">
                        @endif

                        {{ $filters }}

                        @if(isset($action))
                    </form>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>