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
                            {{ __('text.supplier_list') }} > {{ __('text.supplier_detail') }}
                        </p>
                    </div>
                </div>
            </h4>

            <form>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Tên kho hàng</label>
                                {!! Form::text('name', null, [
                                    'wire:model' => 'object.name',
                                    'class' => 'form-control form-control-sm',
                                    'required',
                                ]) !!}
                                @error('object.name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('text.txt_address') }}</label>
                                {!! Form::text('address', null, [
                                    'wire:model' => 'object.address',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">{{ __('text.txt_phone') }}</label>
                                {!! Form::text('phone', null, [
                                    'wire:model' => 'object.phone',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('text.txt_email') }}</label>
                                {!! Form::text('email', null, [
                                    'wire:model' => 'object.email',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
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
                                        for="is_active">{{ trans('text.txt_is_active') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <div class="row">
                                <div class="col-6"><label for="note">Ghi chú</label>
                                </div>
                                <div class="col-6 text-end">
                                    <a class="sub-title text-primary" data-toggle="modal" data-target="#description"
                                        href="javascript:;">
                                        {{ __('text.txt_chosse_image') }}
                                    </a>
                                </div>
                            </div>
                            <div wire:ignore>
                                <textarea class="tiny-mce" name="note" wire:model="object.note"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@include('livewire.admin.blocks.tiny-mce-init', ['property' => 'object.note'])
