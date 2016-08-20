<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Zone;

class ZoneController extends Controller
{
	//add customer zone
	public function addCustomerZone(){
		$zone = new Zone;
		$zone->zone_type = 'customer';
		$zone->zone_name = Input::get('customer_zone');
		$zone->save();
		return Redirect::to('/customerZones');
	}

	//add vehicle zone
    public function addVehicleZone(){
    	$zone = new Zone;
		$zone->zone_type = 'vehicle';
		$zone->zone_name = Input::get('vehicle_zone');
		$zone->save();
		return Redirect::to('/vehicleZones');
    }

	public function deleteCustomerZone(){
		if(Session::get('loggin_status')==true){
			$zone_id = $_GET['zone_id'];
			try {
				DB::table('zones')
					->where('zone_id',$zone_id)
					->update(['isDeleted' =>1]);

				DB::table('customers')
					->where('zone_id',$zone_id)
					->update(['zone_id' =>0]);

				print_r(json_encode("success"));
			}catch(\Exception $e){
				print_r(json_encode("error"));
			}
		}else{
			return Redirect::to('/login');
		}
	}

	public function deleteVehicleZone(){
		if(Session::get('loggin_status')==true){
			$zone_id = $_GET['zone_id'];
			try {
				DB::table('zones')
					->where('zone_id',$zone_id)
					->update(['isDeleted' =>1]);

				DB::table('vehicles')
					->where('zone_id',$zone_id)
					->update(['zone_id' =>0]);

				print_r(json_encode("success"));
			}catch(\Exception $e){
				print_r(json_encode("error"));
			}
		}else{
			return Redirect::to('/login');
		}
	}

	public function editCustomerZone(){
		DB::table('zones')
			->where('zone_id', Input::get('customer_zone_id'))
			->update(['zone_name' => Input::get('edit_customer_zone_name')]);
		return Redirect::to('/customerZones');
	}

	public function editVehicleZone(){
		DB::table('zones')
			->where('zone_id', Input::get('vehicle_zone_id'))
			->update(['zone_name' => Input::get('edit_vehicle_zone_name')]);
		return Redirect::to('/vehicleZones');
	}



}
