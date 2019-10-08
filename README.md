# client
RatingCaptain client class

You can create new ratingcaptain email via this class

First you have to create new instance and pass your RatingCaptain Api Key,
you can find your API key in https://ratingcaptain.com/app/websites
<br>
Example: '9f6ag554a73a12d224fc1C3bb2274345' <br>
You have available 3 methods:

Add product

        /*
            @ID:int Your product ID,
            @NAME:string Your product name,
            @PRICE:float Your product price,
            @IMAGE_URL:string Your product image url,
            @DESC:string Product description 
            @return void
        */
        $ratingcaptain->addProduct(10, 'name', 10.00, 'http://www.website.com/images/1', 'Description');

Send email 

        /*
            @DATA:array In this array you should contain fileds like external_id, email, you can also specify send_date or send_after              
            @return array                                                                                                      
         */
        $order = ["external_id" => $order->id, "email" => $order->email, 'send_date' => Date('Y-m-d H:i:s', strtotime('+5 days'))];
        $test = $ratingcaptain->send($order);

Delete email

        /*
            @ID:int Your order id,
            @return:array 
        */
        $ratingcaptain->deleteOrder($order->id);
        
Example integration: 
       
        $order = [];
        $ratingcaptain = new \RatingCaptain($request->apiKey);
        foreach ($request->products as $product){
            $ratingcaptain->addProduct($product['id'], $product['name'], $product['price'], $product['image_url']);
        }
        $order = ["external_id" => $order->id, "email" => $order->email, 'send_date' => Date('Y-m-d H:i:s', strtotime('+5 days'))];
        $test = $ratingcaptain->send($order);
        $ratingcaptain = new \RatingCaptain($request->apiKey);
        $ratingcaptain->deleteOrder($order->id);

