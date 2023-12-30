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
                            {{ __('text.category_list') }} > {{ __('text.category_detail') }}
                        </p>
                    </div>
                </div>

            </h4>

            <form>
                <div class="container-fluid">
                    {!! Form::hidden('locale', Config::get('app.locale'), ['wire:model' => 'translated.locale']) !!}
                    <div class="row">
                        <div class="col-md-4 block">
                            <div class="form-group">
                                <label for="name">{{ trans('category.category_name') }}</label>
                                {!! Form::text('name', null, [
                                    'wire:model' => 'translated.name',
                                    'class' => 'form-control form-control-sm',
                                    'required',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <label for="type">{{ trans('text.txt_type') }}</label>
                                <select class="form-control form-control-sm" name="type" wire:model="object.type">
                                    <option value="default">{{ __('text.txt_default') }}</option>
                                    <option value="product">{{ __('text.product') }}</option>
                                    <option value="article">{{ __('text.article') }}</option>
                                    <option value="file">{{ __('text.file') }}</option>
                                    <option value="customer">{{ __('text.customer') }}</option>
                                    <option value="supplier">{{ __('text.supplier') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type">{{ trans('text.category_parent') }}</label>
                                <select class="form-control form-control-sm" name="parent_id"
                                    wire:model="object.parent_id">
                                    <option value="">{{ __('text.txt_default') }}</option>
                                    @foreach ($cateTree as $category)
                                        <option value="{{ $category['id'] }}">
                                            {{ str_repeat('--', $category['level']) }} {{ $category['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    {!! Form::hidden('is_active', 0, ['wire:model' => 'object.is_active']) !!}
                                    {!! Form::checkbox('is_active', 1, 0, [
                                        'wire:model' => 'object.is_active',
                                        'class' => 'custom-control-input',
                                        'id' => 'is_active',
                                    ]) !!}
                                    <label class="custom-control-label"
                                        for="is_active">{{ __('text.txt_active') }}</label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group mbt-2">
                                <label for="title">{{ trans('category.title') }}</label>
                                {!! Form::text('title', null, [
                                    'wire:model' => 'translated.title',
                                    'class' => 'form-control form-control-sm',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <label for="short_description">{{ trans('category.short_description') }}</label>
                                {!! Form::textarea('short_description', null, [
                                    'wire:model' => 'translated.short_description',
                                    'class' => 'form-control form-control-sm',
                                    'style' => 'height: 100px'
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
                                    <div class="sub-title mt-2">Tỷ lệ tốt nhất: 306px x 306px</div>
                                    <a class="sub-title text-primary" data-toggle="modal" data-target="#image-list"
                                        href="javascript:;">
                                        {{ __('text.txt_chosse_image') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" wire:ignore>
                                <label for="long_description">{{ __('text.txt_detail') }}</label>
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
{{-- <form>
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

            <div class="col-md-12 form-button notification">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-sm btn-success" type="button" wire:click="update()">{{ getTranslation('save') }}</button>
                        <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#exitModal" type="button" wire:click="exit()">
                            {{ getTranslation('exit') }}
                        </button>
                    </div>
                </div>

            </div>

            {!! Form::hidden('locale', Config::get('app.locale'), ['wire:model' => 'translated.locale']) !!}
        </div>
        <div class="row">
            <div class="col-md-4 block">
                <div class="block-content">
                    <div class="block-title">{{ getTranslation('basic-info') }}</div>
                    <div class="block-body">
                        <div class="form-group">
                            <label for="name">{{ trans('category.category_name') }}</label>
                            {!! Form::text('name', null, [
                                'wire:model' => 'translated.name',
                                'class' => 'form-control form-control-sm',
                                'required',
                            ]) !!}

                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                {!! Form::hidden('is_active', 0, ['wire:model' => 'object.is_active']) !!}
                                {!! Form::checkbox('is_active', 1, 0, ['wire:model' => 'object.is_active', 'class' => 'custom-control-input', 'id' => 'is_active']) !!}
                                <label class="custom-control-label" for="is_active">Is active</label>
                            </div>
                        </div>
                        <div class="form-group mbt-2">
                            <label for="title">{{ trans('category.title') }}</label>
                            {!! Form::text('title', null, [
                                'wire:model' => 'translated.title',
                                'class' => 'form-control form-control-sm',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            <label for="short_description">{{ trans('category.short_description') }}</label>
                            {!! Form::textarea('short_description', null, [
                                'wire:model' => 'translated.short_description',
                                'class' => 'form-control form-control-sm',
                            ]) !!}
                            <small class="form-text text-muted">This text use for Google SEO</small>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8 block">
                <div class="block-content">
                    <div class="block-title">{{ getTranslation('detail') }}</div>
                    <div class="block-body">
                        <label for="category.long_description">{{ trans('category.description') }}</label>
                        <x-input.tinymce wire:model="translated.long_description" placeholder="Type anything you want..." />
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.admin.blocks.exit')
    </div>
</form> --}}
