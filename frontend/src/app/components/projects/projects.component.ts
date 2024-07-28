import { Component, inject, OnInit } from '@angular/core';
import { LayoutComponent } from '../shared/layout/layout.component';
import { CardFormComponent } from '../shared/card-form/card-form.component';
import { ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { ButtonSubmitComponent } from '../shared/button-submit/button-submit.component';
import { HttpErrorResponse } from '@angular/common/http';
import { Project } from '../../models/Project';
import { catchError, of, tap } from 'rxjs';
import { ProjectService } from '../../services/project.service';
import { LoadingComponent } from '../shared/loading/loading.component';
import { MessageComponent } from '../shared/message/message.component';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { TableComponent } from '../shared/table/table.component';

@Component({
  selector: 'app-projects',
  standalone: true,
  imports: [
    LayoutComponent, CardFormComponent, ReactiveFormsModule, ButtonSubmitComponent,
    LoadingComponent, MessageComponent, MessagesValidatorsComponent, TableComponent
  ],
  templateUrl: './projects.component.html',
  styleUrl: './projects.component.css'
})
export class ProjectsComponent implements OnInit {
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'name', label: 'Nome', icon: 'fas fa-tag' },
    { key: 'description', label: 'Descrição', icon: 'fas fa-info-circle' },
    { key: 'created_by', label: 'Criado por', icon: 'fas fa-user-plus' },
    { key: 'modified_by', label: 'Alterado por', icon: 'fas fa-user-edit' },
    { key: 'created_at', label: 'Criado em', icon: 'fas fa-calendar-plus' },
    { key: 'updated_at', label: 'Alterado em', icon: 'fas fa-calendar-check' }
  ];
  mode?: string;
  backendErrors: string[] = [];
  pages: number;
  total: number;
  id: string;
  projects: Project[] = [];
  private route = inject(ActivatedRoute);
  private formBuilder = inject(FormBuilder);
  private projectService = inject(ProjectService);
  form: FormGroup = this.formBuilder.group({
    name: [''],
    description: ['']
  });
  get message(): string {
    return this.projectService.getMessage()();
  }

  get loading(): boolean {
    return this.projectService.getLoading()();
  }
  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
    this.route.params.subscribe(params => {
      this.id = params['id'];
      if (this.mode === 'edit' && this.id) {
        this.showById(this.id);
      }
    });
    this.show({ perPage: 10, page: 1, search: '' }); this.mode = this.route.snapshot.data['mode'];
  }

  show(event: { perPage: number, page: number, search: string }) {
    this.projectService.show(event.perPage, event.page, event.search)
      .pipe(tap(response => {
        this.projects = response.itens;
        this.pages = response.pages;
        this.total = response.total;
      }))
      .subscribe();
  }
  showById(id: string) {
    this.projectService.showById(id).pipe(
      tap(
        response => {
          this.form.patchValue(response);
        }
      )
    ).subscribe();
  }
  delete(event: { id: string }) {
    console.log(event.id);
    this.projectService.delete(event.id)
      .pipe(
        tap(() => {
          this.show({ perPage: 10, page: 1, search: '' });
        })
      ).subscribe();
  }

  onSubmit() {
    const form = this.form.getRawValue() as Project;
    const handleSuccess = () => { this.mode === 'new' || this.mode === 'view' ? this.form.reset() : null; this.show({ perPage: 10, page: 1, search: '' }); this.backendErrors = []; };
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };
    (this.mode === 'new' || this.mode === 'view' ? this.projectService.store(form) : this.projectService.update(form, this.id))
      .pipe(tap(handleSuccess), catchError(handleErrors)).subscribe();
  }
}
