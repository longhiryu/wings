<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $import->name }}</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
        }

        #wrap {
            width: 100%;
            margin: auto;
        }

        .bold {
            font-weight: 500;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .text-start {
            text-align: left;
        }

        table.list {
            border-collapse: collapse;
        }

        .list,
        .list th,
        .list td {
            border: 1px solid black;
        }

        .list th {
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div id="wrap">
        <table class="header" style="width: 100%">
            <tr>
                <td width="40%">
                    <img src="https://www.tre-furniture.com/upload/Tre2023-2.png" style="width: 100%; height: auto;" />
                </td>
                <td>
                    <div class="info" style="text-align: right;">
                        <div
                            style="padding: 5px; border: thin solid #0C7572; color: #0C7572; border-radius: 8px; display: inline-block;
                        width: auto; /* Đặt chiều rộng tự động */">
                            <div style="text-align: center"><span class="bold">PHIẾU NHẬP KHO</span></div>
                            <div style="text-align: center">Mã phiếu: {{ $import->code }}</div>
                            <div style="text-align: center">Nguồn nhập: {{ optional($import->supplier)->code ?? $types[$import->type] }}</div>
                        </div>

                    </div>
                </td>
            </tr>
        </table>

        <table style="width: 100%" cell-spacing="10">
            <tr>
                <td width="50%">
                    <div class="title" style="border: thin solid; border-radius: 5px; padding:8px; margin-top: 20px;">
                        <span class="bold">Nguồn nhập:</span> {{ optional($import->supplier)->name ?? optional($import->customer)->company_name ?? $types[$import->type] }}<br />
                        <span class="bold">Điện thoại:</span> {{ optional($import->supplier)->phone ?? optional($import->customer)->phone }}<br />
                        <span class="bold">Địa chỉ:</span> {{ optional($import->supplier)->address ?? optional($import->customer)->address }}<br />
                    </div>
                </td>
                <td>
                    <div class="title" style="margin-top: 15px; margin-left:55px">
                        <span class="bold">Người tạo phiếu:</span> {{ $import->user->name }}<br />
                        <span class="bold">Trạng thái:</span>
                        {{ $import->received ? 'Chưa nhập hàng' : 'Đã nhập hàng' }}<br />
                        <span class="bold">Ngày tạo:</span> {{ formatDateTime($import->created_at, 'datetime') }}<br />
                        <span class="bold">Ngày nhập:</span>
                        {{ $import->import_date ?: formatDateTime($import->import_date, 'datetime') }}<br />
                        <span class="bold">Kho nhập:</span> {{ $import->inventory->name }}
                    </div>
                </td>
            </tr>
        </table>

        <table class="list table-border" style="width: 100%; margin-top: 30px">
            <thead class="text-center">
                <th class="bold">ID</th>
                <th class="bold">Hình ảnh</th>
                <th class="bold">Tên sản phẩm</th>
                <th class="bold">ĐVT</th>
                <th class="bold">Giá nhập</th>
                <th class="bold">Số lượng</th>
                <th class="bold">Thành tiền</th>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $stt = 1;
                $import_list = json_decode($import->items, true);
                ?>
                @foreach ($import_list as $item)
                    <tr class="text-center">
                        <td width="5%">{{ $stt }}</td>
                        <td width="10%">
                            <!-- ProductHelper -->
                            <img src="{{ asset(getImageById($item['product_id'])) }}" style="width: 99%; margin:auto" />
                        </td>
                        <td class="text-start">{{ $item['product_name'] }}</td>
                        <td width="10%">
                            {{ $item['product_unit'] }}
                        </td>
                        <td width="10%">
                            {{ my_format_number($item['import_price']) }}
                        </td>
                        <td width="10%">
                            {{ my_format_number($item['product_quantity']) }}
                        </td width="10%">
                        <td class="text-end" width="10%">
                            {{ my_format_number($item['import_price'] * $item['product_quantity']) }}
                        </td>
                    </tr>
                    <?php
                    $total += $item['import_price'] * $item['product_quantity'];
                    $stt++;
                    ?>
                @endforeach
                <tr>
                    <td class="bold text-end" colspan="6">Tổng cộng (chưa thuế)</td>
                    <td class="fw-bold bold text-end">{{ my_format_number($total) }}</td>
                </tr>
            </tbody>
        </table>

        <div style="text-align: center; margin-top: 30px">
            {{ getSetting('company_name', $settings) }}<br />
            {{ getSetting('email', $settings) }}<br />
            {{ getSetting('phone', $settings) }}<br />
            {{ getSetting('address', $settings) }}<br />
        </div>
    </div>
</body>

</html>
