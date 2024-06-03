import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { environment } from "src/environments/environment";

const apiUrl = environment.apiUrl+'/permissions_roles' 
@Injectable({ providedIn: 'root'})
export class PermissionRoleService{
    constructor(private httpClient:HttpClient){}  
    store(roleId: string, permissionId: string): Observable<{message: string}>{
        return this.httpClient.post<{message: string}>(`${apiUrl}/store/${roleId}/${permissionId}`,{})
    }
    delete(roleId: string, permissionId: string): Observable<{message: string}>{
        return this.httpClient.delete<{message: string}>(`${apiUrl}/delete/${roleId}/${permissionId}`)
    }
}