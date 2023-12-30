<?php

namespace App\Sys\Api;

class SysApi
{
    //code
    public const _API_OK = 200;
    public const _API_ACCEPTED = 202;
    public const _API_UNAUTHORIZED = 406; //auth custom
    public const _API_NOT_FOUND = 404;
    public const _API_BUG = 500;
    public const _API_UNAUTHORIZED_MESSAGE = 'Lỗi! Quyền truy cập không thích hợp!!!';
    public const _CODE_MAX_LENGTH = 15;

    public function getData(object $model, array $params = []){
        $data = $model::query();

        $limit = isset($params['limit']) ? $params['limit'] : 10;
        
        return $data->paginate($limit);
    }

    public function callAPI($url, $method)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                // 'Authorization: oEonkeqyD6Z1T1BwK8XaKHKCwBvVXZmLa',
                'Accept: application/json',
                // 'X-CHANNEL: sctv9',
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
