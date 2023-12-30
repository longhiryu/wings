<div>
    <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#article-{{ $view_id }}">
        <i class="fab fa-searchengin"></i>
        Xem nhanh
    </button>
    <a class="btn btn-sm btn-info" href="{{ $route_edit }}" >
        <i class="fas fa-pen"></i> {{ trans('origin.edit')}}
    </a>
    <button type="button" class="btn btn-sm btn-light delete" route="{{ $route_delete }}">
        <i class="fas fa-trash-alt"></i> {{ trans('origin.delete')}}
    </button>
</div>
