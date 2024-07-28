import { Department } from "../models/Department";
import { CRUDService } from "./crud.service";
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root'})
export class DepartmentService extends CRUDService<Department>{
    constructor(httpClient: HttpClient){
        super(httpClient,'departments');
    }
}