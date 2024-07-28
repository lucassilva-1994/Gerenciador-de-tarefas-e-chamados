import { Project } from "../models/Project";
import { CRUDService } from "./crud.service";
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root'})
export class ProjectService extends CRUDService<Project>{
    constructor(httpClient: HttpClient){
        super(httpClient,'projects');
    }
}