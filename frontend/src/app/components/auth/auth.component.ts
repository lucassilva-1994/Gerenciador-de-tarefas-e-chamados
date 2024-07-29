import { CommonModule } from '@angular/common';
import { Component, inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { UserService } from '../../services/user.service';
import { HttpErrorResponse } from '@angular/common/http';
import { catchError, of } from 'rxjs';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';

@Component({
  selector: 'app-auth',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink, MessagesValidatorsComponent],
  templateUrl: './auth.component.html',
  styleUrl: './auth.component.css'
})
export class AuthComponent implements OnInit {
  mode?: string;
  titleCard?: string;
  backendErrors: string[] = [];
  showPassword = false;
  formBuilder = inject(FormBuilder);
  route = inject(ActivatedRoute);
  userService = inject(UserService)
  signInForm: FormGroup = this.formBuilder.group({
    login: [''],
    password: ['']
  });
  forgotPasswordForm: FormGroup = this.formBuilder.group({
    email: ['']
  });

  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
    this.mode == 'sign-in' ? this.titleCard = 'Entrar' : this.titleCard = 'Recuperar senha';
  }

  toggleShowPassword() {
    this.showPassword = !this.showPassword;
  }

  signIn(): void {
    const handleErrors = (error: HttpErrorResponse) => { this.backendErrors = Object.values(error.error.errors); return of(null);};
    this.userService.signIn(this.signInForm.getRawValue()).pipe(catchError(handleErrors)).subscribe();
  }

  forgotPassword() {
    this.userService.forgotPassword(this.forgotPasswordForm.get('email')?.value).subscribe();
  }
}
