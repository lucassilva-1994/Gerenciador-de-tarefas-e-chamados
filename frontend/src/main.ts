import { bootstrapApplication, BrowserModule } from '@angular/platform-browser';
import { AppComponent } from './app/app.component';
import { importProvidersFrom } from '@angular/core';
import { provideRouter } from '@angular/router';
import { APP_ROUTES } from './app/app.routes';
import { HTTP_INTERCEPTORS, provideHttpClient, withInterceptorsFromDi } from '@angular/common/http';
import { Token } from './app/core/token.interceptor';
import { MessageService } from './app/services/message.service';

bootstrapApplication(AppComponent, {
  providers:[
    MessageService,
    importProvidersFrom(BrowserModule),
    {
      provide: HTTP_INTERCEPTORS,
      useClass: Token,
      multi: true
    },
    provideHttpClient(withInterceptorsFromDi()),
    provideRouter(APP_ROUTES)
  ]
})
  .catch((err) => console.error(err));
