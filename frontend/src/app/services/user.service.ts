import { HttpClient } from "@angular/common/http";
import { inject, Injectable, signal } from "@angular/core";
import { Router } from "@angular/router";
import { Observable, take, tap } from "rxjs";
import { User } from "../models/User";
import { CRUDService } from "./crud.service";
import jwt_decode from "jwt-decode";
import { environment } from "../../environments/environment";
interface LoginResponse {
    token?: string;
    message?: string;
}
const apiUrl = environment.apiUrl + 'users';
@Injectable({ providedIn: 'root' })
export class UserService extends CRUDService<User> {
    private route = inject(Router);
    private user = signal<User | null>(null);

    constructor(httpClient: HttpClient) {
        super(httpClient, 'users');
        this.decode();
    }

    getUser() {
        return this.user;
    }

    setToken(token: string) {
        localStorage.setItem('token', token);
        this.decode();
    }

    private decode() {
        const token = localStorage.getItem('token');

        if (token) {
            const user = jwt_decode(token) as User;
            this.user.set(user);
        } else {
            console.error('Token não encontrado ou é nulo.');
        }
    }

    signIn(login: { login: string, password: string }): Observable<LoginResponse> {
        return this.httpClient.post<LoginResponse>(`${apiUrl}/sign-in`, login)
            .pipe(tap(response => {
                if (response.token) {
                    this.setToken(response.token);
                }
                this.route.navigate(['/tasks'])
            })
            );
    }
    signOut(): void {
        this.httpClient.get<{ message: string }>(`${apiUrl}/sign-out`)
            .pipe(
                tap(
                    () => {
                        localStorage.removeItem('token');
                        this.user.set(null);
                        this.route.navigate(['/']);
                    }
                )
            ).subscribe();
    }

    changePassword(user: User): Observable<{ message: string }> {
        return this.httpClient.put<{ message: string }>(`${apiUrl}/change-password`, user)
            .pipe(
                take(1)
            );
    }

    forgotPassword(email: string): Observable<{ message: string }> {
        return this.httpClient.post<{ message: string }>(`${apiUrl}/forgot-password`, { email })
            .pipe(tap(response => {
                console.log(response);
            }));
    }

    profile(): Observable<User> {
        return this.httpClient.get<User>(`${this.apiUrl}/profile`);
    }
}