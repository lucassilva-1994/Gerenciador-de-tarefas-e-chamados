import { Injectable } from "@angular/core";
import { CrudService } from "./crud.service";
import { Permission } from "../models/Permission";
import { HttpClient } from "@angular/common/http";

@Injectable({providedIn:'root'})
export class PermissionService extends CrudService<Permission>{
    constructor(httpClient: HttpClient){
        super(httpClient,'permissions');
    }
}