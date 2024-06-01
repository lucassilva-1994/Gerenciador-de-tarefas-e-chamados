import { HttpClient } from "@angular/common/http";
import { Employee } from "../models/Employee";
import { CrudService } from "./crud.service";
import { Injectable } from "@angular/core";

@Injectable({ providedIn:'root'})
export class EmployeeService extends CrudService<Employee>{
    constructor(httpClient: HttpClient){
        super(httpClient,'employees')
    }
}