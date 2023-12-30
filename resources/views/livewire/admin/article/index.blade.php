@section('title', 'Article')
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

    @include('livewire.admin.blocks.file-modal', [
        'idModal' => 'description',
        'files' => $this->files,
    ])

</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on('isForm', postId => {
                $('#categories').select2();
                $('#categories').on('change', function(e) {
                    let data = $(this).select2("val");
                    @this.set('categories', data);
                });
            });

        });
        
    </script>
@endpush