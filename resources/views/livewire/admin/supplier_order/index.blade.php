@section('title', 'Supplier Order')
<div>
    @if (!$isForm)
        @include('livewire.admin.' . $type . '.list')
    @else
        @can('edit', $model)
            @include('livewire.admin.' . $type . '._form')
        @endcan
    @endif
</div>
