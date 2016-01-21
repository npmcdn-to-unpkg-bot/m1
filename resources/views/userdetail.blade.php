@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>联系方式</th>
            <th>Email</th>
            <th>订单历史</th>
            <th>注册年</th>
            <th>最后登陆时间</th>
        </tr>

        <tr>
            <td>{{ $data['userInfo']->uid }}</td>
            <td>{{ $data['userInfo']->nickname }}</td>
            <td>{{ $data['userInfo']->cellphone }}</td>
            <td>{{ $data['userInfo']->email }}</td>
            <td>{{ $data['userInfo']->order_num }}</td>
            <td>{{ $data['userInfo']->lastlogin }}</td>
            <td>{{ $data['userInfo']->regdate }}</td>
        </tr>
    </table>

    <table class="table table-striped">
        <tr>
            <th>订单时间</th>
            <th>订单号</th>
            <th>金额</th>
            <th>课时</th>
            <th>订单状态</th>
            <th>教师ID</th>
            <th>交易教师</th>
            <th>评分</th>
        </tr>
        @foreach($data['userInfo']['orders'] as $order)

        @endforeach
        <tr>
            <td>{{ $order->submit_time }}</td>
            <td>{{ $order->oid }}</td>
            <td>{{ $order->price }}</td>
            <td>{{ $order->lasts }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->teacher_uid }}</td>
            <td>{{ $order->teacher_nickname }}</td>
            <td>{{ $order->rating }}</td>
        </tr>
    </table>
</div>
@endsection