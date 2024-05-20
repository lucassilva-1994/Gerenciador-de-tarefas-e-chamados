<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Http\Requests\SupportTicketRequest;
use App\Models\SupportTicket;

class SupportTicketController extends Controller
{
    use HelperModel;
    public function showAll(){
        return SupportTicket::all();
    }

    public function showById(SupportTicket $supportTicket){
        return $supportTicket;
    }

    public function create(SupportTicketRequest $request){
        return self::setData($request->all(), SupportTicket::class);
    }

    public function update(SupportTicketRequest $request, SupportTicket $supportTicket){
        return self::updateData($request->all(), SupportTicket::class,['id' => $supportTicket->id]);
    }

    public function delete(SupportTicket $supportTicket){
        return self::setStatusDeleted(SupportTicket::class,['id' => $supportTicket->id]);
    }
}
