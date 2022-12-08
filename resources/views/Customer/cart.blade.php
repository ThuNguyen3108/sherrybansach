@extends('Customer/indexcustomer')
@section('content')
<div class="container">
  <div class="seperate"></div>
  <section class="products" id="products">

    <h1 class="heading"> <span>Giỏ hàng</span> </h1>
    <?php
    $content = \Cart::getContent();
    //    $book=session('book');
    // echo $book;
    // echo $content;
    ?>
    {{-- <form action="" method="post"> --}}
    <div class="cart-detail">
      <ul class="cart-detail__book">
        <!-- <p>Bạn chưa chọn quyển sách nào!</p> -->
        @foreach ($content as $item)


        <li class="cart-detail__book__item">
          <a><img src="{{URL::to('images/'.$item->attributes->image)}}" class="cart-detail__book__item__image" alt="">
          </a>
          <div class="cart-detail__book__item__info">
            <a class="cart-detail__book__item__info__title">
              {{$item->name}}
            </a>
            <a name="quantity" class="cart-detail__book__item__info__title">
              Số lượng: {{$item->quantity}}
            </a>

            <form action="{{URL::to('Customer/update-cart/'.$item->id)}}" method="POST">

              @csrf
              <input class="form-control" type="number" hidden id="priceOfBook" value="">
              <p class="cart-detail__book__item__info__price"></p>
              <p>Kho: còn {{$item->attributes->original_qty}} quyển</p>
              <label class="cart-detail__book__item__info__number" for="">Số lượng cập nhật: <input class="form-control" id="" name="qty" type="number" value="0" max="{{$item->attributes->original_qty}}"></label>
              <button class="btn btn-outline-warning" type="submit">Cập nhật</button>
              
            </form>
           
          </div>
          <form action="{{URL::to('Customer/destroy-cart/'.$item->id)}}" method="post">
            @csrf
            <button type="submit" class="btn-close"></button>
          </form>
          
        </li>
        @endforeach

      </ul>
      <div class="cart-detail__user-info">
        <div class="cart-detail__user-info__title">Thông tin nhận hàng</div>

        <form action="{{URL::to('Customer/adddataOrder')}}" method="post">
          @csrf
          <div class="cart-detail__user-info__detail">
            <input class="form-control" hidden type="text" name="MSKH" @if(Session::get('customer')) value="{{Session::get('customer')->id}}" @else value="" @endif>
            <p><b>Tên người nhận: </b></p>
            <p>
              @if(Session::get('customer'))
              {{Session::get('customer')->username}}
              @endif
            </p>
            <p><b>Số điện thoại:</b></p>
            <p>
              @if(Session::get('customer'))
              {{Session::get('customer')->phone}}
              @endif
            </p>
            <!-- <div class="cart-detail__user-info__detail__address"> -->
            <p><b>Địa chỉ: </b></p>
            @if(Session::get('name_address'))
            <div class="d-flex justify-content-between align-items-center">
              <select class="form-select" name="name_address" class="flex-grow-1 me-1" required id="address" size="1">

                @foreach (Session::get('name_address') as $address)
                <option value="{{$address->id}}">{{$address->name_address}}</option>
                @endforeach

              </select>
              <a class="order__tab-link px-3" type="button" data-bs-toggle="modal" data-bs-target="#addressModel" title="Thêm địa chỉ"><i class="fas fa-plus fs-3"></i></a>
            </div>
            
            <script src="{{asset('js/vendor/jquery.min.js')}}"></script>
            <script src="{{asset('js/vendor/jquery.migrate.min.js')}}"></script>
            <!-- Bootstrap -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
            <script src="{{asset('js/vendor/slick.min.js')}}"></script>

            <!-- Gsap -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js"></script>
            <script src="{{asset('js/myaccount.js')}}"></script>

            @endif
            <p></p>
            <p><b>Tổng tiền:{{number_format(\Cart::getTotal(),0) }} VND</b></p>



          </div>
          <div class="cart-detail__user-info__detail__total">


            <b id="total" class="price"></b>
          </div>
          <div class="cart-detail__user-info__detail__total">
            <button type="submit" class="btn btn--primary">Đặt hàng</button>
          </div>
        </form>
        <form action="{{URL::to('Customer/destroyCartAll')}}" method = "POST">
          @csrf
        <div class="cart-detail__user-info__detail__total">
            <button type="submit" class="btn btn--primary">Hủy bỏ</button>
          </div>
        </form>
        <div class="modal linear" id="addressModel" tabindex="-1" role="dialog" aria-labelledby="addressModel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-size: 16px;font-weight: 600;">Thêm địa chỉ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{URL::to('Customer/addressOfmyaccout')}}" method="POST" class='modal__address-form'>
                      @csrf
                      <div class="form__group">
                        <label for="address">Địa chỉ</label>
                        <input class="form-control" type="text" id='address' name='name_address'>

                      </div>
                      <div class="" style="float:right;">
                        <a type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</a>
                        <button type="submit" class="btn btn-primary" value="cart" name='submit_address'>Thêm</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
      </div>


      <!-- <p style="line-height: 25px;">Bạn chưa đăng nhập, hãy đăng nhập để đặt hàng!</p> -->

    </div>
</div>
{{-- </form> --}}
</div>
</div>


@endsection