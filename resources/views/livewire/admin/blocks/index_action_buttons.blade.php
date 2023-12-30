<?php 
    $disable = null;
    if (isset($item->is_imported) && $item->is_imported == 1) {
        $disable = 'disabled';
    }
?>
<div>
    @if (isset($type) && $type == 'product')
        <button class="my-button btn btn-primary text-white" wire:click="duplicateProduct('{{ $item->id }}')">
            <i class="fa-solid fa-copy mr-2"></i>{{ __('text.txt_duplicate') }}
        </button>
    @endif

    @if($edit_permission)
        <button class="my-button btn btn-success me-2 text-white" wire:click="edit({{ $item->id }})">
            <i class="fa-solid fa-pen"></i>{{ __('text.edit') }}
        </button>
    @endif

    @if($delete_permission)
        @if (isset($deleteConfirm[$item->id]) && $deleteConfirm[$item->id])
            <button class="my-button btn btn-warning text-white" wire:click="delete('{{ $item->id }}')">
                <i class="fa-regular fa-trash-can mr-2"></i>{{ __('text.delete_confirm') }}
                <div wire:loading wire.target="deleteConfirm">
                    <div style="height: 100%" class="d-flex align-items-center"><i class="fa-solid fa-spinner fa-spin"></i></div> 
                </div>
            </button>
        @else
            <button class="my-button btn btn-secondary" wire:click="deleteConfirm('{{ $item->id }}')" {{ $disable }}>
                <i class="fa-regular fa-trash-can mr-2"></i>{{ __('text.delete') }}
                <div wire:loading wire:target="deleteConfirm">
                    <div style="height: 100%" class="d-flex align-items-center"><i class="fa-solid fa-spinner fa-spin"></i></div> 
                </div>
            </button>
        @endif
    @endif
</div>
