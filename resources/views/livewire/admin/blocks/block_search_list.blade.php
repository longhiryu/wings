<div class="form-group position-relative">
    <label>{{ $label }}</label>
    @if ($this->object->$field)
        {{-- <div class="input-group input-group-sm d-flex align-items-center py-1">
            <span class="badge rounded-pill bg-light text-body fw-bold me-1">
                {{ $object_name }}
            </span>
            <i class="fa-solid fa-circle-xmark remove_keyword_icon cursor-pointer"
                wire:click="removeProp('{{ $field }},{{ $keyword }}')"></i>
        </div> --}}

        <div style="position: relative;">
            <div class="form-control form-control-sm" type="text" style="padding-right: 30px;"
                readonly>{{ $object_name }}</div>
                <i class="fa-solid fa-circle-xmark remove_keyword_icon cursor-pointer"
                    style="position: absolute; top: 50%; transform: translateY(-50%); right: 10px;"
                    wire:click="removeProp('{{ $field }}', '{{ $keyword }}')"></i>
        </div>

        {{-- <button class="my-button btn btn-secondary text-dark" type="button"
            wire:click="removeProp('{{ $field }},{{ $keyword }}')">
            Chọn mới
        </button> --}}
    @else
        <div style="position: relative;">
            <input class="form-control form-control-sm" type="text" style="padding-right: 30px;"
                placeholder="nhập từ khóa..." required wire:model="{{ $keyword }}">
            @if ($this->$keyword)
                <i class="fa-solid fa-circle-xmark remove_keyword_icon cursor-pointer"
                    style="position: absolute; top: 50%; transform: translateY(-50%); right: 10px;"
                    wire:click="removeKeyword('{{ $keyword }}')"></i>
            @endif
        </div>
    @endif

    @if ($items)
        <div class="search-list text_description position-absolute top-100 rounded-1 end-0 start-0">
            <table class="table" id="table_search_list">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="search-list-item cursor-pointer"
                            wire:click="setProp('{{ $field }}','{{ $item->id }}','{{ $keyword }}')">
                            <td><span class="code text-danger pe-2">{{ $item->code }}</span></td>
                            <td><span class="text-dark">{{ $item->name }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    @endif
    @error('object.{{ $field }}')
        <span class="text-danger error">{{ $message }}</span>
    @enderror
</div>
