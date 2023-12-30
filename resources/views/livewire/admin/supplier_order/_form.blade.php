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
                            Đơn đặt hàng > Chi tiết
                        </p>
                    </div>
                </div>
            </h4>

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
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Tên đơn đặt hàng (*)</label>
                                <input class="form-control form-control-sm" name="name" type="text"
                                    wire:model="object.name" required />
                                @error('object.name')
                                    <span class="text-danger error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            @include('livewire.admin.blocks.block_search_list', [
                                'label' => 'Nhà Cung cấp',
                                'object_name' => getSupplierNameById($this->object->supplier_id),
                                'items' => $suppliers,
                                'field' => 'supplier_id',
                                'keyword' => 'supplier_keyword',
                            ])
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tax">Mức thuế (*)</label>
                                <select class="form-control form-control-sm" id="tax" name="tax"
                                    wire:model="object.tax">
                                    <option value="10">10%</option>
                                    <option value="8">8%</option>
                                    <option value="3">3%</option>
                                    <option value="0">0%</option>
                                </select>
                                @error('object.tax')
                                    <span class="error text-danger">{{ $message }}</span>
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
                            @include('livewire.admin.blocks.block_search_list', [
                                'label' => 'Dự án',
                                'object_name' => getProjectNameById($this->object->project_id),
                                'items' => $projects,
                                'field' => 'project_id',
                                'keyword' => 'project_keyword',
                            ])
                        </div>
                        <div class="col-md-12">
                            @include('livewire.admin.supplier_order.supplier_order_product_list')
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
