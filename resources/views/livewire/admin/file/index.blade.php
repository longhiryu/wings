<div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            {{ __('text.image_list') }}
                        </div>
                    </div>

                </h4>
                <p class="card-description">
                    Quản lý hình ảnh
                </p>

                <div class="container-fluid p-0">
                    <div class="row d-flex align-items-center">
                        <div class="col-12 col-md-8">
                            <div class="input-group mb-4 mt-4">
                                <input class="form-control table-index-search" type="text" wire:model='keyword'
                                    placeholder="{{ __('text.txt_search') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <form class="form-file" wire:submit.prevent="save">
                                <div class="row gy-0">
                                    <div class="col-8 pe-0">
                                        <input class="form-control form-control-sm" type="file" type="file"
                                            style="line-height: unset" wire:model="photos" multiple accept="image/*"
                                            multiple>
                                    </div>
                                    <div class="col-4">
                                        <div wire:loading wire:target="photos"><i
                                                class="fa-solid fa-spinner fa-spin"></i></div>
                                        <button class="btn btn-secondary btn-sm" type="submit"
                                            wire:loading.remove>{{ __('text.txt_upload') }}</button>
                                    </div>
                                </div>
                                @error('photos.*')
                                    <div class="sub-title text-danger">{{ $message }}</div>
                                @enderror
                            </form>
                        </div>
                    </div>
                    <div class="row gy-4">
                        @foreach ($data as $file)
                            <div class="files_list col-12 col-sm-12 col-md-4 col-lg-4 col-xl-2 pt-2">
                                <div class="wraper">
                                    <div class="file_image">
                                        <img class="img-fluid rounded-top-4" src="{{ asset($file->path) }}"
                                            title="{{ $file->name }}" alt="Card image cap" alt="{{ $file->name }}">
                                    </div>
                                    <div class="file_name size_text bg-white px-2 text-center">
                                        <span class="weight">
                                            ({{ size_as_kb($file->size) }})
                                        </span>
                                        <a class="sub-title text-primary" data-toggle="modal" data-target="#detail-file"
                                            href="javascript:;" wire:click="getFile('{{ $file->id }}')">
                                            {{ str_replace(['-', '_'], ' ', $file->name) }}
                                        </a>
                                    </div>
                                    <div class="file-action bg-white pt-2 text-center">
                                        @if (isset($deleteConfirm[$file->id]) && $deleteConfirm[$file->id])
                                            <button class="my-button btn btn-warning text-white"
                                                wire:click="delete('{{ $file->id }}')">
                                                <i
                                                    class="fa-regular fa-trash-can mr-2"></i>{{ __('text.delete_confirm') }}
                                            </button>
                                        @else
                                            <button class="my-button btn btn-secondary"
                                                wire:click="deleteConfirm('{{ $file->id }}')">
                                                <i class="fa-regular fa-trash-can mr-2"></i>{{ __('text.delete') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="links mt-3 text-right">{{ $data->links() }}</div>

            </div>
        </div>
    </div>

    @include('livewire.admin.file.edit')
</div>
