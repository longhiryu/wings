@section('title', __('text.channel'))
<div>
    @if (!$isForm)
        @include('livewire.admin.'.$type.'.list')
    @else
        @can('edit', $model)
            @include('livewire.admin.'.$type.'._form')
        @endcan
    @endif


</div>

@push('scripts')

@endpush