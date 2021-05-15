<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function post_data(Request $request){
        try{
            $check_email = User::where('email', $request->email)->first();
            if(empty(!$check_email)){
                return $check_email;
            }
            User::create([
                'name' => $request->name,
                'email' =>$request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'position' => $request->position
            ]);
        }catch(Throwable $e){
            return 404;
        }
       
    }

    public function get_records(){
        return User::all();
    }

    public function get_seller($id){
        return User::find($id);
    }

    public function change_status($id, $status){
        try{
            $user = User::find($id);
            $user->status = $status;
            $user->save();
            return 1;
        }catch(Throwable $e){
            return false;
        }
  
    }
}
