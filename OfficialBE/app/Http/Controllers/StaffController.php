<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffModel;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    function Show_Staff_Screen(Request $request){
        $Staff = new Staff;
        $Staff = $Staff::where("del_flg", 0)->orderBy('created_datetime')->get();
        return $Staff;
    }
    function Delete(Request $request){
        $SelectedStaff = $request;
        $SelectedStaffID = $SelectedStaff['id']; //here id staff
        $ID_Login = $SelectedStaff['id_login']; //need IDlogin from user entered
        $SelectedStaff_Condition = $SelectedStaff['Condition']; // when click to verify, send true!

        $Staff = new Staff;
        $Staff = $Staff::where("id", $SelectedStaffID)->first();

        if ($SelectedStaff_Condition == true){
            $Staff->update([
                'del_flg' => 1,
                'updated_user'=> $ID_Login,
                'updated_datetime'=> now(),
            ]);
        }
    }
    function Staff_Create(Request $request){
        $data = $request;
        $Staff_Create = Validator::make($request->all(), [
            'last_name'=>"required|nullable|string|size:6",
            'first_name'=>"required|nullable|string",
            'last_name_furigana'=>'required|nullable|string',
            'first_name_furigana'=>'required|nullable|string',
            'office' => 'required|nullable',
        ], [
            'last_name.required' => "Last name is required",
            'first_name.required' => "First name is required",
            'last_name_furigana.required'=> "Last name furigana is required",
            "first_name_furigana.required" => "first name furigana is required",
            'office.required' =>'Office is required!',
        ]);
        if ($Staff_Create->fails()) {
            return $Staff_Create->errors();
        }
        else{
            return $Staff_Create->getData();
        }
        
    }
}
