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
                            {{ __('text.product_list') }} > {{ __('text.product_detail') }}
                        </p>
                    </div>
                </div>
            </h4>

            <form>
                <div class="container-fluid">
                    <div class="row">
                        {{-- <div class="col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div> --}}

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Tên người dùng</label>
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
                                <?php
                                $groups = $this->model->getGroups();
                                ?>
                                <label for="user_group_id">Nhóm người dùng</label>
                                <select class="form-control form-control-sm" wire:model='object.user_group_id'>
                                    @if (!$groups->isEmpty())
                                        @foreach ($groups as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('text.email') }}</label>
                                {!! Form::text('email', null, [
                                    'wire:model' => 'object.email',
                                    'class' => 'form-control form-control-sm',
                                    'required',
                                ]) !!}
                                @error('object.email')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ trans('text.txt_phone') }}</label>
                                {!! Form::text('time_range', null, [
                                    'wire:model' => 'object.phone',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => trans('text.txt_phone'),
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <label for="address">{{ trans('text.txt_address') }}</label>
                                {!! Form::text('departure', null, [
                                    'wire:model' => 'object.address',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => trans('text.txt_address'),
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
                                        for="is_active">{{ trans('text.txt_active') }}</label>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-8">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">{{ trans('text.txt_password') }}</label>
                                        <input class="form-control form-control-sm" type="password"
                                            wire:model="password" />
                                        @error('password')
                                            <span class="error-message text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="password_confirmation">{{ trans('text.txt_password_again') }}</label>
                                        <input class="form-control form-control-sm" type="password"
                                            wire:model="password_confirmation" />
                                        @error('password_confirmation')
                                            <span class="error-message text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note">{{ __('text.txt_note') }}</label>
                                <textarea class="form-control" name="note" style="height: 200px" wire:model="object.note"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
