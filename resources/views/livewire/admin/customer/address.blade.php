<div class="rounded-2 container mb-4 border py-4">
    <div class="row">
        <div class="col-md-12 pb-3 fs-6 fw-bold">
            {{ __('text.address') }}
        </div>
        <div class="col-md-12 pb-2">
            @if ($addresses)
                    @foreach ($addresses as $item)
                    <div class="addresses_wraper pb-2">
                        <span wire:click="removeAddress('{{ $item->id }}')" class="cursor-pointer"><i class="fa-solid fa-trash text-danger"></i></span>
                        <span>{{ $item->address }}, {{ $item->ward->name }}, {{ $item->district->name }},
                            {{ $item->city->name }}</span>
                    </div>        
                    @endforeach
                
            @endif
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ __('text.address_detail') }}</label>
                <input class="form-control form-control-sm" type="text" wire:model="address" />
                @error('address')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="address_city_id">{{ __('text.address_city') }}</label>
                <div wire:key="city-select-field-model-version-{{ $city_iteration }}">
                <div class="select2-purple" wire:ignore>
                    <select class="select-2 select2 p-0" id="address_city_id" data-dropdown-css-class="select2-purple"
                        style="width: 100%;">
                        <option>Chọn tỉnh thành</option>
                        @if ($cities)
                            @foreach ($cities as $item)
                                <option value="{{ $item['id'] }}">
                                    {{ $item['name'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                </div>
                @error('address_city_id')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="address_district_id">{{ __('text.address_district') }}</label>
                <div wire:key="dis-select-field-model-version-{{ $district_iteration }}">
                    <div class="select2-purple" wire:ignore>
                        <select class="select-2 select2 p-0" id="address_district_id"
                            data-dropdown-css-class="select2-purple" style="width: 100%;">
                            <option>Chọn quận huyện</option>
                            @if ($districts)
                                @foreach ($districts as $item)
                                    <option value="{{ $item['id'] }}">
                                        {{ $item['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>

                    </div>
                </div>
                @error('address_district_id')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="address_ward_id">{{ __('text.address_ward') }}</label>
                <div wire:key="ward-select-field-model-version-{{ $ward_iteration }}">
                    <div class="select2-purple" wire:ignore>
                        <select class="select-2 select2 p-0" id="address_ward_id"
                            data-dropdown-css-class="select2-purple" style="width: 100%;">
                            <option>Chọn phường xã</option>
                            @if ($wards)
                                @foreach ($wards as $item)
                                    <option value="{{ $item['id'] }}">
                                        {{ $item['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>

                    </div>
                </div>
                @error('address_ward_id')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-12 text-end">
            <button class="my-button btn btn-primary me-2 text-white" type="button" wire:click="addAddress()">
                <i class="fa-solid fa-cloud-arrow-up me-2"></i>{{ __('text.address_add') }}
            </button>
        </div>
    </div>
</div>
