import { inject, Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpErrorResponse, HttpInterceptor } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { Router } from '@angular/router';
import { MessageService } from '../services/message.service';

@Injectable()
export class Token implements HttpInterceptor {

  private message = inject(MessageService);
  constructor(private router: Router) { }
  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
    const token = localStorage.getItem('token');

    if (token) {
      request = request.clone({
        setHeaders: {
          Authorization: `Bearer ${token}`,
          Accept: `application/json`
        }
      });
    }

    return next.handle(request).pipe(
      catchError((error: HttpErrorResponse) => {
        if (error.status === 401) {
          this.router.navigate(['/']);
        } else if (error.status === 403 && error.error.error == 'Senha expirada') {
          this.message.setMessage('Sua senha expirou. Por favor, atualize sua senha para continuar.');
          this.router.navigate(['/change-password']);
        } else if (error.status === 403) {
          this.router.navigate(['/forbidden']);
        } else if (error.status === 404) {
          this.router.navigate(['/not-found']);
        }
        return throwError(error);
      })
    );
  }
}