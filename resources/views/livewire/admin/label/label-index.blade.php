<div>
    <div class="col-md-12 block">
        <div class="block-content">
            <div class="block-title">
                <div class="row">
                    <div class="col-md-10">{{ trans('article.list') }}</div>
                    <div class="col-md-2 text-right">
                        <a class="btn btn-success btn-sm" href="{{ route('label.create') }}">
                            <i class="fas fa-plus-square mr-2"></i>{{ getTranslation('create') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="block-body">
                <div class="input-group mb-2 mt-4">
                    <input class="form-control table-index-search" type="text" wire:model='keyword'
                        placeholder="{{ getTranslation('search') }}">
                </div>
                <div class="table-index-pagination">{!! $links !!}</div>
                <table class="table index table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nội dung</th>
                            <th>Ngôn ngữ</th>
                            <th>Mă ngắn</th>
                            <th>{{ trans('origin.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->locale }} </td>
                                <td>{{ $item->slug }}</td>
                                <td nowrap>
                                    <button class="btn mr-2 table-btn btn-sm">
                                        <a href="{{ route('label.edit', $item->id) }}">
                                            <i class="fa-regular fa-pen-to-square mr-2"></i>Edit</a>
                                    </button>
                                    <button class="btn table-btn btn-option btn-sm" data-toggle="modal"
                                        data-target="#deleteModal" aria-hidden="true"
                                        wire:click="$set('modelID',{{ $item->id }})">
                                        <i class="fa-regular fa-trash-can mr-2"></i>Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        @if ($data->hasPages())
                            <tr>
                                <td class="table-index-pagination" colspan="5">{!! $links !!}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Delete Modal Confirm --}}
    @include('livewire.admin.blocks.delete')
</div>
