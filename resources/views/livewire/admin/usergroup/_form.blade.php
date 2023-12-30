<div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <div class="row d-flex align-items-center">
                        <div class="col-12 col-md-6">
                            {{ $object->name }}
                        </div>
                        <div class="col-12 col-md-6 d-flex justify-content-end">
                            @include('livewire.admin.blocks.form_controller_buttons', [
                                'exitConfirm' => $exitConfirm,
                            ])
                        </div>
                        <div class="col-md-12">
                            <p class="card-description">
                                Nhóm > Chi tiết nhóm
                        </div>
                    </div>
                </h4>

                <form>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Tên nhóm</label>
                                    {!! Form::text('name', null, [
                                        'wire:model' => 'object.name',
                                        'class' => 'form-control form-control-sm',
                                        'required',
                                    ]) !!}
                                    @error('object.name')
                                        <span class="error-message text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        {!! Form::hidden('is_active', 0, ['wire:model' => 'object.is_active']) !!}
                                        {!! Form::checkbox('is_active', 1, null, [
                                            'wire:model' => 'object.is_active',
                                            'class' => 'custom-control-input',
                                            'id' => 'is_active',
                                        ]) !!}
                                        <label class="custom-control-label"
                                            for="is_active">{{ trans('text.txt_active') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($object->id != null)
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))">
                    <div class="card-body">
                        <h4 class="card-title">
                            <div class="row d-flex align-items-center">
                                <div class="col-12 col-md-6">
                                    Phân quyền
                                </div>
                                <div class="col-12 col-md-6 d-flex justify-content-end">
                                    <button class="my-button btn btn-success text-white">
                                        <i class="fa-solid fa-cloud-arrow-up me-2"></i>{{ __('text.btn_save') }}
                                    </button>
                                </div>
                                <div class="col-md-12">
                                    <p class="card-description">
                                        Phân quyền cho nhóm hiện tại, đánh dấu vào các quyền cho phép Nhóm được truy cập
                                </div>
                            </div>
                        </h4>
                        <div class="container-fluid">
                            <div class="row">
                                @foreach ($groups as $type => $item)
                                    <div class="col-md-3 pb-2">
                                        <div class="fw-bold text-capitalize">{{ __('text.'.$type) }}</div>
                                        @foreach ($item as $value)
                                            <?php
                                            $checked = false;
                                            if (isset($allowed)) {
                                                $checked = $allowed->contains(function ($object, $key) use ($value) {
                                                    return $object->id == $value->id;
                                                });
                                            }
                                            ?>
                                            <div class="form-check form-check-flat form-check-primary">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" name="{{ $value->slug }}"
                                                        type="checkbox" value="{{ $value->id }}"
                                                        {{ $checked ? 'checked' : null }} />
                                                    {{ $value->name }}
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
