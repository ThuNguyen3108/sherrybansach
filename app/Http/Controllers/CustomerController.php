<?php

namespace App\Http\Controllers;

use App\Address;
use App\Customer;
use App\Admin;
use App\Book;
use App\Category;
use App\Order;
use App\detailOrder;
use App\Author;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
// use Darryldecode\Cart\Cart;
use RealRashid\SweetAlert\Facades\Alert;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //
    public function redirectToLogin()
    {
        return redirect("/Customer/indexcustomer");
    }
    public function check_Login(){
        $customer=null;
        if(Session::get('customer')){
            $customer=Session::get('customer');
            return redirect()->action('CustomerController@home');
            // nếu đăng nhập thì mình sẽ ở trang home bình thường, ko thì trở về trang đăng nhập
            // chỗ thanh toán nếu chưa đăng nhập thì sẽ ko được thanh toán
        }else {
            //có thì mình sẽ put vào tên, ko có thì null, thì bắt nó về đăng nhập liền
            Session::put('customer',null);
            return redirect()->action('CustomerController@login');
        } 

    }
    public function home(){
        $category=Category::all();
        return view('Customer/indexcustomer')->with(compact('category'));
    }
    public function index(){
        $books=Book::with('author')->with('category')->get();
        $category=Category::all();

        return view('Customer/index')->with(compact('books','category'));

    }
    public function signup_customer(Request $request){
        $validator = Validator::make($request->all(),
            [
                    'username' => 'required|min:5|max:255',
                    'email' => 'required|email|unique:customer,email',
                    'phone'=> 'required|regex:/^0[0-9]{9}+$/',
                    'password' => 'required|regex:/^(?=.+[a-z])(?=.+[A-Z])(?=.+\d)(?=.+[$@$!%*?&.])[A-Za-z\d$@$!%*?&.]{8,}/',
                    're_password' => 'required|regex:/^(?=.+[a-z])(?=.+[A-Z])(?=.+\d)(?=.+[$@$!%*?&.])[A-Za-z\d$@$!%*?&.]{8,}/',

                ],
                [
                    'username.required' => 'Username là bắt buộc',
                    'username.min' => 'Username phải ít nhất 5 ký tự',
                    'username.max' => 'Username không được vượt quá 255 ký tự',
                    'email.required' => 'Email là bắt buộc',
                    'email.email' => 'Vui lòng nhập email đúng định dạng',
                    'email.unique' => 'Email đã tồn tại',
                    'phone.regex' => 'Phải là số điện thoại',
                    'phone.required' => 'Số điện thoại là bắt buộc',
                    'password.required' => 'Password là bắt buộc',
                    're_password.required' =>'Nhập lại password là bắt buộc',
                    'password.regex' => ' Password gồm ít nhất 8 kí tự, 1 số,1 ký tự đặc biệt và 1 kí tự ngẫu nhiên. Mẫu: anhthu7#1',
                    're_password.regex' =>'Nhập lại password gồm ít nhất 8 kí tự, 1 số,1 ký tự đặc biệt và 1 kí tự ngẫu nhiên. Mẫu: anhthu7#1',

                ]);
                if (!$validator->fails()) {
                    $email=$request->input('email');
                    $username=$request->input('username');
                    $phone=$request->input('phone');
                    $token=$request->_token;
                    $password=$request->input('password');
                    $re_password=$request->input('re_password');

                    if(strcmp($password,$re_password)==0){
                        $customer = new Customer();
                        $customer->email = $email;
                        $customer->username = $username;
                        $customer->token = $request->_token;
                        $customer->password = md5($password);
                        $customer->phone = $phone;
                        // dd($customer);
                        $customer->save();
                        Alert::success('Success',"Thành công");

                        return redirect()->action('CustomerController@login');
                    } else{
                        Alert::error('Error Title', "error");
                        Alert::error('Error',"Mật khẩu không khớp");
                        return redirect()->back()->with('status',"Đăng nhập chưa đúng");

                    }
                } else {
                    // $password=$request->input('password');
                    // $re_password=$request->input('re_password');
                    //     preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/', $password);
                    //     $errors = array(
                    //         PREG_NO_ERROR               => 'Code 0 : No errors',
                    //         PREG_INTERNAL_ERROR         => 'Code 1 : There was an internal PCRE error',
                    //         PREG_BACKTRACK_LIMIT_ERROR  => 'Code 2 : Backtrack limit was exhausted',
                    //         PREG_RECURSION_LIMIT_ERROR  => 'Code 3 : Recursion limit was exhausted',
                    //         PREG_BAD_UTF8_ERROR         => 'Code 4 : The offset didn\'t correspond to the begin of a valid UTF-8 code point',
                    //         PREG_BAD_UTF8_OFFSET_ERROR  => 'Code 5 : Malformed UTF-8 data',
                    //     );
                    
                    //     echo $errors[preg_last_error()];
                    $validator->validate();
                }


    }

    public function login_customer(Request $request){
        // dd($request->all());
        $customer=Customer::where('email',$request->email)->where('password',md5($request->password))->first();
        // dd($customer);
        $admin=Admin::where('email',$request->email)->where('password',md5($request->password))->first();
        // dd($admin);
        if($admin){
            Session::put('username',$admin);
            Alert::success('Thành công', 'Đăng nhập thành công');
            return redirect::to('admin-index');
        }
        else if($customer){
            Session::put('customer',$customer);
            Alert::success('Thành công', 'Đăng nhập thành công');
            return redirect()->action('CustomerController@index');
        }
        else {
            Alert::error('Thất bại',"Thất bại");
            return redirect()->back()->with('status',"Đăng nhập chưa đúng");
        }
    }


    // Hien thi ra danh sach khach hang

    // Hien thi danh sach san pham khach hang

    public function product($id){
        // dd($id);
        // lay cuon sach co truong category trong sach so sanh vs danh muc lay dc
        $book = Book::where('category_id',$id)->get();
        // lay tat ca danh muc
        //trang product được thừa kế nên cái khung nó phải được giữ lại hết, phải đi theo mọi nơi
        $category = Category::all();
        // lay ten the loai chi 1 dong
        $name_category = Category::where('id',$id)->first();
        // dd($book);
        //dd($name_category);

        return view('Customer/productcustomer')->with(compact('book', 'category', 'name_category'));
    }

    public function detail_book($id){
        $id_book = Book::where('id', $id)->with('category')->with('author')->first();
        // dd($id_book);
        $category = Category::all();
    //    dd($id_book);
        return view('Customer/detailbook')->with(compact('id_book', 'category'));
    }

    // Ham show ra my account
    public function myaccount(){
        $this->check_Login();
        $category = Category::all();
        // lấy dữ liệu của người đang đăng nhập hiện tại để thanh toán
        $id_customer = Session::get('customer')->id;
        // theo thức tự giảm dần, get là lấy hết
        $name_address = Address::where('id_customer',$id_customer)->orderBy('id','DESC')->get();
        $order = Order::where('id_customer',$id_customer)->get();
        // lay ra don hang cua thang dang nhap vao
        // dd($name_address);
        // muon co gia tri ben view thi phai bo qua compact
        return view('Customer/myaccount')->with(compact('category','id_customer','name_address','order'));
    }

    public function detailorder($id_order){
        $this->check_Login();
        $category = Category::all();
        $id_customer = Session::get('customer')->id;
        $name_address = Address::where('id_customer',$id_customer)->orderBy('id','DESC')->get();
        //with book là để lấy cuốn sách có chứa nội dung mà mình muốn lấy
        $orderdetail = detailOrder::where('id_order',$id_order)->with('book')->get();
        // dd($orderdetail);
        return view('Customer/detailorder')->with(compact('category','name_address','id_customer','orderdetail'));
    }

    // Ham show ra login nguoi dung
    public function login(){
        return view('Customer/login');
    }

    public function logout(){
        //trả về session hiện tại là null nghĩa là ko có
        // khi lúc đăng nhập sẽ có token, khi đăng nhập thì xóa, session cũng tương tự thì sẽ giữ phiên đăng nhập hiện tại
        Session::put('customer',null);
        return redirect()->action('CustomerController@login');
    }

    //Ham show ra signup nguoi dung
    public function signup(){
        return view('Customer/signup');
    }

    //Ham show ra cart cua nguoi dung
    public function cart(){
            $name_address=null;
            $category = Category::all();
            if(Session::get('customer')){
                //thông tin địa chỉ của người đang đăng nhập mua hàng, thứ tự địa chỉ vào, lấy từ trên xuống
                $name_address=Address::where('id_customer',Session::get('customer')->id)->orderBy('id','desc')->get();
            }
            Session::put('name_address',$name_address);
            // \Cart::clear();
            // dd(\Cart::getContent());
            return view('Customer/cart')->with(compact('category'));


    }

    public function addtocart(Request $request,$id_book){
        // Tham so thu nhat la cai cot cua bang muon so sanh
        // Tham so thu hai la gia tri so sanh
        // Ham get la lay tat ca cac dong thoa dieu kien
        // Ham firt la lay 1 dong duy nhat
        $book = Book::where('id',$id_book)->first();
        // dd($book);

        // truyền số lượng lấy bao nhiêu
        $qty=$request->qty;
        // // dd($request->qty);
        if($qty< $book->quality){
            //Cart như một phiên lưu trữ tạm thời

            // $data['id']=$book->id;
            // $data['name']=$book->name;
            // $data['quantity']=$qty;
            // $data['price']=$book->price;
            // $data['attributes']['image']=$book->image;
            // $data['attributes']['original_qty']=$book->quality;
            \Cart::add(array(
                'id' => $book->id,
                'name' => $book->name,
                'quantity' => $qty,
                'price' => $book->price,
                'attributes' => array(
                    'image' => $book->image,
                    'original_qty' => $book->quality,
                )
            ));
            Alert::success('Thành công', 'Thêm vào giỏ hàng thành công');
            // dd($book->quality);
            // dd(\Cart::getContent());
            return redirect()->action('CustomerController@cart');
        }
       
        else{
            Alert::error('Thất bại', 'Vượt quá số lượng');
             return redirect()->back();}
        // Cart::destroy();
        // Cart::destroy(); //
        // cart::add(['id' => '293ad', 'name' => 'Product 1', 'qty' => 1, 'price' => 9.99, 'weight' => 550, 'options' => ['size' => 'large']]);
        // dd(Cart::content());
       
    }

    public function update_cart(Request $request,$id){
        // dd($request->qty);
        // $data['quantity']=$request->qty;
        \Cart::update($id, array(
            'quantity' => $request->qty,
        ));
        // dd($request->qty,$id);
        Alert::success('Thành công', 'Cập nhật thành công');
        return redirect()->back();
        //back là trở về trang giao diện trước đó đang xử lý
       
    }

    public function add_address(Request $request){
        //input lấy tên đầu vào nhập vô
        $name_address = $request->input('name_address');
        $id_customer = Session::get('customer')->id;
        // dang nhap moi co session con lai bo qua compact
        $category = Category::all();
        $add_address = new Address();
        $add_address->name_address = $name_address;
        $add_address->id_customer = $id_customer;
        $add_address->save();
        $name_address = Address::where('id_customer',$id_customer)->orderBy('id','DESC')->get();
        // dd($name_address);
        //redirect dieu huong trang web
        // return view la ko co cap nhat chi lay ra thoi
        // return redirect da thay doi du lieu dieu huong den 1 trang nao do
        if($request->input('submit_address') == 'cart'){
            return redirect()->action('CustomerController@cart');
        } else {
            return redirect()->action('CustomerController@myaccount');
        }
        
        // return view('Customer/myaccount')->with(compact('category','name_address'));


    }
    // bấm đặt hàng
    public function adddataOrder(Request $request){
        if(!Session::get('customer')){
            return redirect()->action('CustomerController@login');
        }else{
            $id_customer = Session::get('customer')->id;
            $id_address = $request->input('name_address');
            $tongtien = \Cart::getTotal();
            // dd(Cart::content());
            // save bth vẫn được nhưng muốn lưu cái mảng khi thực hiện thì nó trả về id 
            // mà nó thực hiện luôn để trả về bảng detailOrder, lưu giá trị mới vào bảng detailOrder
            $addOrder = array();
            $addOrder['id_address'] = $id_address;
            $addOrder['id_customer'] = $id_customer;
            $addOrder['total_money']= $tongtien;
            $addOrder['status'] = 'Chờ xác nhận';
            //Insert bang order xong roi lay id de insert vao detailorder
            $id_order=Order::insertGetId($addOrder);
            // chua thong tin cua gio hang
            $content=\Cart::getContent();
            // dd($content)

            foreach($content as $content){
                $detailOrder =new detailOrder();
                $detailOrder->id_order =  $id_order;
                $detailOrder->id_book=  $content->id;
                $detailOrder->quality= $content->quantity;
                $detailOrder->price= $content->price;
                $detailOrder->total = $content->quantity *  $content->price;
                $detailOrder->save();
                //   +id: 10
                //   +qty: "1"
                //   +name: "Mẹ"
                //   +price: 320000.0
                //   +weight: 0.0
                //   +options: Gloudemans\Shoppingcart\CartItemOptions {#303 ▶}
                //   +taxRate: 21
                //   -associatedModel: null
                //   -discountRate: 0
                //   +instance: "default"
                // lay ra so luong trong kho cua mot cuon sach
                $id_book = Book::where('id',$content->id)->first();
                // tim cuon sach va update lai so luong cua no
                $id_book->quality=$id_book->quality - $content->qty;
                $id_book->save();
            }
            \Cart::clear();
            Alert::success('Thành công', 'Đặt hàng thành công');
            return redirect()->action('CustomerController@cart');

        }
    }

    public function destroyCart(Request $request,$id){
        \Cart::remove($id);
        //remove là xóa 1 thằng, còn clear là xóa hết
        Alert::success('Thành công', 'Xóa thành công');
        return redirect('Customer/cart');

    }

    public function destroyCartAll(Request $request){
        \Cart::clear();
        Alert::success('Thành công', 'Xóa giỏ hàng thành công');
        return redirect('Customer/cart');
    }

    public function destroyorder(Request $request, $id){
        // dau tien tim tat ca chi tiet cua don hang ma minh truyen vao

        $detailOrder = detailOrder::where('id_order', $id)->get();
        // dd($detailOrder);
        foreach($detailOrder as $detailOrder){
            //trả số lượng đặt hàng về cho kho, mỗi cuốn sách chỉ có một id
            // trong đơn hàng có từng cuốn, mỗi một foreach chỉ cập nhật 1 cuốn thôi
            $book = Book::where('id',$detailOrder->id_book)->first();
            // gia tri nay = gia tri cu cong voi so luong sach ma ho dat
            $book->quality = $book->quality + $detailOrder->quality;
            $book->save();
            //id_book nam trong model detailOrder (model dang chi den)
            // gia tri do minh xac dinh trong bang khac
            // dd($book);
            //ban đầu là xóa detailOrder nào mang cùng một thằng Order, khi xóa xong rồi mình mới xóa đơn hàng tương ứng
            $detailOrder->delete();
        }
        $order = Order::where('id',$id)->delete();
        //khi lưu là từ Order đến detail khi xóa là ngược lại
        Alert::success('Thành công', 'Hủy đơn hàng thành công');
        return redirect()->action('CustomerController@myaccount');
    }

    public function change_password(Request $request, $id){
        $customer = Customer::where('id', $id)->first();
        // lay mat khau moi cua nguoi dung nhap vo
        $password = $request->input('new_password');
        $re_password=$request->input('re_password');
        // mat khau cua nguoi dung bang voi mk moi nhap vo

        if($re_password == $password){
            $customer->password = md5($password);
            $customer->save();
            return redirect()->action('CustomerController@myaccount')->with('status',"Cập nhật thành công");
        }
        else{
            return redirect()->action('CustomerController@myaccount')->with('status',"Mật khẩu không trùng khớp. Vui lòng nhập lại");
        }

    }

    public function search(Request $request){
        $char = $request->input('timkiem');
        $book = Book::where('name','LIKE','%'.$char.'%' )->get();
        $category = Category::all();
        // dd($book);
        return view('Customer/search')->with(compact('book','category','char'));
    }

    // public function test1(){
    //     $order = Author::where('id', 10)->with('book')->first();
    //     dd($order);
    // }

}



