import { Injectable } from "@angular/core";
import { CrudService } from "./crud.service";
import { Role } from "../models/Role";
import { HttpClient } from "@angular/common/http";

@Injectable({ providedIn: 'root'})
export class RoleService extends CrudService<Role>{
    constructor(httpClient: HttpClient){
        super(httpClient,'roles');
    }
}