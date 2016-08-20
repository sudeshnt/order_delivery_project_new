<?php

namespace App\Http\Controllers;

use App\Company;
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

class CompanyController extends Controller
{
    public function addCompany(){
        if(Session::get('loggin_status')==true){
            $company=new Company();
            $company->company_name = Input::get('company_name');
            $company->company_email = Input::get('company_email');
            $company->save();
            return Redirect::to('/companies');
        }else{
            return Redirect::to('/login');
        }
    }

    //delete a driver
    public function deleteCompany(){
        if(Session::get('loggin_status')==true){
            $company_id = $_GET['company_id'];
            try {
                DB::table('companies')
                    ->where('company_id',$company_id)
                    ->update(['isDeleted' =>1]);
                print_r(json_encode("success"));
            }catch(\Exception $e){
                print_r(json_encode("error"));
            }
        }else{
            return Redirect::to('/login');
        }
    }

    public function getCompanyById($company_id){
        $company = Company::select('company_id','company_name','company_email')
                          ->where('company_id',$company_id)->first();
        print_r(json_encode($company));
    }

    public function editCompany(){
        DB::table('companies')
            ->where('company_id', Input::get('edit_company_id'))
            ->update(['company_name' => Input::get('edit_company_name'),'company_email' => Input::get('edit_company_email')]);
        return Redirect::to('/companies');
    }
}
