<?php

namespace App\Http\Controllers;

use App\DamagedProduct;
use App\Product;
use App\StockIn;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\User;
use Validator;
use Crypt;
use Auth;
use Session;
use App\Customer;

class ProductController extends Controller
{
    public function addProduct(){
        if(Session::get('loggin_status')==true){
            $product=new Product();
            $product->product_name=Input::get('product_name');
            $product->product_code=Input::get('product_code');
            $product->available_amount=Input::get('product_amount');
            $product->unit_price=Input::get('product_unitprice');
            $product->company_id=Input::get('company_id');
            $product->isDamaged=false;
            $product->product_size=Input::get('product_size');
            $product->save();
            return Redirect::to('/products');
        }else{
            return Redirect::to('/login');
        }
    }

    public function getProduct($product_id){
        $product = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.company_id')
            ->select('products.*', 'companies.company_name')
            ->where('products.product_id',$product_id)
            ->first();
        print_r(json_encode($product));
    }

    //add Stock for Existing Product
    public function addStockExistingProduct(){
        $product = Product::where('product_id',Input::get('product_id'))->first();
        DB::table('products')
            ->where('product_id',Input::get('product_id'))
            ->update(['available_amount' => $product->available_amount+Input::get('added_amount')]);
        // adding stock in note
        $stock_in = new StockIn();
        $stock_in->product_id = Input::get('product_id');
        $stock_in->qty = Input::get('added_amount');
        $stock_in->opening_stock = $product->available_amount;
        $stock_in->save();
        return Redirect::to('/products');
    }

    public function addExistingDamaged(){
        $product = Product::where('product_id',Input::get('product_id'))->first();
        DB::table('products')
            ->where('product_id',Input::get('product_id'))
            ->update(['available_amount' => $product->available_amount-Input::get('damaged_qty')]);

        //checking if damaged product is already existed
        $is_exist_damaged_product = DamagedProduct::where('product_id',Input::get('product_id'))->first();
        If($is_exist_damaged_product != ''){
            DB::table('damaged_products')
                ->where('product_id',Input::get('product_id'))
                ->update(['qty' => $is_exist_damaged_product->qty+Input::get('damaged_qty')]);
        }
        else{
            $damaged_product = new DamagedProduct();
            $damaged_product->product_id = Input::get('product_id');
            $damaged_product->qty = Input::get('damaged_qty');
            $damaged_product->save();
        }

        return Redirect::to('/products');
    }

    public function addNewDamagedProducts(){
        $product=new Product();
        $product->product_name=Input::get('product_name');
        $product->product_code=Input::get('product_code');
        $product->available_amount=0;
        $product->company_id=Input::get('company_id');
        $product->isDamaged=true;
        $product->product_size=Input::get('product_size');
        $product->save();

        $product_just_added = Product::where('product_code',Input::get('product_code'))->first();
        $damaged_product = new DamagedProduct();
        $damaged_product->product_id = $product_just_added->product_id;
        $damaged_product->qty = Input::get('damaged_amount');
        $damaged_product->save();
        return Redirect::to('/products');
    }

    public function deleteProduct(){
        if(Session::get('loggin_status')==true){
            $product_id = $_GET['product_id'];
            try {
                DB::table('products')
                    ->where('product_id',$product_id)
                    ->update(['isDeleted' =>1]);
                print_r(json_encode("success"));
            }catch(\Exception $e){
                print_r(json_encode("error"));
            }
        }else{
            return Redirect::to('/login');
        }
    }

    public function getProductById($product_id){
        $product = Product::where('product_id',$product_id)->first();
        print_r(json_encode($product));
    }

    public function editProduct(){
        DB::table('products')
            ->where('product_code',  Input::get('prev_product_code'))
            ->update(['product_code' => Input::get('edit_product_code'),'company_id' => Input::get('edit_company_id'),'product_name'=>Input::get('edit_product_name'),'available_amount' => Input::get('edit_available_amount'),'unit_price' => Input::get('edit_unit_price'),'product_size' => Input::get('edit_product_size')]);
        return Redirect::to('/products');
    }

    public function deleteDamagedProduct(){
        if(Session::get('loggin_status')==true){
            $product_id = $_GET['product_id'];
            try {
                DB::table('damaged_products')
                    ->where('product_id',$product_id)
                    ->update(['isDeleted' =>1]);
                print_r(json_encode("success"));
            }catch(\Exception $e){
                print_r(json_encode("error"));
            }
        }else{
            return Redirect::to('/login');
        }
    }

    public function getDamagedProductById($product_id){
        $product = DamagedProduct::where('product_id',$product_id)->first();
        print_r(json_encode($product));
    }

    public function editDamagedProduct(){
      //  dd(intval(Input::get('edit_qty')),intval(Input::get('prev_qty')),Input::get('damaged_product_id'));
       DB::table('damaged_products')
            ->where('product_id',  Input::get('damaged_product_id'))
            ->update(['qty' => intval(Input::get('edit_qty'))]);
        DB::table('products')->where('product_id',  Input::get('damaged_product_id'))->decrement('available_amount',  intval(Input::get('edit_qty'))- intval(Input::get('prev_qty')));
        return Redirect::to('/damagedProducts');
    }


    /*get stock in of a given product in the past*/
    public function getStockInReports($product_id){
        $product_stock_ins=DB::table('products_stock_in')
            ->where('product_id',$product_id)
            ->orderBy('created_at', 'desc')
            ->get();
        print_r(json_encode($product_stock_ins));
    }

    /*get filtered stock ins of a given product in a date range*/
    public function getFilteredStockInReports($start_date,$end_date,$product_id){
        $product_stock_ins=DB::table('products_stock_in')
            ->where('product_id',$product_id)
            ->where('created_at','>=',$start_date)
            ->where('created_at','<=',$end_date." 23:59:59")
            ->orderBy('created_at', 'desc')
            ->get();
        print_r(json_encode($product_stock_ins));
    }
}
