<div class="d-flex align-content-center">
    <button class="my-button btn btn-success me-4 text-white" type="button" wire:click="createOrUpdate()">
        <i class="fa-solid fa-cloud-arrow-up me-2"></i>{{ __('text.btn_save') }}
    </button>
    <button class="my-button btn btn-primary me-2 text-white" type="button" wire:click="createOrUpdate(1)">
        <i class="fa-solid fa-cloud-arrow-up me-2"></i>{{ __('text.btn_save_exit') }}
    </button>
    <button class="my-button btn {{ $exitConfirm ? 'btn-warning text-white' : 'btn-secondary' }} text-dark" type="button"
        wire:click="exitConfirm('{{ $exitConfirm }}')">
        <i class="fa-solid fa-door-open me-1"></i>
        {{ $exitConfirm ? __('text.btn_confirm_exit') : __('text.btn_exit') }}
        <div wire:loading wire:target="exitConfirm">
            <div style="height: 100%" class="d-flex align-items-center"><i class="fa-solid fa-spinner fa-spin"></i></div> 
        </div>
    </button>
</div>