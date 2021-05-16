<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\tickets;
use Auth;


class DashboardController extends Controller
{
    public static function get_users_data(){
        $users = User::where('status', 1)->where('position', 'seller')->get();
        $tickets_info['open'] = 0; 
        $tickets_info['ongoing'] = 0; 
        $tickets_info['delayed'] = 0; 
        $tickets_info['concluded'] = 0; 
        foreach($users as $key => $user){

        //DAdos para o dashboard do usuario
           $users[$key]->tickets_open = tickets::where('id_seller', $user->id)->where('status', 1)->whereDate('created_at','>=',\Carbon\Carbon::now()->subDays(1)->toDateTimeString())->count();
           $users[$key]->tickets_ongoing = tickets::where('id_seller', $user->id)->where('status', 2)->whereDate('created_at','>=',\Carbon\Carbon::now()->subDays(1)->toDateTimeString())->count();
           $users[$key]->tickets_delayed = tickets::where('id_seller', $user->id)->whereIn('status', [1,2])->whereDate('created_at','<',\Carbon\Carbon::now()->subDays(1)->toDateTimeString())->count();
           $users[$key]->tickets_solved = tickets::where('id_seller', $user->id)->where('status', 3)->count();


        //Dados gerais para o administrador, dava pra fazer uma query pegando o count de todos, mas ja que o foreach tava aqui, fazer oq.
           $tickets_info['open'] =  $tickets_info['open'] + $users[$key]->tickets_open; 
           $tickets_info['ongoing'] = $tickets_info['ongoing'] + $users[$key]->tickets_ongoing; 
           $tickets_info['delayed'] = $tickets_info['delayed'] + $users[$key]->tickets_delayed; 
           $tickets_info['concluded'] =   $tickets_info['concluded'] + $users[$key]->tickets_solved; 
        }

        $data['users'] = $users;
        $data['tickets'] = $tickets_info;

        return $data;

    }
}
