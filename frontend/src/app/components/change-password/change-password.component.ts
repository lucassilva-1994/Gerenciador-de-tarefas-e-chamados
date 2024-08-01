import { Component, inject, OnInit } from '@angular/core';
import { LayoutComponent } from '../shared/layout/layout.component';
import { User } from '../../models/User';
import { UserService } from '../../services/user.service';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { catchError, of, tap } from 'rxjs';
import { CommonModule, DatePipe } from '@angular/common';
import { HttpErrorResponse } from '@angular/common/http';
import { MessageService } from '../../services/message.service';

@Component({
  standalone: true,
  imports: [LayoutComponent, MessagesValidatorsComponent, ReactiveFormsModule, DatePipe],
  templateUrl: './change-password.component.html',
  styleUrl: './change-password.component.css'
})
export class ChangePasswordComponent implements OnInit {
  user: User | undefined;
  showPassword = false;
  backendErrors: string[] = [];
  passwordExpired = false;
  message: string | null;
  private userService = inject(UserService);
  private formBuilder = inject(FormBuilder);
  private messageService = inject(MessageService);
  form: FormGroup = this.formBuilder.group({
    id: [''],
    password:[''],
    password_confirmation:['']
  })
  ngOnInit(): void {
    this.profile();
    if(this.messageService.getMessage()()){
      this.message = this.messageService.getMessage()();
      this.passwordExpired = true;
    }
  }

  profile() {
    this.userService.profile().subscribe(response => {
      this.user = response
    });
  }

  toggleShowPassword() {
    this.showPassword = !this.showPassword;
  }

  onSubmit(){
    this.form.patchValue({
      id:this.user?.id
    });
    const handleSuccess = () => {
      this.profile();
      this.passwordExpired = false;
      this.message = 'Senha atualizada com sucesso.'
      this.form.reset();
      this.backendErrors = [];
    };
  
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = error.error?.errors
        ? Object.values(error.error.errors)
        : ['Erro desconhecido'];
      return of(null);
    };
  
    this.userService.changePassword(this.form.getRawValue())
      .pipe(
        tap(handleSuccess),
        catchError(handleErrors)
      )
      .subscribe();
  }
}
