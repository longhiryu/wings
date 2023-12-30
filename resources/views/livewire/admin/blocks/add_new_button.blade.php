<div>
    @if($create_permission)
        <a class="my-button btn btn-primary text-white" wire:click="create()">
            <i class="fa-solid fa-plus"></i>{{ __('text.txt_add_new') }}
        </a>
    @endif
</div>
