import { Observable } from "rxjs";
import { Task } from "../models/Task";
import { CRUDService } from "./crud.service";
import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { TaskComment } from "../models/TaskComment";

@Injectable({ providedIn: 'root'})
export class TaskService extends CRUDService<Task>{
    private pathApiUrl: string = 'http://127.0.0.1:8000/api/tasks/comments';
    constructor(httpClient: HttpClient){
        super(httpClient,'tasks');
    }

    comments(id: string, perPage: number = 3): Observable<{ pages: number, total: number, search: string, itens: TaskComment[] }>{
        const params = new HttpParams().set('perPage',perPage);
        return this.httpClient.get<{ pages: number, total: number, search: string, itens: TaskComment[]}>(`${this.pathApiUrl}/show/${id}`,{params});
    }

    storeComment(comment: TaskComment): Observable<{message: string}>{
        return this.httpClient.post<{message: string}>(`${this.pathApiUrl}/store-comment`,comment);
    }
}