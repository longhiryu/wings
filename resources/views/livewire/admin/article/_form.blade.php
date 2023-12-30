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
                            {{ __('text.article_list') }} > {{ __('text.article_detail') }}
                        </p>
                    </div>
                </div>
            </h4>

            <form>
                <div class="container-fluid">
                    {!! Form::hidden('locale', Config::get('app.locale'), ['wire:model' => 'translated.locale']) !!}

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ trans('article.article_name') }}</label>
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
                                <label for="category_id">{{ __('text.category') }}</label>
                                {{-- <div wire:key="select-field-model-version-{{ $iteration }}">
                                    <div class="select2-purple" wire:ignore>
                                        <select class="select-2 select2" id="categories"
                                            data-placeholder="Thêm tag" data-dropdown-css-class="select2-purple"
                                            style="width: 100%;" multiple="multiple">
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $object->categories && $object->categories->contains('id', $item->id) ? 'selected' : null }}>
                                                    {{ isset($item->translated) ? $item->translate('name') : 'Untitled(' . $item->id . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                @isset($tree)
                                    <select class="form-control form-control-sm" name="category_id"
                                        wire:model="object.category_id">
                                        <option value="">{{ __('text.txt_default') }}</option>
                                        @foreach ($tree as $category)
                                            <option value="{{ $category['id'] }}">
                                                {{ str_repeat('--', $category['level']) }}
                                                {{ $category['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endisset ()
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
                                @error('object.is_active')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">{{ trans('article.title') }}</label>
                                {!! Form::text('title', null, [
                                    'wire:model' => 'translated.title',
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => trans('article.placehover_title'),
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
                                    'style' => 'height: 100px',
                                ]) !!}
                                <div class="sub-title mt-2">{{ __('text.guide_google_seo') }}</div>
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
                                    <div class="sub-title mt-2">Tỷ lệ tốt nhất: 855px x 535px</div>
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
