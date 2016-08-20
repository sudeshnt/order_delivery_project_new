<?php

namespace App\Http\Controllers;

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

class CustomerController extends Controller
{
    //add a customer
    public function addCustomer(){

    	if(Session::get('loggin_status')==true){
    		$customer = new Customer;
    		$customer->customer_name=Input::get('name');
    		$customer->business_name=Input::get('bizz_name');
    		$customer->customer_address=Input::get('address');
    		$customer->email=Input::get('email');
    		$customer->customer_mobile=Input::get('mobile_no');
    		$customer->zone_id=Input::get('zone_id');
    		$customer->save();
			return Redirect::to('/customers');
		}else{
			return Redirect::to('/login');
		}

    }

	public function deleteCustomer(){
		if(Session::get('loggin_status')==true){
			$customer_id = $_GET['customer_id'];
			try {
				DB::table('customers')
					->where('customer_id',$customer_id)
					->update(['isDeleted' =>1]);
				print_r(json_encode("success"));
			}catch(\Exception $e){
				print_r(json_encode("error"));
			}
		}else{
			return Redirect::to('/login');
		}
	}

	public function getCustomerById($customer_id){
		$customer = Customer::where('customer_id',$customer_id)->first();
		print_r(json_encode($customer));
	}

	public function editCustomer(){
		DB::table('customers')
			->where('customer_id',  Input::get('edit_customer_id'))
			->update(['customer_name' => Input::get('edit_customer_name'),'business_name' => Input::get('edit_business_name'),'customer_address'=>Input::get('edit_customer_address'),'email' => Input::get('edit_email'),'zone_id' => Input::get('edit_zone_id'),'customer_mobile' => Input::get('edit_customer_mobile')]);
		return Redirect::to('/customers');
	}

}
