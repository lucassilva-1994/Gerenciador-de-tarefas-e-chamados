import { Injectable } from "@angular/core";
import { CrudService } from "./crud.service";
import { HttpClient } from "@angular/common/http";
import { Task } from "../models/Task";

@Injectable({ providedIn: 'root'})
export class TaskService extends CrudService<Task>{
    constructor(httpClient: HttpClient){
        super(httpClient,'tasks')
    }
}