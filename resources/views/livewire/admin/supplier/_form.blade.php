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
                    {{-- <div class="row">
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
                    </div> --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Tên nhà cung cấp (*)</label>
                                {!! Form::text('name', null, [
                                    'wire:model' => 'object.name',
                                    'class' => 'form-control form-control-sm',
                                    'required',
                                ]) !!}
                                @error('object.name')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="code">Mã Nhà cung cấp (*)</label>
                                {!! Form::text('code', null, [
                                    'wire:model' => 'object.code',
                                    'class' => 'form-control form-control-sm',
                                    'required'
                                ]) !!}
                                @error('object.code')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="presentation_name">Người đại diện</label>
                                {!! Form::text('presentation_name', null, [
                                    'wire:model' => 'object.presentation_name',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                                @error('object.presentation_name')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('text.txt_phone') }}</label>
                                {!! Form::text('phone', null, [
                                    'wire:model' => 'object.phone',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                                @error('object.phone')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('text.txt_email') }}</label>
                                {!! Form::text('email', null, [
                                    'wire:model' => 'object.email',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                                @error('object.email')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id">{{ __('text.category') }}</label>
                                <select class="form-control form-control-sm" name="category_id"
                                    wire:model="object.category_id">
                                    @isset($tree)
                                        <option value="">{{ __('text.txt_default') }}</option>
                                        @foreach ($tree as $category)
                                            <option value="{{ $category['id'] }}">
                                                {{ str_repeat('--', $category['level']) }}
                                                {{ $category['name'] }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('object.category_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="company">Công ty</label>
                                {!! Form::text('company', null, [
                                    'wire:model' => 'object.company',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                                @error('object.compnay')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('text.txt_address') }}</label>
                                {!! Form::text('address', null, [
                                    'wire:model' => 'object.address',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                                @error('object.address')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tax_no">Mã số thuế</label>
                                {!! Form::text('tax_no', null, [
                                    'wire:model' => 'object.tax_no',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                                @error('object.tax_no')
                                    <span class="text-danger error">{{ $message }}</span>
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
                                        for="is_active">{{ trans('text.txt_is_active') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image">{{ trans('article.image') }}</label>
                                {!! Form::text('image', null, [
                                    'class' => 'form-control form-control-sm',
                                    'id' => 'img',
                                    'wire:model' => 'image',
                                ]) !!}
                                <a class="sub-title text-danger" href="javascript:;" wire:click="removeImage()">
                                    {{ __('text.txt_remove_image') }}
                                </a>
                                <br />
                                <div class="text-center">
                                    <img class="mb-2" id="view-img" src="{{ asset($image) }}" width="80%">
                                    <div class="sub-title mt-2">Tỷ lệ tốt nhất: 855px x 475px</div>
                                    <a class="sub-title text-primary" data-toggle="modal" data-target="#image-list"
                                        href="javascript:;">
                                        {{ __('text.txt_chosse_image') }}
                                    </a>
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
