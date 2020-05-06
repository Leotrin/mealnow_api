<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SupportTickets;
use App\Models\Logs;

class SupportTicketsController extends Controller
{
    public function tickets(){
        if(request()->isMethod('post')){
            $newTicket = new SupportTickets();
            $newTicket->user_id = auth()->user()->id;
            $newTicket->to_user_id = request('to_user');
            $newTicket->subject = request('subject');
            $newTicket->content = request('content');
            $newTicket->priority = request('priority');
            $newTicket->parent = 0;
            $newTicket->status = 0;
            $newTicket->save();


            $this->log(
                'Support__'.$newTicket->id,
                'INSERT NEW TICKET '.json_encode($newTicket),
                'NEW SUPPORT TICKET'
            );

            return redirect('admin/support');
        }

        $tickets = SupportTickets::where('parent',0)->whereHas('user', function($query){
            $query->where('to_user_id', auth()->user()->id);
            $query->orWhere('to_user_id',0);
            $query->orWhere('user_id',auth()->user()->id);
        })->get();
        $users = User::all();
        return view('new_backend.support.list',compact('tickets','users'));
    }
    public function view_ticket($id){
        $ticket = SupportTickets::where('parent',$id)->latest()->first();
        $ticketMessages = SupportTickets::where('id',$id)->orWhere('parent',$id)->latest()->get();
        if($ticket==null){
            $ticket = SupportTickets::find($id);
        }
        $protocols = Logs::where('function','Support__'.$id)->get();
        $ticketFiles = SupportTickets::find($id);
        $ticket_id = $id;
        return view('new_backend.support.ticket',compact('ticket','page','id','ticket_id','ticketMessages','protocols','ticketFiles'));
    }

    public function replay_ticket($id){
        $t = SupportTickets::find($id);
        $ticket = new SupportTickets();
        $ticket->user_id = auth()->user()->id;
        $ticket->to_user_id =$t->user_id;
        $ticket->subject =$t->subject;
        $ticket->answer = request('msg');
        $ticket->status = 1;
        $ticket->parent = $id;
        $ticket->save();

        $this->log(
            'Support__'.$id,
            'INSERT NEW REPLAY'.json_encode($ticket),
            'REPLAY MESSAGE FROM ADMIN'
        );
        return redirect('admin/support/view/'.$id);
    }
}
