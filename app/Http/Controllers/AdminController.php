<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Category;
use App\Book;
use App\Author;
use App\Customer;
use App\Order;
use App\Address;
use App\detailOrder;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
class AdminController extends Controller
{
    //
    public function login(){
        return view('loginadmin');
    }
    public function admin_index(){
        $startDate = date('Y-m-01');
        $endDate  = date('Y-m-t');
        $numberOfCustomer = Customer::all()->count();
        $numberOfProduct = Book::where('status',1)->get()->count();
        $numberOfOrdered = Order::where('status','Đã giao')->whereBetween('updated_at', [$startDate, $endDate])->get()->count();
        $revenue = Order::where('status','Đã giao')->whereBetween('updated_at', [$startDate, $endDate])->get()->sum('total_money');
        return view('indexadmin')->with(compact('numberOfCustomer','numberOfProduct','numberOfOrdered','revenue'));
    }
    // public function admin_login(Request $request){
    //     $admin=Admin::where('email',$request->fullname)->where('password',md5($request->psw))->first();
    //     // dd($admin);
    //     if($admin){
    //         Session::put('username',$admin);
    //         return redirect::to('admin-index');
    //     }
    //     else return redirect::to('admin-login');
    // }
    public function product(){
        $category=Category::all();
        $book=Book::with('category')->with('author')->get();
        $author=Author::all();
        $customer=Customer::all();
        // dd($book);
        return view('productsadmin')->with(compact('category','book','author', 'customer'));
    }
    // public function customer(){
    //     return view('customeradmin');
    // }

    public function category(){
        $category=Category::all();
        $book = Book::all();
        $author = Author::all();
        $customer=Customer::all();
        return view('categoryadmin')->with(compact('category', 'book', 'author', 'customer'));
    }
    //Thêm và cập nhật thì mình sẽ có request còn xóa thì mình sẽ không cần
    public function categorybook(Request $request){
        $category = new Category();
        $category->name=$request->input('tentheloai');
        $category->status = true;
        $category->save();
        Alert::success('Succes', 'Dữ liệu thêm thành công.');
        //view có thể là view mới còn redirect là có rồi
        return redirect('categoryadmin');


    }
    public function destroy(Request $request,$id){
        // dd($id);
        $category = Category::find($id);
        $category->delete();
        Alert::success('Succes', 'Dữ liệu xóa thành công.');
        return redirect()->action('AdminController@category');
    }

    // lay gia tri ra tra ve trang can sua
    public function update($id)
    {
        $namecategory = Category::find($id);
        return view('updatecategory')->with(compact('namecategory'));
    }
    public function updatename(Request $request, $id)
    {
        $namecategory = Category::find($id);
        $namecategory->name = $request->tentheloai;
        // $namecategory->update();
        // dd($namecategory);
        $namecategory->save();
        Alert::success('Succes', 'Dữ liệu cập nhật thành công.');
        return redirect()->action('AdminController@category');

    }
    // Them cuon sach
    public function productadmin(Request $request){
        // dd($request->all());
        $book = new Book();
        $book->name=$request->input('tensp');
        $book->description = $request->input('desc');
        $book->price = $request->input('dg');
        $book->image = $request->input('ha');
        $book->author_id=$request->input('tacgia');
        // $image=null;
        if($request->hasfile('ha')){
            $file=$request->file('ha');
            $file_name=time().rand(1,2000).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'),$file_name);
            $image=$file_name;

        }

        $book->image=$image;
        $book->quality = $request->input('sl');
        $book->status = true;
        $book->category_id=$request->input('loaisp');

        // dd($category);
        $book->save();
        
        Alert::success('Succes', 'Dữ liệu thêm thành công.');

        return redirect('productsadmin')->with('status', 'Add success!');
    }

    public function deletebook(Request $request,$id){
        // dd($id);
        $book = Book::find($id);
        //đường dẫn của cái ảnh, vừa xóa dòng đó đi kèm theo tấm ảnh trong file images
        $path='images/'.$book->image;
        if(file_exists($path)){
            unlink(($path));
        }
        $book->delete();
        Alert::success('Succes', 'Dữ liệu xóa thành công.');
        return redirect()->action('AdminController@product');
    }
    public function updateid(Request $request, $id){
        //tìm có hay không QueryBuilder
        $idbook= Book::findOrFail($id);
        //dữ liệu header không thay đổi nên là phải dữ liệu
        $categorybook = Category::all();
        // dd($idbook);
        return view('updatebook')->with(compact('idbook','categorybook'));
    }

    public function updatebooks(Request $request, $id){
        $book = Book::find($id);
        $book->name=$request->input('tensp');
        $book->description = $request->input('desc');
        $book->price = $request->input('dg');
        
        // $image=null;
        if($request->hasfile('ha')){
            $file=$request->file('ha');
            $file_name=time().rand(1,2000).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'),$file_name);
            $image=$file_name;
            $book->image=$image;

        }
        $book->quality = $request->input('sl');
        $book->status = true;
        $book->category_id=$request->input('loaisp');

        // dd($book);
        $book->save();
        Alert::success('Succes', 'Cập nhật thành công');

        return redirect('productsadmin');
    }

    // Ham show tac gia

    public function author(){
        $author=Author::all();
        $category = Category::all();
        $book = Book::all();
        $customer=Customer::all();
        // if(session('status')){
        //     Alert::success('Success', session('status'));
        // }
        return view('authoradmin')->with(compact('author','category', 'book', 'customer'));
    }
   // Ham them tac gia, redirect la da ve duong dan, ham author chua view roi
    public function nameauthor(Request $request){
        $nameauthor = new Author();
        $nameauthor ->name=$request->input('tentacgia');
        $nameauthor ->status = true;
        $nameauthor ->save();
        Alert::success('Succes', 'Dữ liệu thêm thành công.');
        return redirect()->action('AdminController@author')->with('status', 'Add success!');


    }

    public function deleteauthor(Request $request,$id){
        // dd($id);
        $author = Author::find($id);
        // dd($author);
        $author->delete();
        Alert::success('Success', 'Xóa dữ liệu thành công');
        return redirect()->action('AdminController@author')->with('status','Dữ liệu xóa thành công.');
    }
    public function update_id_author(Request $request, $id){
        $idauthor= Author::findOrFail($id);
        Alert::success('Success', 'Cập nhật dữ liệu thành công');
        return view('updateauthoradmin')->with(compact('idauthor'));
    }



    public function updateauthor(Request $request, $id){
        $author = Author::find($id);
        // dd($author);
        $author->name=$request->input('tentacgia');

        $author->save();
        Alert::success('Succes', 'Cập nhật thành công.');
        return redirect()->action('AdminController@author')->with('status', 'Update success!');
    }

    public function customer_admin(){
        $customer=Customer::all();
        $category = Category::all();
        $book = Book::all();
        $author = Author::all();
        return view('customeradmin')->with(compact('customer', 'category', 'book', 'author'));
    }

    // Ham show ra view order admin
    public function orderadmin(){
        $category = Category::all();
        $customer=Customer::all();
        $author = Author::all();
        $book = Book::all();
        // Sau model la dau ::
        $order = Order::with('customer')->with('address')->get();
        $address=Address::with('order')->get();
        // dd($order);
        if(session('status')){
            Alert::success('Succes', session('status'));
        }
        return view('orderadmin')->with(compact('category', 'author', 'book', 'customer', 'order'));
    }

    public function updatestatus(Request $request, $idorder){
        $idorder = Order::find($idorder);
        // dd($request->input('status'));
        if(strcmp($request->input('status'),1)==0){
            //status của name trong thẻ select
            $idorder->status='Chờ xác nhận';
        }
        elseif(strcmp($request->input('status'),2)==0){
            $idorder->status='Đã duyệt';
        }
        elseif(strcmp($request->input('status'),3)==0){
            $idorder->status='Đang giao hàng';
        }
        else{
            $idorder->status='Đã giao';

        }

        $idorder->save();
        Alert::success('Succes', 'Trạng thái đơn hàng đã được cập nhật thành công.');
        // dd($idorder);
        // status của biến thông báo
        return redirect()->action('AdminController@orderadmin');

    }

    // Ham xem chi tiet don hang cua khach hang
    public function detailorderadmin($id_order){
        $category = Category::all();
        $customer=Customer::all();
        $author = Author::all();
        $book = Book::all();
        $order = Order::with('customer')->with('address')->get();
        $address=Address::with('order')->get();
        $detailorder=detailOrder::where('id_order',$id_order)->with('book')->get();
        // dd($detailorder);
        
        return view('detailorderadmin')->with(compact('category','customer','author','book','order', 'address','detailorder'));
    }
}
