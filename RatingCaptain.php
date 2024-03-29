<?php

class RatingCaptain {
    protected $order=array(), $products = array();
    private $store_url = 'https://ratingcaptain.com/api/emails';

    public function __construct($websiteToken)
    {
        $this->websiteToken = $websiteToken;
    }

    public function addProduct($id, $name, $price = null, $imageUrl = null, $desc = null, $productUrl = null, $sku = null, $ean = null)
    {
        $product = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'imageUrl' => $imageUrl,
            'desc' => $desc,
        ];

        // Add only if exists
        if($productUrl) $product['product_url'] = $productUrl;
        if($sku) $product['sku'] = $sku;
        if($ean) $product['ean'] = $ean;

        array_push($this->products, $product);
    }

    private function curl($data, $method = 'post', $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['data' => $data]));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json'
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function send($data)
    {
        $data['hash'] = $this->websiteToken;
        foreach (['external_id', 'email'] as $field) {
            if (! $this->checkField($data, $field)) {
                return ['errors' => $field.' is required'];
            }
        }
        $this->order['external_id'] = $data['external_id'];
        $this->order['email'] = $data['email'];
        if (array_key_exists('send_date', $data)) {
            $this->order['send_date'] = $data['send_date'];
        }
        if (array_key_exists('name', $data)) {
            $this->order['name'] = $data['name'];
        }
        if (array_key_exists('surname', $data)) {
            $this->order['surname'] = $data['surname'];
        }
        $this->order['hash'] = $this->websiteToken;
        $arr = $this->order;
        if (count($this->products) > 0) {
            $arr['products'] = $this->products;
        }

        return $this->curl(json_encode($arr), 'post', $this->store_url);
    }


    private function checkField($arr, $field)
    {
        return array_key_exists($field, $arr);
    }
}
