import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { TokenService } from './token.service';
import jwt_decode from "jwt-decode";
import { User } from '../models/User';

const apiUrl = environment.apiUrl + 'users';
@Injectable({ providedIn: 'root' })
export class UserService {
    private userSubject = new BehaviorSubject<User | null>(null);
    constructor(private httpClient: HttpClient, private tokenService: TokenService) {
        this.tokenService.hasToken() && this.decode();
    }

    setToken(token: string) {
        this.tokenService.setToken(token);
        this.decode();
    }

    getUser(): Observable<User | null> {
        return this.userSubject.asObservable();
    }

    private decode() {
        const token = this.tokenService.getToken();

        if (token) {
            const user = jwt_decode(token) as User;
            this.userSubject.next(user);
        } else {
            console.error('Token não encontrado ou é nulo.');
        }
    }

    logout(){
        this.tokenService.removeToken();
        this.userSubject.next(null);
    } 
    
    isLogged(){
        return this.tokenService.hasToken();
    }

    show(): Observable<User[]> {
        return this.httpClient.get<User[]>(apiUrl + '/show');
    }

    showById(id: string): Observable<User>{
        return this.httpClient.get<User>(apiUrl + `/show-by-id/${id}`);
    }

    store(user: User){
        return this.httpClient.post(apiUrl+'/store', user);
    }

    update(id: string, user: User){
        return this.httpClient.put(`${apiUrl}/update/${id}`, user);
    }

    delete(id: string){
        return this.httpClient.delete(apiUrl+`/delete/${id}`);
    }

    changePassword(user: User){
        return this.httpClient.put(`${apiUrl}/change-password`, user);
    }
}