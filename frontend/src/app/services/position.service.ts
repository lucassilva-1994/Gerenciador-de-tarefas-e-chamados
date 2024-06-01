import { Injectable } from "@angular/core";
import { Position } from "../models/Position";
import { CrudService } from "./crud.service";
import { HttpClient } from "@angular/common/http";

@Injectable({ providedIn: 'root'})
export class PositionService extends CrudService<Position>{
    constructor(httpClient: HttpClient){
        super(httpClient,'positions')
    }
}