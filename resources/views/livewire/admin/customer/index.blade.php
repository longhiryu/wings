@section('title', 'Customer')
<div>
    @if (!$isForm)
        @include('livewire.admin.' . $type . '.list')
    @else
        @can('edit', $model)
            @include('livewire.admin.' . $type . '._form')
        @endcan
    @endif

    {{-- files modal --}}
    @include('livewire.admin.blocks.file-modal', [
        'idModal' => 'description',
        'files' => $this->files,
    ])

</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on('select2_intial', () => {
                $('#address_city_id').select2();
                $('#address_district_id').select2();
                $('#address_ward_id').select2();
            });
            Livewire.on('select2_district', (value) => {
                $('#address_ward_id').select2();
            });
            Livewire.on('isForm', postId => {
                $('#address_city_id').select2();
                $('#address_city_id').on('change', function(e) {
                    let address_city_id = $(this).select2("val");
                    @this.getDistrictData(address_city_id);
                    @this.set('address_city_id', address_city_id)
                });

                $('#address_district_id').select2();
                $('#address_district_id').on('change', function(e) {
                    let address_district_id = $(this).select2("val");
                    @this.getWardData(address_district_id);
                    @this.set('address_district_id', address_district_id)
                });

                $('#address_ward_id').select2();
                $('#address_ward_id').on('change', function(e) {
                    let address_ward_id = $(this).select2("val");
                    @this.set('address_ward_id', address_ward_id)
                });
            });

        });
    </script>
@endpush
