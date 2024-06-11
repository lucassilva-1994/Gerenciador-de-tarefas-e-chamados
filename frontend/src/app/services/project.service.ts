import { Injectable } from "@angular/core";
import { Project } from "../models/Project";
import { CrudService } from "./crud.service";
import { HttpClient } from "@angular/common/http";

@Injectable({ providedIn: 'root'})
export class ProjectService extends CrudService<Project>{
    constructor(httpClient: HttpClient){
        super(httpClient,'projects');
    }
}