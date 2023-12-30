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
                            Danh sách Channel > {{ $object->name }}
                        </p>
                    </div>
                </div>

            </h4>

            <form>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ trans('text.channel_name') }}</label>
                                {!! Form::text('name', null, [
                                    'wire:model' => 'object.name',
                                    'class' => 'form-control form-control-sm',
                                    'required',
                                ]) !!}
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

                                <div class="custom-control custom-switch">
                                    {!! Form::hidden('is_default', 0, ['wire:model' => 'object.is_default']) !!}
                                    {!! Form::checkbox('is_default', 1, 0, [
                                        'wire:model' => 'object.is_default',
                                        'class' => 'custom-control-input',
                                        'id' => 'is_default',
                                    ]) !!}
                                    <label class="custom-control-label"
                                        for="is_default">{{ __('text.txt_default') }}</label>
                                </div>
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

            {!! Form::hidden('locale', Config::get('app.locale'), ['wire:model' => 'object.locale']) !!}
        </div>
        <div class="row">
            <div class="col-md-4 block">
                <div class="block-content">
                    <div class="block-title">{{ getTranslation('basic-info') }}</div>
                    <div class="block-body">
                        <div class="form-group">
                            <label for="name">{{ trans('category.category_name') }}</label>
                            {!! Form::text('name', null, [
                                'wire:model' => 'object.name',
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
                                'wire:model' => 'object.title',
                                'class' => 'form-control form-control-sm',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            <label for="short_description">{{ trans('category.short_description') }}</label>
                            {!! Form::textarea('short_description', null, [
                                'wire:model' => 'object.short_description',
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
                        <x-input.tinymce wire:model="object.long_description" placeholder="Type anything you want..." />
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.admin.blocks.exit')
    </div>
</form> --}}
