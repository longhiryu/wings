@section('title', 'Project')
<div>
    @if (!$isForm)
        @include('livewire.admin.' . $type . '.list')
    @else
        @include('livewire.admin.' . $type . '._form')
    @endif

    {{-- files modal --}}
    {{-- @include('livewire.admin.blocks.file-modal', [
        'idModal' => 'image-list',
        'files' => $this->files,
        'field' => 'file_id',
    ]) --}}

    @include('livewire.admin.blocks.file-modal', [
        'idModal' => 'description',
        'files' => $this->files,
    ])

</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on('isForm', postId => {
                $('#product_list').select2();
                $('#product_list').on('change', function(e) {
                    let id = $(this).select2("val");
                    @this.addProductToList(id)
                });
            });
        });
    </script>
@endpush
