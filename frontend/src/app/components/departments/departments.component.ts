import { Component, inject, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { LayoutComponent } from '../shared/layout/layout.component';
import { CardFormComponent } from '../shared/card-form/card-form.component';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { ButtonSubmitComponent } from '../shared/button-submit/button-submit.component';
import { DepartmentService } from '../../services/department.service';
import { Department } from '../../models/Department';
import { catchError, of, tap } from 'rxjs';
import { NgFor, NgIf } from '@angular/common';
import { TableComponent } from '../shared/table/table.component';
import { HttpErrorResponse } from '@angular/common/http';
import { MessageComponent } from './../shared/message/message.component';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { LoadingComponent } from '../shared/loading/loading.component';

@Component({
  selector: 'app-departments',
  standalone: true,
  imports: [
    LayoutComponent, CardFormComponent, ReactiveFormsModule,
    ButtonSubmitComponent, NgFor, TableComponent, NgIf, MessagesValidatorsComponent,
    MessageComponent, LoadingComponent
  ],
  templateUrl: './departments.component.html',
  styleUrl: './departments.component.css'
})
export class DepartmentsComponent implements OnInit {
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'name', label: 'Nome', icon: 'fas fa-tag' },
    { key: 'description', label: 'Descrição', icon: 'fas fa-info-circle' },
    { key: 'users_count', label: 'Usuários', icon: 'fas fa-user-circle' },
    { key: 'created_by', label: 'Criado por', icon: 'fas fa-user-plus' },
    { key: 'modified_by', label: 'Alterado por', icon: 'fas fa-user-edit' },
    { key: 'created_at', label: 'Criado em', icon: 'fas fa-calendar-plus' },
    { key: 'updated_at', label: 'Alterado em', icon: 'fas fa-calendar-check' },
  ];
  mode: string;
  departments: Department[] = [];
  private route = inject(ActivatedRoute);
  private formBuilder = inject(FormBuilder);
  private departmentService = inject(DepartmentService);
  backendErrors: string[] = [];
  pages: number;
  total: number;
  id: string;
  form: FormGroup = this.formBuilder.group({
    name: [''],
    description: ['']
  });

  get message(): string {
    return this.departmentService.getMessage()();
  }

  get loading(): boolean {
    return this.departmentService.getLoading()();
  }
  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
    this.route.params.subscribe(params => {
      this.id = params['id'];
      if (this.mode === 'edit' && this.id) {
        this.showById(this.id);
      }
    });
    this.show({ perPage: 10, page: 1, search: '' });
  }
  show(event: { perPage: number, page: number, search: string }) {
    this.departmentService.show(event.perPage, event.page, event.search)
      .pipe(tap(response => {
        this.departments = response.itens;
        this.pages = response.pages;
        this.total = response.total;
      }))
      .subscribe();
  }
  showById(id: string) {
    this.departmentService.showById(id).pipe(
      tap(
        response => {
          this.form.patchValue(response);
        }
      )
    ).subscribe();
  }
  delete(event: { id: string }) {
    console.log(event.id);
    this.departmentService.delete(event.id)
      .pipe(
        tap(() => {
          this.show({ perPage: 10, page: 1, search: '' });
        })
      ).subscribe();
  }

  onSubmit() {
    const form = this.form.getRawValue() as Department;
    const handleSuccess = () => { this.mode === 'new' || this.mode === 'view' ? this.form.reset() : null; this.show({ perPage: 10, page: 1, search: '' }); this.backendErrors = []; };
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };
    (this.mode === 'new' || this.mode === 'view' ? this.departmentService.store(form) : this.departmentService.update(form, this.id))
      .pipe(tap(handleSuccess), catchError(handleErrors)).subscribe();
  }
}
