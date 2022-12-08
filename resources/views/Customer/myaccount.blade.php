@extends('Customer/indexcustomer')
@section('content')
<!-- prodcuts section starts  -->

<section class="products" id="products">

    <h1 class="heading"> <span>Tài khoản của tôi</span> </h1>
    <div class="order">
        <div class="container" style="display: flex;">
            <div class="order__tab">
                <a class="order__tab-link" id='order-tab-defalt-open' onclick="openTab(event,'orders')"><i class="fa fa-cart-arrow-down"></i>Đơn hàng</a>
                <a class="order__tab-link" onclick="openTab(event,'address')"><i class="fa fa-map-marker"></i>Địa chỉ thanh toán</a>
                <a class="order__tab-link" onclick="openTab(event,'detail-account')"><i class="fa fa-user"></i>Chi tiết tài khoản</a>
                <a href="{{URL::to('Customer/cart')}}" class="order__tab-link"><i class="fa fa-sign-out"></i>Exit</a>
            </div>
            <div class="order__wrapper">
                <div class="order__content" id='orders'>
                    <h2>Đơn hàng</h2>
                    <table class='table table-bordered'>
                        <thead>

                            <tr>
                                <th>
                                    Đơn hàng
                                </th>
                                <th style="max-width: 224px;width:224px;">
                                    Ngày lập
                                </th>
                                <th style="max-width: 185px;width: 185px;">
                                    Trạng thái
                                </th>
                                <th style="max-width: 135px;width: 135px;">
                                    Tổng
                                </th>
                                <th>
                                    Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order as $order)
                                <tr>
                                    <td>
                                       {{$order->id}}
                                    </td>
                                    <td style="max-width: 224px;">
                                        <p>
                                            {{$order->created_at}}
                                        </p>
                                    </td>
                                    <td style="max-width: 185px;">
                                        <p class='order__pending' style="color: black;">{{$order->status}}</p>
                                    </td>
                                    <td style="max-width: 135px;">
                                        <p>
                                           {{$order->total_money}}
                                        </p>
                                    </td>
                                    <td style="max-width: 142px;">
                                        <a href="{{URL::to('Customer/detailorder/'.$order->id)}}">Xem</a>
                                        <form action="{{URL::to('destroyorder/'.$order->id)}}" method = "POST">
                                            @csrf
                                            <button type="submit">Hủy</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="order__content order__address" id='address'>
                    <h2>Địa chỉ thanh toán</h2>
                    
                        <p class="order__address-name">
                            @if(Session::get('customer'))
                              {{Session::get('customer')->username}}
                            @endif
                          </p>
                        <p class="order__address-text">
                            <select name="address" required id="address" size="1">
                                                   
                                @foreach ($name_address as $address)
                                <option   value="{{$address->id}}">{{$address->name_address}}</option>
                                @endforeach
                            
                            </select>
                        </p>
                        <p class="order__address-phone" style="letter-spacing: 1px;">Mobile:
                            @if(Session::get('customer'))
                              {{Session::get('customer')->phone}}
                            @endif
                          </p>
                    
                    <a href="" data-toggle="modal" data-target="#addressModel">
                        <i class="fa fa-edit"></i> Thêm địa chỉ
                    </a>
                </div>
                @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                        @endif
                <div class="order__content " id='detail-account'>
                    <h2>Chi tiết tài khoản</h2>
                    <form action="{{URL::to('change-password/'.Session::get('customer')->id)}}" class="order__account" method="POST">
                        @csrf
                        <div class='order__account-group'>
                            <label for="name">Họ và Tên</label>
                            <input type="text" value="{{Session::get('customer')->username}}" name='name' id='name'>
                        </div>
                        <div class='order__account-group'>
                            <label for="email">Địa chỉ Email</label>
                            <input type="email" name='email' id='email' value="{{Session::get('customer')->email}}">
                        </div>
                        <h3>Thay đổi mật khẩu</h3>
                        <div class='order__account-group order__account-group--row'>
                            <div class="">
                                <label for="new_password">Mật khẩu mới</label>
                                <input type="password" name='new_password' id='new_password'>
                            </div>
                            <div class="">
                                <label for="re_password">Nhập lại mật khẩu</label>
                                <input type="password" name='re_password' id='re_password'>
                            </div>
                        </div>
                        <button style="background-color: black;" type="submit" name="submit-info" class='order__account-btn'>Lưu thay đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
    </div>

</section>

<!-- prodcuts section ends -->


  <div class="modal linear" id="addressModel" tabindex="-1" role="dialog" aria-labelledby="addressModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 16px;font-weight: 600;">Thêm địa chỉ</h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form action="{{URL::to('Customer/addressOfmyaccout')}}" method="POST" class='modal__address-form'>
                    @csrf
                    <div class="form__group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" id='address' name='name_address'>

                    </div>
                    <div class="" style="float:right;">
                        <a type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</a>
                        <button  type="submit" class="btn btn-primary" name='submit_address'>Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

  



<!-- footer section ends -->

<!-- loader  -->


<!-- Jquery -->

<script src="{{asset('js/vendor/jquery.min.js')}}"></script>
<script src="{{asset('js/vendor/jquery.migrate.min.js')}}"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{asset('js/vendor/slick.min.js')}}"></script>

<!-- Gsap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js"></script>
<!-- Main script -->
<script src="{{asset('js/myaccount.js')}}"></script>

@endsection