{{-- @extends('indexadmin');
@section('admin_content') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Author</title>
    <link rel="shortcut icon"
    href="{{asset('images/home/picwish.png')}}">

    <link rel="stylesheet" href="{{asset('css/indexadmin.css')}}">
    <script src="https://kit.fontawesome.com/9ac8be3ee8.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
@include('sweetalert::alert')
    <input type="checkbox" id="nav-toggle">
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
                    <a href="{{URL::to('authorviewadmin')}}" class="active"><span class="fas fa-clipboard-list"></span>
                     <span>Tác giả</span></a>
                 </li>
                 <li>
                    <a href="{{URL::to('orderadmin')}}"><span class="fas fa-shopping-bag"></span>
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
    <div class="projects">
        <div class="card">
            <div class="card-add">
                <div class="card-header">
                   <h3>Thêm tác giả</h3>
                </div>
                <div class="table-responsive">
                    <form action="{{URL::to('authoradmin')}}" method="post" id="themsanpham" name="themsanpham">
                    @csrf
                        <table id="addproduct" width="1800">

                            <thead>

                                <td>Tên tác giả</td>

                                <td></td>
                            </thead>
                            <tbody>
                                <td><input class="form-control" required name="tentacgia" id="tensp" type="text" placeholder="không rỗng"></td>
                                <td><button id="btnAdd" class="btn btn-outline-success" type="submit" onclick="addItem()">Thêm</button></td>
                            </tbody>
                        </table>
                        <!-- @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif -->
                    </form>
                </div>
            </div>
            <div class="card-header">
                <h3><span class="fas fa-list"></span> <span>Danh sách tác giả</span> </h3>
            {{-- <button id="btnDel"><b>Xóa</b></button> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table width="100%">
                        <thead align="center">

                            <tr>


                                <td>Mã tác giả</td>
                                <td>Tên tác giả</td>
                                <td>Thao tác</td>
                            </tr>
                            


                        </thead>
                        <tbody  class="list" id="list" align="center">
                        @foreach ($author as $item)


<tr>

     <td>{{$item->id}}</td>
    <td>{{$item->name}}</td>
    {{-- <td>Xóa <input id="deleteAll" type='checkbox' class='checkdelete'></td> --}}
     <td>
        <form method="POST" action="authorviewradmin/{{$item->id}}" >
            @method('DELETE')
            @csrf
            <button class="btn btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa dữ liệu không?')"  type="submit">Delete</button>
        </form>
        <td><a href="{{URL::to('updateauthoradmin/'.$item->id)}}"><button class="btn btn-outline-warning">Cập nhật</button></a></td>

    </td>



 </tr>
@endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
</main>
</div>
{{-- @endsection --}}
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
</html>
