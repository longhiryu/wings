@section('title', 'Label')
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
            <div class="col-md-12 form-button notification">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-sm btn-success" type="button"
                            wire:click="update()">{{ getTranslation('save') }}</button>
                        <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#exitModal" type="button"
                            wire:click="exit()">
                            {{ getTranslation('exit') }}
                        </button>
                    </div>
                </div>
            </div>
            {{-- {!! Form::hidden('locale', Config::get('app.locale'), ['wire:model' => 'translated.locale']) !!} --}}
        </div>
        <div class="row">
            <div class="col-md-6 block">
                <div class="block-content">
                    <div class="block-title">{{ getTranslation('basic-info') }}</div>
                    <div class="block-body">
                        <div class="form-group">
                            <label for="name">Chọn ngôn ngữ </label>
                            <select wire:model='model.locale' id="" class="form-control form-control-sm custom-select">
                                <option value="vi">Vietnamese</option>
                                <option value="en" {{ Config::get('app.locale') === 'en' ? 'selected' : null }}>English
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content">Nội dung dịch</label>
                            {!! Form::text('name', null, [
                                'class' => 'form-control form-control-sm',
                                'wire:model' => 'model.name',
                                'placeholder' => 'Nội dung',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            <label for="slug">Mã ngắn </label>
                            {!! Form::text('slug', null, [
                                'class' => 'form-control form-control-sm',
                                'placeholder' => 'không nhập khoảng trắng',
                                'wire:model' => 'model.slug'
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
