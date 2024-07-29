import { Component, inject, OnInit } from '@angular/core';
import { LayoutComponent } from '../shared/layout/layout.component';
import { MessageComponent } from '../shared/message/message.component';
import { HttpErrorResponse } from '@angular/common/http';
import { catchError, of, tap } from 'rxjs';
import { ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { User } from '../../models/User';
import { UserService } from './../../services/user.service';
import { LoadingComponent } from '../shared/loading/loading.component';
import { CardFormComponent } from '../shared/card-form/card-form.component';
import { ButtonSubmitComponent } from '../shared/button-submit/button-submit.component';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { TableComponent } from '../shared/table/table.component';
import { Department } from '../../models/Department';
import { NgFor, NgIf } from '@angular/common';
import { DepartmentService } from '../../services/department.service';

declare var window: any;

@Component({
  selector: 'app-users',
  standalone: true,
  imports: [
    LayoutComponent, MessageComponent, LoadingComponent, CardFormComponent, ReactiveFormsModule,
    ButtonSubmitComponent, MessagesValidatorsComponent, TableComponent, NgFor, NgIf
  ],
  templateUrl: './users.component.html',
  styleUrl: './users.component.css'
})
export class UsersComponent implements OnInit {
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'name', label: 'Nome', icon: 'fas fa-id-badge' },
    { key: 'username', label: 'Usuário', icon: 'fas fa-user' },
    { key: 'email', label: 'Email', icon: 'fas fa-envelope' },
    { key: 'department', label: 'Departamento', icon: 'fas fa-building' },
    { key: 'visibility', label: 'Visibilidade', icon: 'fas fa-eye' },
  ];
  actions = [
    {
      label: '',
      icon: 'fa fa-lock',
      class: 'btn btn-outline-success',
      title: 'Alterar senha',
      callback: (item: User) => this.openModalChangePassword(item)
    }
  ];
  mode?: string;
  backendErrors: string[] = [];
  backendDepartmentErrors: string[] = [];
  backendPasswordErrors: string[] = [];
  pages: number;
  total: number;
  id: string;
  users: User[] = [];
  user: User | null;
  departments: Department[] = [];
  modalDepartment: any;
  modalChangePassword: any;
  showPassword = false;
  private route = inject(ActivatedRoute);
  private formBuilder = inject(FormBuilder);
  private userService = inject(UserService);
  private departmentService = inject(DepartmentService);
  form: FormGroup = this.formBuilder.group({
    name: [''],
    email: [''],
    username:[''],
    visibility:[3],
    password:[''],
    password_confirmation:[''],
    department_id: ['']
  });
  formDepartment: FormGroup = this.formBuilder.group({
      name:[''],
      description:['']
  })

  formChangePassword: FormGroup = this.formBuilder.group({
      id:[''],
      password: [''],
      password_confirmation:['']
  });
  get message(): string {
    return this.userService.getMessage()();
  }

  get loading(): boolean {
    return this.userService.getLoading()();
  }
  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
    this.user = this.userService.getUser()();
    this.showDepartments();
    this.modalDepartment = new window.bootstrap.Modal(document.getElementById('departmentModal'))
    this.modalChangePassword = new window.bootstrap.Modal(document.getElementById('changePasswordModal'))
    this.route.params.subscribe(params => {
      this.id = params['id'];
      if (this.mode === 'edit' && this.id) {
        this.showById(this.id);
      }
    });
    this.show({ perPage: 10, page: 1, search: '' }); this.mode = this.route.snapshot.data['mode'];
  }


  show(event: { perPage: number, page: number, search: string }) {
    this.userService.show(event.perPage, event.page, event.search)
      .pipe(tap(response => {
        this.users = response.itens;
        this.pages = response.pages;
        this.total = response.total;
      }))
      .subscribe();
  }

  showDepartments(){
    this.departments = this.route.snapshot.data['departments'];
  }

  showById(id: string) {
    this.userService.showById(id).pipe(
      tap(
        response => {
          this.form.patchValue(response);
        }
      )
    ).subscribe();
  }
  delete(event: { id: string }) {
    console.log(event.id);
    this.userService.delete(event.id)
      .pipe(
        tap(() => {
          this.show({ perPage: 10, page: 1, search: '' });
        })
      ).subscribe();
  }

  onSubmit() {
    const form = this.form.getRawValue() as User;
    const handleSuccess = () => { this.mode === 'new' || this.mode === 'view' ? this.form.reset() : null; this.show({ perPage: 10, page: 1, search: '' }); this.backendErrors = []; };
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };
    (this.mode === 'new' || this.mode === 'view' ? this.userService.store(form) : this.userService.update(form, this.id))
      .pipe(tap(handleSuccess), catchError(handleErrors)).subscribe();
  }

  onSubmitDepartment(){
    const form = this.formDepartment.getRawValue() as Department;
    const handleSuccess = () => {
      this.departmentService.showWithoutPagination(['id','name']).subscribe(response => this.departments = response)
      this.backendDepartmentErrors = [];
      this.modalDepartment.hide();
    };
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendDepartmentErrors = Object.values(error.error.errors);
      return of(null);
    };
    this.departmentService.store(form)
      .pipe(tap(handleSuccess), catchError(handleErrors)).subscribe();
  }

  openModalDepartment(){
    this.modalDepartment.show();
  }

  openModalChangePassword(user: User){
    this.user = user;
    this.modalChangePassword.show();
  }

  changePassword() {
    this.formChangePassword.patchValue({
      id:this.user?.id
    })
    const handleSuccess = () => {
      this.modalChangePassword.hide();
      this.formChangePassword.reset();
    };
  
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendPasswordErrors = error.error?.errors
        ? Object.values(error.error.errors)
        : ['Erro desconhecido'];
      return of(null);
    };
  
    this.userService.changePassword(this.formChangePassword.getRawValue())
      .pipe(
        tap(handleSuccess),
        catchError(handleErrors)
      )
      .subscribe();
  }
  

  toggleShowPassword() {
    this.showPassword = !this.showPassword;
  }
}
