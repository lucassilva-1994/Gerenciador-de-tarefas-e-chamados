import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Department } from "../models/Department";
import { CrudService } from "./crud.service";

@Injectable({ providedIn : 'root'})
export class DepartmentService extends CrudService<Department>{
    constructor(httpClient: HttpClient) {
        super(httpClient, 'departments');
    }
}