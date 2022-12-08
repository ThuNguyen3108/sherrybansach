{{-- @extends('indexadmin');
@section('admin_content'); --}}
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
    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
@include('sweetalert::alert')

    <input class="form-control" type="checkbox" id="nav-toggle">
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
                    <a href="{{URL::to('productsadmin')}}" class="active" ><span class="fas fa-clipboard-list"></span>
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
                   <h3>Thêm sản phẩm</h3>
                </div>
                <div class="table-responsive">

                        <table id="addproduct" width="1800">
                            <thead>
                                <td>Hình ảnh</td>
                                <td>Tên sách</td>
                                <td>Loại sách</td>
                                <td>Tác giả</td>
                                <td>Giá</td>
                                <td>Số lượng</td>
                                <td>Mô tả</td>
                                <td></td>
                            </thead>
                            <tbody>
                            <form action="{{URL::to('productsadmins')}}" id="themsanpham" name="themsanpham" method="post" enctype="multipart/form-data">
                                @csrf
                                <td><input class="form-control" id="ha" required type="file" name="ha"></td>

                                <td><input class="form-control" required name="tensp" id="tensp" type="text" placeholder="không rỗng"></td>
                                <td>
                                    <select class="form-select" name="loaisp" required id="loaisp" size="1">
                                        @foreach($category as $category)

                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                       @endforeach

                                    </select>
                                </td>
                                <td>
                                    <select  class="form-select" name="tacgia" required id="loaisp" size="1">
                                        @foreach($author as $author)

                                        <option value="{{$author->id}}">{{$author->name}}</option>
                                       @endforeach

                                    </select>
                                </td>

                                <td><input class="form-control" id="dg" required pattern="\d" type="number" name="dg" placeholder="là số, đơn vị VNĐ"></td>
                                <td><input class="form-control" id="sl" required pattern="\d" type="number" name="sl" placeholder="là số dương"></td>
                                <td><textarea  class="form-control" name =" desc" rows="9" cols="15">

                                  </textarea>  </td>
                                <td><button  class="btn btn-outline-success" id="btnAdd" type="submit" >Thêm</button></td>
                            </tbody>
                        </table>
                      
                    </form>
                </div>
            </div>
            <div class="card-header">
                <h3><span class="fas fa-list"></span> <span>Danh sách sản phẩm</span> </h3>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table width="100%">
                        <thead align="center">

                            <tr>

                                <td id="imgproduct">Hình ảnh</td>

                                <td>Mã sách</td>
                                <td>Tên sách</td>
                                <td>Loại sách</td>
                                <td>Tác giả</td>
                                <td>Giá</td>
                                <td>Số lượng</td>
                                <td>Mô tả</td>
                                <td>Thao tác</td>

                            </tr>
                            
                            </tr>

                        </thead>
                        <tbody  class="list" id="list" align="center">
                        @foreach( $book as $book)

<tr>

    <td><img style = "width: 40px; height: 40px" src="{{URL::to('images/'.$book->image)}}"></td>
    <td>{{$book->id}}</td>
    <td>{{$book->name}}</td>
    <td>{{$book->category->name}}</td>
    <td>{{$book->author->name}}</td>
    <td>{{$book->price}}</td>
    <td>{{$book->quality}}</td>
    <td><div style="width: 100px;
    font-size:15px;
text-overflow: ellipsis;
overflow: hidden;
white-space: nowrap;" title="{{$book->description}}">{{$book->description}}</div></td>

    {{-- <td>Xóa <input class="form-control" id="deleteAll" type='checkbox' class='checkdelete'></td> --}}
    <td>
        <form method="POST" action="/productsadmin/{{$book->id}}" >
            @method('DELETE')
            @csrf
            <button  class="btn btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa dữ liệu không?')"  type="submit">Xóa</button>
        </form>
        <td><a href="{{URL::to('updatebook/'.$book->id)}}"><button class="btn btn-outline-warning">Cập nhật</button></a></td>

    </td>


   @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="footertable">
                <button>1</button>
                <button>2</button>
                <button>3</button>
                <button>4</button>
                <button>></button>
                <button>>></button>
            </div> --}}
        </div>
    </div>
</div>
</main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
</html>
{{-- @endsection --}}

