<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function post_data(Request $request){
        try{
            $check_email = User::where('email', $request->email)->first(); //Verifica se já existe um email cadastrado
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

    public function change_status($id, $status){ //Função que desativa ou ativa usuarios
        try{
            $user = User::find($id);
            $user->status = $status;
            $user->save();
            return 1;
        }catch(Throwable $e){
            return false;
        }
  
    }

    public function update_data(Request $request){
        try{
            $user = User::find($request->id);
            $check_email = User::where('email', $request->email)->first();
            if(empty(!$check_email) && $user->email != $request->email){//Verifica se já existe um email cadastrado e se não é o da pessoa que ta sendo atualzada
                return $check_email;
            }
            if($request->password == ''){
                $password = $user->password; //Caso não seja alterada a senha permaneçe a Antiga
            }
            else{
                $password = Hash::make($request->password);//Caso seja alterada a senha permaneçe criptgrafa a nova senha
            }

            $user->fill([
                'name' => $request->name,
                'email' =>$request->email,
                'phone' => $request->phone,
                'password' => $password,
                'position' => $request->position
            ]);
            $user->save();
        }catch(Throwable $e){
            return 404;
        }
       
    }
}
