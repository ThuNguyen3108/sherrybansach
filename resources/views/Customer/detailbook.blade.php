@extends('Customer/indexcustomer')
@section('content')
<section class="container">
  <div class="spacing"></div>
  <h1 class="heading"> <span>Chi tiết sản phẩm</span> </h1>
  <div class="product-item-container">
    <div class="book-detail">
    <img src="{{URL::to('images/'.$id_book->image)}}" alt="">
    <form action="{{URL::to('Customer/cart/'.$id_book->id)}}" method="POST" enctype="multipart/form-data" class="pe-5">
        @csrf
    <div class="book-detail__info">
      
      <div class="book-detail__info__title">
        {{$id_book->name}}</div>
      <div class="book-detail__info__price">
       {{number_format($id_book->price,0) }} VND</div>
      <div class="book-detail__info__detail">
        <p class="book-detail__info__detail__title"><b>Mã sách:</b> </p>
        
        <p class="book-detail__info__detail__title"><b>Số lượng:</b> </p>
        
        <p class="book-detail__info__detail__title"><b>Thể loại:</b> </p>
        <p class="book-detail__info__detail__title"><b>Tác giả:</b> </p>
        
        <p class="book-detail__info__detail__title">{{$id_book->id}}</p>
        <p class="book-detail__info__detail__title">{{$id_book->quality}} sản phẩm</p>
        <p class="book-detail__info__detail__title">{{$id_book->category->name}}</p>
        <p class="book-detail__info__detail__title">{{$id_book->author->name}}</p>
      
      </div>
      <div class="mb-12 d-flex justify-content-between align-items-center">
          <label for="formControlInputQuantity" class="form-label fs-3 text-nowrap pe-3">Số lượng</label>
          <input class="form-control" type ="number" class="form-control  form-control-lg fs-4"  name="qty" id="formControlInputQuantity" max = "{{$id_book->quality}}" min = "1" value = "1"  placeholder="Quantity is required." required>
        </div>
      <div id="cartButton">
        
            <!-- <button  class="btn btn--secondary book-detail__button">Đã thêm vào giỏ</button> -->
          
          <button type="submit"  class="btn btn--primary book-detail__button">Thêm vào giỏ hàng</button>
        
      </div>
    </form>

    </div>

  </div>
  <div class="book-detail__content">
    <p class="book-detail__content__title">Sơ lược sách</p>
    <p class="book-detail__content__content">{{$id_book->description}}</p>
  </div>
  </div>
  

 
</section>
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif


@endsection