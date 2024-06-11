import { Injectable } from "@angular/core";
import { SupportTicket } from "../models/SupportTicket";
import { CrudService } from "./crud.service";
import { HttpClient } from "@angular/common/http";

@Injectable({ providedIn: 'root'})
export class SupportticketService extends CrudService<SupportTicket>{
    constructor(httpClient: HttpClient){
        super(httpClient,'support-tickets')
    }
}