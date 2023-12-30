<?php
$disable = $object->exported == 1 ? true : false;
?>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <div class="row d-flex align-items-center">
                    <div class="col-12 col-md-6">
                        {{ $object->name }}
                        @if ($object->exported)
                            <span class="text-success">(Đã xuất hàng)</span>
                        @endif
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
                                <label for="name">{{ __('text.txt_name') }}</label>
                                {!! Form::text('name', null, [
                                    'wire:model' => 'object.name',
                                    'class' => 'form-control form-control-sm',
                                    'required',
                                    'disabled' => $disable ? 'disabled' : null,
                                ]) !!}
                                @error('object.name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category_id">{{ __('text.customer') }}</label>
                                <select class="form-control form-control-sm" wire:model="object.customer_id"
                                    {{ $disable ? 'disabled' : null }}>
                                    <option>Chọn khách hàng</option>
                                    @if ($customers)
                                        @foreach ($customers as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == optional($object->customer)->id ? 'selected' : null }}>
                                                {{ $item->presentation_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('object.customer_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category_id">{{ __('text.address') }}</label>
                                <select class="form-control form-control-sm" wire:model="object.address_id"
                                    {{ $disable ? 'disabled' : null }}>
                                    <option>Chọn địa chỉ</option>
                                    @if ($addresses)
                                        @foreach ($addresses as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == optional($object->address)->id ? 'selected' : null }}>
                                                {{ $item->showAddress($item->id) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('object.address_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            @if ($object->id && !$object->exported)
                                <div class="form-group">
                                    <label>Hệ thống sẽ tiến hành trừ kho và tính giá trị đơn hàng vào
                                        thống</label>
                                    <button class="my-button btn btn-primary text-white" type="button"
                                        wire:click="checkStock()">
                                        <i class="fa-solid fa-cloud-arrow-up me-2"></i>Xuất kho
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-12">
                            @include('livewire.admin.order.order_product_list')
                        </div>

                        <div class="col-md-12">
                            @include('livewire.admin.order.order_export')
                        </div>

                        <div class="col-md-12 form-group mt-4">
                            <div class="row">
                                <div class="col-6"><label for="note">{{ __('text.txt_detail') }}</label>
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
