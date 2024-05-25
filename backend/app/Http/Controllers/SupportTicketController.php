<?php

namespace App\Http\Controllers;
use App\Http\Requests\SupportTicketRequest;
use App\Models\SupportTicket;

class SupportTicketController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(SupportTicket::class,['project','viewer','owner','createdBy','modifiedBy'], SupportTicketRequest::class);
    }
}
