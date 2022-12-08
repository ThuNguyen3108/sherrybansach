<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStore</title>
    <link rel="shortcut icon"
    href="{{asset('images/home/picwish.png')}}">

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/productcustomer.css')}}">
    <link rel="stylesheet" href="{{asset('css/cart.css')}}">
    <link rel="stylesheet" href="{{asset('css/products.css')}}">
    <link rel="stylesheet" href="{{asset('css/myaccount.css')}}">
    <link rel="stylesheet" href="{{asset('css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('css/slick-theme.css')}}">

</head>
<body>
    <!-- Messenger Plugin chat Code -->
    <!-- <div id="fb-root"></div> -->

    <!-- Your Plugin chat code -->
    <!-- <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "105131299073877");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script> -->

    <!-- Your SDK code -->
    <!-- <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v15.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script> -->
    
    @include('sweetalert::alert')

<!-- header section starts  -->

<header class="header">

    <div class="header-1">

        <a href="#" class="logo"> <i class="fas fa-book"></i> Thư's BookStore </a>

        <form action="{{URL::to('Customer/search')}}" method = "post" class="search-form">
            @csrf
            <input type="search" name="timkiem" placeholder="Tìm kiếm" id="search-box">
            <label for="search-box" class="fas fa-search"></label>
        </form>

        <div class="icons">
            <div id="search-btn" class="fas fa-search"></div>
            <a href="#" class="fas fa-heart"></a>
              <a href="{{URL::to('Customer/cart')}}" class="fas fa-shopping-cart position-relative">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-5">
              <?php
                $content=\Cart::getContent()->count();
                //    $book=session('book');
                // echo $book;
                echo $content > 99 ? '99+' : $content;
                ?>
                <span class="visually-hidden">unread messages</span>
              </span>
              </a>
              
            </button>
            
            @if(Session::get('customer'))
            <span class="dropdown">
            <div id="login-btn dropdownMenuButton1"  data-bs-toggle="dropdown" aria-expanded="false" class="fas fa-user dropdown-toggle"></div>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><span class="dropdown-item"><span>{{Session::get('customer')->username}}</span></b></li>
              <li><a class="dropdown-item" href="{{URL::to('Customer/myaccount')}}">Trang cá nhân</a></li>
              <li><a class="dropdown-item" href="{{URL::to('Customer/logout')}}"><span id="login-btn" class="fa fa-power-off"></span>Đăng xuất</a></li>
            </ul>
          </span>
              
            @else
            

          <span class="dropdown">
            <div id="login-btn dropdownMenuButton1"  data-bs-toggle="dropdown" aria-expanded="false" class="fas fa-user dropdown-toggle"></div>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="{{URL::to('login')}}">Đăng nhập</a></li>
              <li><a class="dropdown-item" href="{{URL::to('signup')}}">Đăng ký</a></li>
            </ul>
          </span>
            @endif
        </div>

    </div>

    <div class="header-2">
        <nav class="navbar">
            <a class="navbar_item" href="{{URL::to('Customer/indexcustomer')}}">Trang chủ</a>
            <div class="navbar_item"  id="loai-sach">Loại sách
                <ul class="sub-menu">
                    @foreach($category as $category)
                    <li><a href="{{URL::to('productcustomer/'.$category->id)}}">{{$category->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <a class="navbar_item" href="#featured">Bán chạy</a>
            <a class="navbar_item" href="#arrivals">Đặc sắc</a>
            <a class="navbar_item" href="#reviews">Đánh giá</a>
            <a class="navbar_item" href="#blogs">blogs</a>
        </nav>
    </div>

</header>

<!-- header section ends -->

<!-- bottom navbar  -->

<nav class="bottom-navbar">
    <a href="#home" class="fas fa-home"></a>
    <a href="#featured" class="fas fa-list"></a>
    <a href="#arrivals" class="fas fa-tags"></a>
    <a href="#reviews" class="fas fa-comments"></a>
    <a href="#blogs" class="fas fa-blog"></a>
</nav>

<!-- login form  -->


<!-- home section starts  -->

@yield('content');

<!-- blogs section ends -->

<!-- footer section starts  -->

<footer id="footer" class="footer container-fluid">
    <h5 style="font-size: 20px; color: #ec455a;">About me</h5>
    <img class="footer__avatar" src="{{asset('images/home/avatar.jpg')}}">
    <div class="footer__info">
      <div>Nguyễn Thị Anh Thư - B1908364
        <br>
        Niên luận cơ sở - CT226 Nhóm 07
      </div>
      <ul class="footer__info__social">
        <li><a href="https://www.facebook.com/anhthutralongne" target="_blank"><img src="{{asset('images/home/icon-facebook.svg')}}" alt="Facebook icon"></a></li>
        <li><a href="https://github.com/ThuNguyen3108" target="_blank"><img src="{{asset('images/home/icon-github.svg')}}"alt="Github icon"></a></li>
        <li><a href="https://www.linkedin.com/in/nguy%E1%BB%85n-th%E1%BB%8B-anh-th%C6%B0-8b452b20a/" target="_blank"><img src="{{asset('images/home/icon-linked.svg')}}" alt="Linked icon"></a></li>
      </ul>
      <div class="footer__copyright">
        Copyright © 2022 Nguyễn Thị Anh Thư
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  



<!-- footer section ends -->

<!-- loader  -->

<div class="loader-container">
<iframe src="{{asset('images/home/Pure CSS Book Loader.html')}}" frameborder="0"></iframe>
</div>


{{-- chat bot --}}













<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="{{asset('js/script.js')}}"></script>

</body>
</html>
