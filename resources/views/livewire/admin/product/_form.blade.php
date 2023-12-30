<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <div class="row d-flex align-items-center">
                    <div class="col-12 col-md-6">
                        {{ $translated->name }}
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

                        {!! Form::hidden('locale', Config::get('app.locale'), ['wire:model' => 'translated.locale']) !!}
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm (*)</label>
                                {!! Form::text('name', null, [
                                    'wire:model' => 'translated.name',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => trans('article.placehover_name_article'),
                                    'required',
                                ]) !!}
                                @error('translated.name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="sku">SKU*</label>
                                {!! Form::text('sku', null, [
                                    'wire:model' => 'object.sku',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => 'PRO001, ROPE003...',
                                    'maxlength' => '20',
                                ]) !!}
                                @error('object.sku')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="supplier_id">{{ __('text.supplier') }} (*)</label>
                                <select class="form-control form-control-sm" id="supplier_id" name="supplier_id"
                                    wire:model="object.supplier_id">
                                    @if ($suppliers)
                                        <option>Chọn Nhà cung cấp</option>
                                        @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $object->supplier_id == $item->id ? 'selected' : null }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('object.supplier_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
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
                                <label for="title">{{ trans('article.title') }}</label>
                                {!! Form::text('title', null, [
                                    'wire:model' => 'translated.title',
                                    'class' => 'form-control form-control-sm',
                                    'maxlength' => '255',
                                    'required',
                                ]) !!}
                                @error('translated.title')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="short_description">{{ trans('article.short_description') }}</label>
                                {!! Form::textarea('short_description', null, [
                                    'class' => 'form-control form-control-sm',
                                    'wire:model' => 'translated.short_description',
                                    'row' => '6',
                                    'style' => 'height: 100px',
                                    'maxlength' => '255',
                                ]) !!}
                                <div class="sub-title mt-2">{{ __('text.guide_google_seo') }}</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unit">Đơn vị tính (*)</label>
                                <select class="form-control form-control-sm" id="unit" name="unit"
                                    wire:model="object.unit" required>
                                    <option>Chọn đơn vị tính</option>
                                    @foreach (config('units') as $item)
                                        <option value="{{ $item }}"
                                            {{ $object->unit == $item ? 'selected' : null }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('object.unit')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rating">Định mức (rating)</label>
                                {!! Form::text('rating', null, [
                                    'wire:model' => 'object.rating',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => '2kg/100m',
                                    'maxlength' => '100',
                                ]) !!}
                                @error('object.rating')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price">{{ trans('product.price') }}:
                                    @if (isset($object->price) && $object->price > 0)
                                        <span
                                            class="text-secondary">{{ number_format($object->price, 0, ',', '.') }}</span>
                                    @endif
                                </label>
                                <input class="form-control form-control-sm" type="number" wire:model="object.price" />
                                @error('object.price')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="form-check form-check-flat form-check-primary">
                                    <label class="form-check-label">
                                        <input class="form-check-input" name="is_active" type="checkbox" value="1"
                                            wire:model="object.is_active"
                                            {{ $object->is_active == 1 ? 'checked' : null }} />
                                        Kích hoạt
                                        <i class="input-helper"></i></label>
                                </div>
                                <div class="form-check form-check-flat form-check-primary">
                                    <label class="form-check-label">
                                        <input class="form-check-input" name="material" type="checkbox" value="1"
                                            wire:model="object.material"
                                            {{ $object->material == 1 ? 'checked' : null }} />
                                        Nguyên liệu (dây, gỗ, giấy...)
                                        <i class="input-helper"></i></label>
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
                                <textarea class="tiny-mce" name="long_description" wire:model="translated.long_description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@include('livewire.admin.blocks.tiny-mce-init')
