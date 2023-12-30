<!-- Modal HTML -->
<div class="modal fade" id="detail-file" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-confirm modal-lg">
        <div class="modal-content p-4">
            @if ($model)
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img class="img-fluid" src="{{ asset($model['path']) }}" title="{{ $model['name'] }}"
                                    alt="Card image cap" alt="{{ $model['name'] }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" data-dismiss="modal" type="button">Cancel</button>
                </div>
            @endif
        </div>
    </div>
</div>
