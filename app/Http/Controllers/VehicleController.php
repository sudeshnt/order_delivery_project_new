<?php

namespace App\Http\Controllers;

use App\Customer;
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
use App\Vehicle;
use App\Driver;
class VehicleController extends Controller
{
    //add a vehicle
    public function addVehicle(){
        if(Session::get('loggin_status')==true){
            $vehicle = new Vehicle;
            $vehicle->vehicle_number = Input::get('number');
            $vehicle->zone_id = Input::get('zone_id');
            $vehicle->driver_id = Input::get('driver');
            $vehicle->save();
            //setting the selected driver isAssigned = true
            DB::table('drivers')
                ->where('driver_id',$vehicle->driver_id)
                ->update(['isAssigned' => 1]);
            return Redirect::to('/vehicles');
        }else{
            return Redirect::to('/login');
        }
    }

    //get vehicles assigned to the given customer's zone
    public function getCustomerZoneVehicles($customer_id){
        $vehicles=DB::table('customers')
            ->join('vehicles', 'customers.zone_id', '=', 'vehicles.customer_zone_id')
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
            ->select('vehicles.*','drivers.driver_name')
            ->where('customer_id',$customer_id)
            ->where('vehicles.isDeleted',0)
            ->where('drivers.isDeleted',0)
            ->where('vehicles.driver_id','!=',0)
            ->get();
        //dd($vehicles);
        print_r(json_encode($vehicles));
    }

    //reset all vehicle's isAssigned status to false and reset assigned date
    public function resetAllVehicles(){
        Vehicle::where('isAssigned', '=', 1)->update(['isAssigned' => 0 , 'assigned_date' => '0000-00-00 00:00:00' , 'customer_zone_id' => 0]);
        print_r(json_encode('success'));
   }

    /*assign vehicle to a customer zone*/
    public function assignVehicleToCustomerZone($vehicle_id,$customer_zone_id){
        DB::table('vehicles')
            ->where('vehicle_id',$vehicle_id)
            ->update(['isAssigned' => 1,'customer_zone_id'=>$customer_zone_id,'assigned_date'=>date('Y-m-d H:i:s')]);
        print_r(json_encode('success'));
    }

    //delete a vehicle
    public function deleteVehicle(){
        if(Session::get('loggin_status')==true){
            $vehicle_id = $_GET['vehicle_id'];
            try {
                DB::table('vehicles')
                    ->where('vehicle_id',$vehicle_id)
                    ->update(['isDeleted' =>1]);
                print_r(json_encode("success"));
            }catch(\Exception $e){
                print_r(json_encode("error"));
            }
        }else{
            return Redirect::to('/login');
        }
    }

    public function getVehicleById($vehicle_id){
        $vehicle = Vehicle::join('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
                            ->join('zones','vehicles.zone_id','=','zones.zone_id')
                            ->select('vehicles.vehicle_id','vehicles.vehicle_number','drivers.driver_id','zones.zone_id')
                            ->where('vehicle_id',$vehicle_id)->first();
        print_r(json_encode($vehicle));
    }

    public function editVehicle(){
        DB::table('vehicles')
            ->where('vehicle_id',  Input::get('vehicle_id'))
            ->update(['vehicle_number' => Input::get('number'),'driver_id' => Input::get('driver'),'zone_id'=>Input::get('zone_id')]);
        DB::table('drivers')
            ->where('driver_id',Input::get('driver'))
            ->update(['isAssigned' =>1]);
        return Redirect::to('/vehicles');
    }
}
