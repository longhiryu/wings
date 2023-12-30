@extends('star-admin.master')
@section('title', 'Setting')
@section('content')
    <form method="POST" action="{{ route('setting.update') }}">
        <input type="hidden" name="group" value="admin" />
        @method('PUT')
        @csrf
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <div class="row d-flex align-items-center">
                            <div class="col-12 col-md-6">
                                {{ __('text.txt_setting') }} Admin
                            </div>
                            <div class="col-12 col-md-6 d-flex justify-content-end">
                                <button class="btn btn-sm btn-success" type="submit">{{ __('text.btn_save') }}</button>
                            </div>
                            <div class="col-md-12">
                                <p class="card-description">
                                    Thông số dành cho Admin
                                </p>
                            </div>
                        </div>
                    </h4>

                    <div class="container-fluid">
                        <div class="row">
                            @foreach ($setting['admin'] as $item)
                                @php
                                    $value = $admin
                                        ->filter(function ($one) use ($item) {
                                            return $one->name == $item['name'];
                                        })
                                        ->first();
                                @endphp
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="{{ $item['name'] }}">{{ $item['title'] }}</label>
                                        @if ($item['type'] == 'text' or $item['type'] == 'email' or $item['type'] == 'number')
                                            <input class="form-control form-control-sm" name="{{ $item['name'] }}"
                                                type="{{ $item['type'] }}"
                                                value="{{ $value != null ? $value->val : $item['default'] }}" />
                                        @elseif ($item['type'] == 'textarea')
                                            <textarea class="form-control form-control-sm" name="{{ $item['name'] }}">{{ $value != null ? $value->val : $item['default'] }}</textarea>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('setting.update') }}">
        <input type="hidden" name="group" value="website" />
        @method('PUT')
        @csrf
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <div class="row d-flex align-items-center">
                        <div class="col-12 col-md-6">
                            {{ __('text.txt_setting') }} Website
                        </div>
                        <div class="col-12 col-md-6 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" type="submit">{{ __('text.btn_save') }}</button>
                        </div>
                        <div class="col-md-12">
                            <p class="card-description">
                                Thông số dành cho Website
                            </p>
                        </div>
                    </div>
                </h4>

                <div class="container-fluid">
                    <div class="row">
                        @foreach ($setting['website'] as $item)
                            @php
                                $value = $website
                                    ->filter(function ($one) use ($item) {
                                        return $one->name == $item['name'];
                                    })
                                    ->first();
                            @endphp
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="{{ $item['name'] }}">{{ $item['title'] }}</label>
                                    @if ($item['type'] == 'text' or $item['type'] == 'email' or $item['type'] == 'number')
                                        <input class="form-control form-control-sm" name="{{ $item['name'] }}"
                                            type="{{ $item['type'] }}"
                                            value="{{ $value != null ? $value->val : $item['default'] }}" />
                                    @elseif ($item['type'] == 'textarea')
                                        <textarea class="form-control form-control-sm" name="{{ $item['name'] }}" style="height: 80px;">{{ $value != null ? $value->val : $item['default'] }}</textarea>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection
