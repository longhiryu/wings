<!-- Modal HTML -->
<div class="modal fade" id="exitModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="material-icons">&#xE5CD;</i>
                </div>
                <h4 class="modal-title">Are you sure?</h4>
                <button class="close" data-dismiss="modal" type="button" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Data unsaved will be lost.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" data-dismiss="modal" type="button">Cancel</button>
                <button class="btn btn-danger" data-dismiss="modal" type="button" wire:click="exit(true)">Exit</button>
            </div>
        </div>
    </div>
</div>
