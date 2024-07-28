import { CommonModule } from '@angular/common';
import { Component, inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { UserService } from '../../services/user.service';
import { Login } from '../../models/Login';

@Component({
  selector: 'app-auth',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink],
  templateUrl: './auth.component.html',
  styleUrl: './auth.component.css'
})
export class AuthComponent implements OnInit {
  mode?: string;
  titleCard?: string;
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
    this.userService.signIn(this.signInForm.getRawValue()).subscribe();
  }

  forgotPassword() {
    this.userService.forgotPassword(this.forgotPasswordForm.get('email')?.value).subscribe();
  }
}
