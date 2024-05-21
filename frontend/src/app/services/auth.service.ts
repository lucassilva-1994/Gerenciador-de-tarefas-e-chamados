import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { User } from "../models/User";
import { environment } from "src/environments/environment";
import { Observable, tap } from "rxjs";
import { UserService } from "./user.service";

const apiUrl = environment.apiUrl;
@Injectable({providedIn:'root'})
export class AuthService{
    constructor(private httpClient: HttpClient, private userService: UserService){}

    auth(user: User): Observable<{message: string}>{
        return this.httpClient.post<{message:string}>(apiUrl+'sign-in',user)
        .pipe(tap((response) => {
             this.userService.setToken(response.toString());
        }));
    }
}