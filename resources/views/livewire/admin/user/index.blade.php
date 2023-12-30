@section('title', 'User')
<div>
    @if (!$isForm)
        @include('livewire.admin.'.$type.'.list')
    @else
        @can('edit', $model)
            @include('livewire.admin.'.$type.'._form')
        @endcan
    @endif

    {{-- files modal --}}
    @include('livewire.admin.blocks.file-modal', [
        'idModal' => 'image-list',
        'files' => $this->files,
        'field' => 'file_id',
    ])

</div>

@push('scripts')

@endpush
