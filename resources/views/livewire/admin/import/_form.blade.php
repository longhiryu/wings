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
                            {{ __('text.import_list') }} > {{ __('text.import_detail') }}
                        </p>
                    </div>
                </div>
            </h4>

            <form>
                <div class="container-fluid">
                    {{-- <div class="row">
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
                    </div> --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Tên phiếu nhập (*)</label>
                                {!! Form::text('name', null, [
                                    'wire:model' => 'object.name',
                                    'class' => 'form-control form-control-sm',
                                    'required',
                                    'placeholder' => 'Nội dung nhập kho',
                                    'disabled' => $this->object->is_imported
                                ]) !!}
                                @error('object.name')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Người tạo phiếu</label>
                                <input class="form-control form-control-sm" value="{{ auth()->user()->name }}"
                                    disabled />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('text.inventory') }} (*)</label>
                                <select class="form-control form-control-sm" {{ !$this->object->is_imported ?: 'disabled' }} wire:model="object.inventory_id">
                                    <option value="">Vui lòng chọn</option>
                                    @foreach ($inventories as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('object.inventory_id')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Loại phiếu nhập (*)</label>
                                <select class="form-control form-control-sm" id="type" {{ !$this->object->is_imported ?: 'disabled' }} wire:model="object.type">
                                    <option>Vui lòng chọn</option>
                                    @foreach ($types as $key => $type)
                                        <option value="{{ $key }}">
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('object.type')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group position-relative">
                                <label>Nguồn nhập hàng:</label>
                                @if ($this->object->supplier_id or $this->object->customer_id)
                                    <br />
                                    <span class="badge rounded-pill bg-warning text-body fw-bold">
                                        {{ getSupplierNameById($this->object->supplier_id) ?? getCustomerNameById($this->object->customer_id) }}
                                    </span>
                                    <button class="my-button btn btn-secondary text-dark me-2" type="button" {{ !$this->object->is_imported ?: 'disabled' }}
                                        wire:click="removeProp('customer_id,supplier_id', true)">
                                        Chọn mới
                                    </button>
                                @else 
                                    <input class="form-control form-control-sm" name="source_text_search" {{ !$this->object->is_imported ?: 'disabled' }}
                                        wire:model="source_text_search" />
                                    @if ($source_import_data)
                                        <div
                                            class="search-list text_description position-absolute top-100 rounded-1 bg-light end-0 start-0 p-1">
                                            @foreach ($source_import_data as $source)
                                                <div class="search-list-item my-1 cursor-pointer"
                                                    wire:click="setSourceImport('{{ $source->id }}')">
                                                    {{ optional($source)->code }} -
                                                    {{ $source->name ?? $source->company_name }}
                                                </div>
                                            @endforeach
                                        </div>

                                    @endif
                                @endif

                                @error('object.customer_id')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                                @error('object.supplier_id')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group position-relative">
                                <label for="project">Dự án:</label>
                                @if ($this->object->project_id)
                                    <br />
                                    <span class="badge rounded-pill bg-warning text-body fw-bold">
                                        {{ getProjectNameById($this->object->project_id) }}
                                    </span>
                                    <button class="my-button btn btn-secondary text-dark me-2" type="button" {{ !$this->object->is_imported ?: 'disabled' }}
                                        wire:click="removeProp('project_id')">
                                        Chọn mới
                                    </button>
                                @else
                                    {!! Form::text('project', null, [
                                        'wire:model' => 'project_keyword',
                                        'class' => 'form-control form-control-sm',
                                        'required',
                                        'placeholder' => 'Nội dung nhập kho',
                                        'disabled' => $this->object->is_imported
                                    ]) !!}
                                @endif

                                @if ($project_list)
                                    <div
                                        class="search-list text_description position-absolute top-100 rounded-1 bg-light end-0 start-0 p-1">
                                        @foreach ($project_list as $project)
                                            <div class="search-list-item my-1 cursor-pointer"
                                                wire:click="setProjectId('{{ $project->id }}','{{ $project->name }}')">
                                                <span class="text-danger">{{ $project->code }}</span> |
                                                <span class="">{{ $project->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @error('object.project_id')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 import_product_list mb-4">
                            @include('livewire.admin.import.import_product_list')
                        </div>

                        <div class="col-md-12 form-group">
                            <div class="row">
                                <div class="col-6"><label for="note">Ghi chú</label>
                                </div>
                                <div class="col-6 text-end">
                                    <a class="sub-title text-primary" data-toggle="modal" data-target="#description"
                                        href="javascript:;">
                                        {{ __('text.txt_chosse_image') }}
                                    </a>
                                </div>
                            </div>
                            <div wire:ignore>
                                <textarea class="tiny-mce" name="note" wire:model="object.note"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@include('livewire.admin.blocks.tiny-mce-init', ['property' => 'object.note'])
