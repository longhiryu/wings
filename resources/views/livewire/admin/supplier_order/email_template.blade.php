<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đơn đặt hàng</title>
    <style>
        #header {
            width: 80%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        #logo {
            width: 200px;
            display: flex;
            align-content: center;
            justify-content: center;
            padding: 0 20px 0 0;
        }

        #logo img {
            width: 200px !important;
            /* Đảm bảo hình ảnh không vượt quá chiều rộng của #logo */
            height: 44px !important;
        }

        #company-info {
            width: auto;
        }

        #title-container {
            text-align: center;
            margin-bottom: 20px;
            margin: 20px 0 20px 0;
        }

        #title-container .title {
            font-size: 25px;
        }

        #title-container .info {
            font-size: 18px;
        }

        #supplier,
        #note {
            width: 80%;
            margin: auto;
        }

        #order-table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            /* Để loại bỏ khoảng trắng giữa các ô */
        }

        #order-table th,
        #order-table td {
            border: 1px solid #ddd;
            /* Đường viền đơn */
            padding: 5px;
            /* Padding cho các ô */
            text-align: center;
            /* Căn giữa nội dung trong ô */
        }

        #order-table th {
            background-color: #f2f2f2;
            /* Màu nền cho dòng tiêu đề */
        }

        .text-end {
            text-align: right !important;
        }
    </style>
</head>

<body>
    <div id="header">
        <div id="logo">
            <!-- Đặt hình ảnh logo của bạn ở đây -->
            <img src="{{ asset('images/logo_tre_200.png') }}" alt="Logo">
        </div>
        <div id="company-info">
            <!-- Đặt thông tin công ty của bạn ở đây -->
            {{ getSetting('company_name', $settings) }}<br />
            {{ getSetting('email', $settings) }}<br />
            {{ getSetting('phone', $settings) }}<br />
            {{ getSetting('address', $settings) }}<br />
        </div>
    </div>

    <div id="title-container">
        <div class="title">ĐƠN ĐẶT HÀNG</div>
        <div class="info">Mã đơn hàng: <b>{{ $order->code }}</b></div>
    </div>

    <div id="supplier">
        <b>Kính gửi:</b> {{ $supplier->name }}<br />
        <b>Điện thoại:</b> {{ $supplier->phone }}<br />
        <b>Email:</b> {{ $supplier->email }}<br />

        <p>
            Chúng tôi đang có nhu cầu đặt hàng các sản phẩm theo bảng bên dưới:
        </p>
    </div>

    <table id="order-table">
        <thead>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Đơn vị tính</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </thead>
        <tbody>
            <?php
            $n = 1;
            $total = 0;
            ?>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $n }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['unit'] ?? 'Đơn vị' }}</td>
                    <td>{{ formatNumber($item['quantity']) }}</td>
                    <td>{{ myCurrency($item['price']) }}</td>
                    <td>{{ myCurrency($item['price'] * $item['quantity']) }}</td>
                </tr>
                <?php
            $n++;
            $total += $item['price'] * $item['quantity'];
            ?>
            @endforeach
            
            <tr>
                <td class="text-end" colspan="5">Tổng cộng:</td>
                <td>{{ myCurrency($total) }}</td>
            </tr>
            <tr>
                <td class="text-end" colspan="5">Thuế ({{ $order->tax }}%):</td>
                <td>{{ myCurrency(($total * $order->tax) / 100) }}</td>
            </tr>
            <tr>
                <td class="text-end" colspan="5">Thành tiền:</td>
                <td><b>{{ myCurrency($total + $total * $order->tax / 100) }}</b></td>
            </tr>
        </tbody>
    </table>

    <div id="note">
        {!! $order->note !!}
    </div>
</body>

</html>
