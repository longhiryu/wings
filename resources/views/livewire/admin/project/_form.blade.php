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
                            Danh sách > Chi tiết dự án
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

                        {!! Form::hidden('locale', Config::get('app.locale'), ['wire:model' => 'object.locale']) !!}
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Tên dự án / PO (*)</label>
                                {!! Form::text('name', null, [
                                    'wire:model' => 'object.name',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => 'Công trình/PO...',
                                    'required',
                                    'maxlength' => '255',
                                ]) !!}
                                @error('object.name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="code">Mã dự án / PO</label>
                                {!! Form::text('code', null, [
                                    'wire:model' => 'object.code',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => 'PROJECT-CROWN, PO-TRE...',
                                    'maxlength' => '50',
                                ]) !!}
                                @error('object.code')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customer_id">{{ __('text.customer') }} (*)</label>
                                <select class="form-control form-control-sm" id="customer_id" name="customer_id"
                                    wire:model="object.customer_id">
                                    @if ($customers)
                                        <option>Chọn Khách hàng</option>
                                        @foreach ($customers as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $object->customer_id == $item->id ? 'selected' : null }}>
                                                {{ $item->presentation_name }} - {{ $item->company_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('object.customer_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tax">{{ __('text.txt_tax_level') }} (*)</label>
                                <select class="form-control form-control-sm" id="tax" name="tax"
                                    wire:model="object.tax">
                                    <option>Chọn mức thuế</option>
                                    <option value="10">10%</option>
                                    <option value="5">5%</option>
                                    <option value="3">3%</option>
                                    <option value="0">0%</option>
                                </select>
                                @error('object.tax')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="consignee_name">Người nhận hàng</label>
                                {!! Form::text('consignee_name', null, [
                                    'wire:model' => 'object.consignee_name',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => 'Họ và tên',
                                ]) !!}
                                @error('object.consignee_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="consignee_phone">Số điện thoại (nhận hàng)</label>
                                {!! Form::text('consignee_phone', null, [
                                    'wire:model' => 'object.consignee_phone',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => 'số điện thoại',
                                ]) !!}
                                @error('object.consignee_phone')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-check form-check-flat form-check-primary" style="margin-top: 40px">
                                    <label class="form-check-label">
                                        <input class="form-check-input" name="finished" type="checkbox" value="1"
                                            wire:model="object.finished"
                                            {{ $object->finished == 1 ? 'checked' : null }} />
                                        Dự án hoàn thành
                                        <i class="input-helper"></i></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                {!! Form::text('address', null, [
                                    'wire:model' => 'object.address',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => 'địa chỉ công trình',
                                ]) !!}
                                @error('object.address')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tax">Danh sách sản phẩm (*)</label>
                                @include('livewire.admin.project.project_product_list')
                            </div>

                        </div>

                        <div class="col-md-12 form-group">
                            <div class="row">
                                <div class="col-6"><label for="long_description">{{ __('text.txt_detail') }}</label>
                                </div>
                                <div class="col-6 text-end">
                                    <a class="sub-title text-primary" data-toggle="modal" data-target="#description"
                                        href="javascript:;">
                                        {{ __('text.txt_chosse_image') }}
                                    </a>
                                </div>
                            </div>
                            <div wire:ignore>
                                <textarea class="tiny-mce" name="long_description" wire:model="object.long_description"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@include('livewire.admin.blocks.tiny-mce-init', ['property' => 'object.long_description'])
