@extends('Customer/indexcustomer')
@section('content')

<section class="products" id="products">

    <h1 class="heading"> <span>{{$name_category->name}}</span> </h1>

    <div class="box-container">
        @foreach($book as $book)
        <div class="box" title="{{$book->name}}">
            <div class="image">
                <a href="{{URL::to('Customer/detailbook/'.$book->id)}}"> <img src="{{URL::to('images/'.$book->image)}}" alt=""></a>
               
                <div class="icons">
                    <a href="#" class="fas fa-heart"></a>
                    {{-- <a href="#" class="cart-btn-products">add to cart</a> --}}
                    <a href="#" class="fas fa-share"></a>
                </div>
            </div>
            <div class="content">
            <marquee width="100%" direction="right">
            <h3>{{$book->name}}</h3>
</marquee>
                
                <div class="price">{{number_format($book->price, 0)}} VND</div>
            </div>
        </div>
        @endforeach
    </div>

</section>

@endsection