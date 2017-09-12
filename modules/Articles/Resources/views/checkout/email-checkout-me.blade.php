<p>Dear Minh Tiến</p>
<p>Khác hàng: {{ $model_orders->first_name." ".$model_orders->last_name }}</p>
<p>Email: {{ $model_orders->email }}</p>
<p>Đã yêu cầu thanh toán cho hóa đơn có Order No: <span style="color: #0000cc">#{{ $model_orders->order_no  }}</span></p>
<p>Đơn hàng: <a href="{{ URL::route('adminUserOrders.listOrders') }}">{{ URL::route('adminUserOrders.listOrders') }}</a></p>

<p style="font-weight: bold">Chúc bạn thành công và kiếm được thật nhiều $</p>
<p style="font-weight: bold">Thanks you!</p>