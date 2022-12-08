<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Address;
use App\Order;

class Customer extends Model
{
        public $timestamps=false;
        protected $table='customer';
        protected $primary_key='id';
        protected $fillable=[
                'username',
                'email',
                'phone'
        ];
        public function address(){
                //tham so dau tien: Model mình chứa tới, khóa ngoại của thằng address, trường có cùng giá trị, tham chiếu tới với Customer 
                // tham số thứ 2 dựa vào id customer, đúng lí trường thứ 3 sẽ ko ghi, do đặt tên không đúng quy định vs Laravel
                //còn nếu đúng thì thằng bên id_customer sẽ tự động kéo id về cho
                return $this->hasMany(Address::class,'id_customer','id');
        }
        public function order(){
                // do bang customer khong co khoa ngoai voi order nen them khoa ngoai id_customer so sanh vs id trong bang customer
                // trường thứ 3 không nhất thiết phải khóa chính, trường thứ 2 đến trường thứ 3 dựa vào đâu để tham chiếu
                
                return $this->hasMany(Order::class,'id_customer','id');
        }
}
