<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <div class="row d-flex align-items-center">
                    <div class="col-12 col-md-6">
                        {{ $object->presentation_name }}
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
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="presentation_name">Tên khách hàng</label>
                                {!! Form::text('presentation_name', null, [
                                    'wire:model' => 'object.presentation_name',
                                    'class' => 'form-control form-control-sm',
                                    'required',
                                ]) !!}
                                @error('object.presentation_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="company_name">Công ty</label>
                                {!! Form::text('company_name', null, [
                                    'wire:model' => 'object.company_name',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                                @error('object.company_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">{{ __('text.txt_phone') }}</label>
                                {!! Form::text('phone', null, [
                                    'wire:model' => 'object.phone',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                                @error('object.phone')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tax_no">{{ __('text.customer_tax_no') }}</label>
                                {!! Form::text('tax_no', null, [
                                    'wire:model' => 'object.tax_no',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                                @error('object.tax_no')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('text.txt_email') }}</label>
                                {!! Form::text('email', null, [
                                    'wire:model' => 'object.email',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                                @error('object.email')
                                    <span class="error text-danger">{{ $message }}</span>
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
                        <div class="col-md-12">
                            @if ($object->id)
                                @include('livewire.admin.customer.address', ['model' => $this->object])
                            @endif
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
