{{-- @extends('indexadmin');
@section('admin_content') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Products</title>
    <link rel="shortcut icon"
    href="{{asset('images/home/picwish.png')}}">

    <link rel="stylesheet" href="{{asset('css/indexadmin.css')}}">
    <script src="https://kit.fontawesome.com/9ac8be3ee8.js" crossorigin="anonymous"></script>
</head>
<body>
    <input class="form-control" type="checkbox"  class="form-control" id="nav-toggle">
    <div class="sidebar">
       <div class="sidebar-brand">
           <h2><span>
                <img id="fullLogo" src="{{asset('images/home/picwish.png')}}" alt="logo" height="150px">
           </span></h2>

       </div>
       <div class="sidebar-menu">
           <ul>
               <li>
                   <a href="{{URL::to('admin-index')}}"><span class="fas fa-igloo"></span>
                    <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="{{URL::to('customeradmin')}}"><span class="fas fa-users"></span>
                     <span>Khách hàng</span></a>
                 </li>
                 <li>
                    <a href="{{URL::to('productsadmin')}}"><span class="fas fa-clipboard-list"></span>
                     <span>Sản phẩm</span></a>
                 </li>
                 <li>
                    <a href="{{URL::to('categoryadmin')}}"><span class="fas fa-clipboard-list"></span>
                     <span>Thể loại</span></a>
                 </li>
                 <li>
                    <a href="{{URL::to('authorviewadmin')}}"><span class="fas fa-clipboard-list"></span>
                     <span>Tác giả</span></a>
                 </li>
                 <li>
                    <a href="{{URL::to('orderadmin')}}"  class="active" ><span class="fas fa-shopping-bag"></span>
                     <span>Đơn hàng</span></a>
                 </li>
                 {{-- <li>
                    <a href=""><span class="fas fa-receipt"></span>
                     <span>Hóa đơn</span></a>
                 </li>
                 <li>
                    <a href=""><span class="fas fa-user-circle"></span>
                     <span>Tài khoản</span></a>
                 </li>
                 <li>
                    <a href=""><span class="fas fa-clipboard-list"></span>
                     <span>Tasks</span></a>
                 </li> --}}

           </ul>
       </div>
    </div>
    <div class="main-content">
        <header>
            <h2 style="margin-top: 10px">
                <label for="nav-toggle">
                    <span class="fas fa-bars"> </span>
                </label>
                <span id="dashboard">Dashboard</span>
            </h2>

            <div class="search-wrapper">
                <span class="fas fa-search"></span>
                <input class="form-control" type="search" placeholder="Search here">
            </div>

            <div class="user-wrapper" style="cursor: pointer;">
                <img  src="{{asset('images/home/avatar.jpg')}}" width="30px" height="30px" alt="">
                <div>
                    <h4>
                        {{Session::get('username')->username}}
                    </h4>
                    <small>Admin</small>
                </div>
            </div>
            <div id="infoAdmin">
                <a href="#"><i class="fas fa-cog"></i>&nbsp; Setting</a>
                <a href="{{URL::to('Customer/indexcustomer')}}" onclick="localStorage.clear()"><i class="fas fa-sign-out-alt"></i>&nbsp; Log out</a>
            </div>
            <script>
                let account = document.querySelector("#infoAdmin");
                document.querySelector(".user-wrapper").onclick = () => {
                    account.classList.toggle("active");
                };
            </script>
        </header>
<main>
    <div class="card">
      <div class="card-header">
        <h3>
          <span class="fas fa-list"></span>
          <span>Chi tiết đơn hàng</span>
        </h3>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table width="100%">
            <thead>
              <tr>
                <td>Mã Sách</td>
                <td>Tên Sách</td>
                <td>Hình ảnh</td>
                <td>Số lượng</td>
                <td>Giá</td>

              </tr>
              <tbody>
              @foreach ($detailorder as $detailorder)
              <tr>

                <td>{{$detailorder->book->id}}</td>
                <td>{{$detailorder->book->name}}</td>
                <td>
                <img style="max-width: 100px;" src="{{URL::to('images/'.$detailorder->book->image)}}">
                </td>
                <td>{{$detailorder->quality}}</td>
                <td>{{$detailorder->price}}</td>
                <td>
                  {{$detailorder->total}}
                </td>


              </tr>
              @endforeach
            </tbody>
            </thead>
            
          </table>
        </div>
      </div>

    </div>
  </main>
</body>
</html>
{{-- @endsection --}}
