<?php

return [

    'admin' => [
        [
            'name' => 'admin_email',
            'title' => 'Admin email',
            'type' => 'email',
            'group' => 'admin',
            'default' => 'longhiryu@gmail.com',
        ],
        [
            'name' => 'admin_items_per_page',
            'title' => 'Items per page',
            'type' => 'number',
            'group' => 'admin',
            'default' => '10',
        ],
        [
            'name' => 'admin_copy_right',
            'title' => 'Copyright',
            'type' => 'text',
            'group' => 'admin',
            'default' => 'Copyright © 2021. All rights reserved.',
        ],
    ],

    'website' => [
        [
            'name' => 'website_title',
            'title' => 'Tiêu đề Trang',
            'type' => 'text',
            'group' => 'website',
            'default' => 'CÔNG TY CỔ PHẦN VIỆT NAM TICKETS',
        ],
        [
            'name' => 'website_keywords',
            'title' => 'Từ khóa',
            'type' => 'text',
            'group' => 'website',
            'default' => 'Vé báy bay , Tour du lịch',
        ],
        
        [
            'name' => 'company_name',
            'title' => 'Company name',
            'type' => 'text',
            'group' => 'website',
            'default' => 'CÔNG TY CỔ PHẦN VIỆT NAM TICKETS',
        ],
        [
            'name' => 'company_no',
            'title' => 'GPKD',
            'type' => 'text',
            'group' => 'website',
            'default' => ' 0314558363',
        ],
        [
            'name' => 'address',
            'title' => 'Address',
            'type' => 'text',
            'group' => 'website',
            'default' => '69 Võ Thị Sáu, P.6, Q.3 Hồ Chí Minh',
        ],
        [
            'name' => 'address1',
            'title' => 'Address',
            'type' => 'text',
            'group' => 'website',
            'default' => '173 Nguyễn Thị Minh Khai, P.Phạm Ngũ Lão, Q.1 Hồ Chí Minh',
        ],
        [
            'name' => 'email',
            'title' => 'Email',
            'type' => 'email',
            'group' => 'website',
            'default' => 'info@vietnam-tickets.com',
        ],
        [
            'name' => 'phone',
            'title' => 'Phone',
            'type' => 'text',
            'group' => 'website',
            'default' => '028-3936-2020 028-3925-9950',
        ],
        [
            'name' => 'hotline',
            'title' => 'Hotline',
            'type' => 'text',
            'group' => 'website',
            'default' => '19003173',
        ],
        [
            'name' => 'website',
            'title' => 'Website',
            'type' => 'text',
            'group' => 'website',
            'default' => 'vietnam-tickets.com',
        ],
        [
            'name' => 'website_copy_right',
            'title' => 'Copyright',
            'type' => 'text',
            'group' => 'website',
            'default' => '© Copyright 2023. Bản quyền thuộc về CÔNG TY CỔ PHẦN VIỆT NAM TICKETS',
        ],
        [
            'name' => 'website_items_per_page',
            'title' => 'Items per page',
            'type' => 'number',
            'group' => 'website',
            'default' => '10',
        ],
        [
            'name' => 'website_description',
            'title' => 'Mô tả Trang',
            'type' => 'textarea',
            'group' => 'website',
            'default' => 'Vietnam Tickets cung cấp các vé máy bay cho các chuyến bay nội địa và quốc tế, liên hệ qua số điện thoại 028 3936 2020 hoặc địa chỉ trụ sở tại 69 Võ Thị Sáu, Phường 6, Quận 3, Thành phố Hồ Chí Minh. Bên cạnh đó, công ty cũng cung cấp các dịch vụ liên quan đến visa, du lịch và khách sạn cho khách hàng',
        ],
        [
            'name' => 'custom_css',
            'title' => 'Custom CSS',
            'type' => 'textarea',
            'group' => 'website',
            'default' => '',
        ],
        [
            'name' => 'custom_js',
            'title' => 'Custom JS',
            'type' => 'textarea',
            'group' => 'website',
            'default' => '',
        ],
    ],
];
