<?php

namespace App\Http\Controllers;

use App\Driver;
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

class DriverController extends Controller
{
    //add driver
    public function addDriver(){
        if(Session::get('loggin_status')==true){
            $driver=new Driver;
            $driver->driver_name = Input::get('name');
            $driver->address = Input::get('address');
            $driver->mobile = Input::get('mobile');
            $driver->save();
            return Redirect::to('/drivers');
        }else{
            return Redirect::to('/login');
        }
    }

    //delete a driver
    public function deleteDriver(){
        if(Session::get('loggin_status')==true){
            $driver_id = $_GET['driver_id'];
            try {
                DB::table('drivers')
                    ->where('driver_id',$driver_id)
                    ->update(['isDeleted' =>1]);
                print_r(json_encode("success"));
            }catch(\Exception $e){
                print_r(json_encode("error"));
            }
        }else{
            return Redirect::to('/login');
        }
    }

    public function getDriverById($driver_id){
        $driver = Driver::where('driver_id',$driver_id)->first();
        print_r(json_encode($driver));
    }

    public function editDriver(){
        DB::table('drivers')
            ->where('driver_id', Input::get('driver_id'))
            ->update(['driver_name' => Input::get('driver_name'),'address' => Input::get('address'),'mobile' => Input::get('mobile_no')]);
        return Redirect::to('/drivers');
    }
}
