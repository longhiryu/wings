<!-- Modal HTML -->
<div class="modal fade modal-files" id="{{ $idModal }}" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-confirm modal-lg bg-light">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title">Quản lý hình ảnh</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
              </div>
            <div class="modal-body">
                @if ($files)
                    <div class="container p-0">
                        <div class="row gy-3 align-items-stretch">
                            <div class="col-md-8">
                                <input class="form-control me-2 mr-2" type="search" aria-label="Search" wire:model="file_keyword"
                                    placeholder="Search">
                            </div>
                            <div class="col-md-4">
                                <form class="form-file" wire:submit.prevent="uploadPhotos()">
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
                            @foreach ($files as $item)
                                @if (Str::startsWith($item->mime, 'image/'))
                                    <div class="col-6 col-sm-3 col-md-3 col-lg-2 col-xl-2 ">
                                        <div class="select-image-items rounded-3 p-2 d-flex align-items-center" style="width: 100%; height:100%">
                                            @if (isset($field))
                                                <img data-dismiss="modal" src="{{ asset($item->path) }}" width="100%"
                                                    wire:click="setFile('{{ $item->id }}','{{ $field }}', '{{ $item->path }}')" />
                                            @else
                                                <img src="{{ asset($item->path) }}" width="100%" />
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                {{ $files->links() }}
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .select-image-items{
        box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px 0px;
    }
</style>
