<p>Dear Minh Tiến</p>
<p>Khác hàng: {{ $model_orders->first_name." ".$model_orders->last_name }}</p>
<p>Email: {{ $model_orders->email }}</p>
<p>Đã sử dụng tiền bonus cho order no: <span style="color: #0000cc">#{{ $model_orders->order_no  }}</span></p>
<p>Số tiền sử dụng là: 
    <?php
        if($model_orders->payment_type->code == "BONUS"){
            echo $model_orders->total_price;
        }else{
            echo $model_orders->used_bonus;
        }
    ?>
<p>Chi tiết đơn hàng xem tại đây: <a href="{{ URL::route('adminUserOrders.viewOrders' , ['id' => $model_orders->id ]) }}">{{ URL::route('adminUserOrders.viewOrders' , ['id' => $model_orders->id ]) }}</a></p>

<p style="font-weight: bold">Chúc bạn thành công và kiếm được thật nhiều $</p>
<p style="font-weight: bold">Thanks you!</p>