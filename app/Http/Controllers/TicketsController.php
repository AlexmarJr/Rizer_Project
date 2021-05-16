<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\tickets;
use Auth;
use Carbon\Carbon;

class TicketsController extends Controller
{
    public function open_ticket(Request $request){
        $assigned_seller = TicketsController::check_less_tickets(); //Cahma a função que Verifica quem é o Vendendor/Tecnico com menos chamados.
        if($assigned_seller == ''){
            return 0;
        }
        tickets::create([
            'id_seller' => $assigned_seller,
            'name_client' => $request->name,
            'email_client' =>$request->email,
            'subject' => $request->subject,
            'description' => $request->description
        ]);

    }

    public function check_less_tickets(){
        $users = User::where('status', '1')->where('position', 'seller')->get();
        $luck_user = '';
        $luck_user_numbers = tickets::all()->count();;
        foreach($users as $user){
            $open_tickets = tickets::where('id_seller', $user->id)->count();

            if($open_tickets <= $luck_user_numbers){
                $luck_user = $user->id;
                $luck_user_numbers = $open_tickets;
            }
        }

        return $luck_user;
    }

    public function get_all_tickets(){
        $tickets = tickets::where('id_seller','=',Auth::id())->get();
        
        foreach($tickets as $key => $ticket){
            $tickets[$key]->open_date = \Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d');
        }

        return $tickets;
    }

    public function get_ticket($id){
        $ticket = tickets::find($id);
        if($ticket->status == 1){
            $ticket->status = 2;
            $ticket->save();
        }
        $ticket->open_date = \Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d');

        return $ticket;
    }

    public function close_ticket($id){
        $ticket = tickets::find($id);
        $ticket->status = 3;
        $ticket->save();
        return 1;
    }
}