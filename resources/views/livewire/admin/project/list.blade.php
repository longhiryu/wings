<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <div class="row">
                    <div class="col-12 col-md-6">
                        Danh sách dự án
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        @include('livewire.admin.blocks.add_new_button', ['model' => $model])
                    </div>
                </div>
            </h4>
            <p class="card-description">
                Danh sách Dự án bạn có thể nhập từ khóa tìm kiếm theo tên hoặc mã dự án
            </p>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label>{{ __('text.txt_keyword') }}</label>
                        <input class="form-control table-index-search" type="text" wire:model='keyword'
                            placeholder="Tên dự án hoặc mã dự án">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-striped list table">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>{{ __('text.txt_status') }}</th>
                            <th>{{ __('text.txt_name') }}</th>
                            <th>{{ __('text.txt_code') }}</th>
                            <th>{{ __('text.txt_value_before_tax') }}</th>
                            <th>{{ __('text.txt_tax_value') }}</th>
                            <th>{{ __('text.txt_value_after_tax') }}</th>
                            <th>{{ __('text.txt_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <?php
                            $projectValue = $item->getProjectValue();
                            $taxValue = $item->getTaxValue();
                            $totalValue = $projectValue + $taxValue;
                        ?>
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td nowrap>
                                    @if ($item->finished)
                                        <span class="text-success">Hoàn thành</span>
                                    @else
                                        <span class="text-danger">Chưa hoàn thành</span>
                                    @endif
                                </td>
                                <td class="text-start">
                                    <span class="title cursor-pointer" wire:click="edit({{ $item->id }})">
                                        {{ $item->name }}
                                    </span>
                                    <br />
                                    <div class="sub-title mt-2">
                                        {{ $item->customer->presentation_name }}
                                    </div>
                                    <div class="sub-title fw-bold">
                                        {{ $item->customer->company_name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success fw-bold">{{ $item->code }}</small>
                                </td>
                                <td>
                                    <span class="text-primary fw-bold">{{ my_format_number($projectValue) }}</span>
                                </td>
                                <td class="text-danger">
                                    <span>({{ $item->tax.'%' }})</span> <span class="fw-bold">{{ my_format_number($taxValue) }}</span>
                                </td>
                                <td>
                                    <span class="text-success fw-bold">{{ my_format_number($totalValue) }}</span>
                                </td>
                                <td nowrap>
                                    @include('livewire.admin.blocks.index_action_buttons', [
                                        'item' => $item,
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="links mt-3 text-right">{!! $links !!}</div>
            </div>
        </div>
    </div>
</div>
