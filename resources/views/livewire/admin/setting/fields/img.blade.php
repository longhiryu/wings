{{-- {{ dd($object) }} --}}
<div class="form-group">
    <div class="row setting__logo my-3">
        <div class="col-md-3 setting_title--center ">
            <div class="setting__title">
                <label>{{ $field['label'] }}</label>
            </div>
        </div>
        <div class="col-md-9 ">
            <div class="setting__image">
                <img src="{{ optional($object)->val ? asset($sysItem->checkImage($object->val)) : asset($sysItem->checkImage($field['value'])) }}" style="width: 50%" data-toggle="modal"
                    wire:model="{{ $field['wire'] }}" data-target="#fileModal" alt="">
            </div>
        </div>
    </div>
</div>
