@section('title', 'Order')
<div>
    @if (!$isForm)
        @include('livewire.admin.' . $type . '.list')
    @else
        @can('edit', $model)
            @include('livewire.admin.' . $type . '._form')
        @endcan
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
            Livewire.on('select2_intial', () => {
                $('#product_export_list').select2();
                $('#product_list').select2();
            });

            Livewire.on('isForm', postId => {
                $('#product_list').select2();
                $('#product_list').on('change', function(e) {
                    let data = $(this).select2("val");
                    @this.addProductToList(data)
                });
            });

            Livewire.on('isForm', postId => {
                $('#product_export_list').select2();
                $('#product_export_list').on('change', function(e) {
                    let data = $(this).select2("val");
                    @this.addProductToExportList(data)
                });
            });

        });
    </script>
@endpush
