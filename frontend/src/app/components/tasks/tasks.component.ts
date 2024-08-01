import { Component, inject, OnInit, signal } from '@angular/core';
import { LayoutComponent } from '../shared/layout/layout.component';
import { ButtonSubmitComponent } from '../shared/button-submit/button-submit.component';
import { CardFormComponent } from '../shared/card-form/card-form.component';
import { ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, FormsModule, ReactiveFormsModule } from '@angular/forms';
import { Project } from '../../models/Project';
import { User } from '../../models/User';
import { NgClass } from '@angular/common';
import { TaskService } from '../../services/task.service';
import { HttpErrorResponse } from '@angular/common/http';
import { catchError, of, tap } from 'rxjs';
import { Task } from '../../models/Task';
import { MessageComponent } from '../shared/message/message.component';
import { LoadingComponent } from '../shared/loading/loading.component';
import { TableComponent } from '../shared/table/table.component';
import { UserService } from '../../services/user.service';
import { MessagesValidatorsComponent } from '../shared/messages-validators/messages-validators.component';
import { ProjectService } from '../../services/project.service';
import { TaskComment } from '../../models/TaskComment';

declare var window: any;

@Component({
  selector: 'app-tasks',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    LayoutComponent,
    ButtonSubmitComponent,
    CardFormComponent,
    MessageComponent,
    LoadingComponent,
    TableComponent,
    MessagesValidatorsComponent,
    NgClass,
    FormsModule
],
  templateUrl: './tasks.component.html',
  styleUrl: './tasks.component.css'
})
export class TasksComponent implements OnInit {
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'title', label: 'Title', icon: 'fas fa-tag' },
    { key: 'description', label: 'Descrição', icon: 'fas fa-info-circle' },
    { key: 'owner', label: 'Responsável', icon: 'fas fa-user' },
    { key: 'project', label: 'Projeto', icon: 'fas fa-user' },
    { key: 'is_done', label: 'Status', icon: 'fas fa-tasks' },
    { key: 'created_by', label: 'Criado por', icon: 'fas fa-user' },
    { key: 'created_at', label: 'Criado em', icon: 'fas fa-calendar-plus' },
  ];
  
  actions = [
    {
      label: '',
      icon: 'fa fa-refresh',
      class:'btn btn-outline-primary',
      title:'Alterar status',
      callback: (item: Task) => this.changeIsDone(item)
    }
  ];
  mode?: string;
  projects: Project[] = [];
  user: User | null = null;
  users: User[] = [];
  tasks: Task[] = [];
  comments: TaskComment[] = [];
  task: Task;
  backendErrors: string[] = [];
  backendProjectErrors: string[] = [];
  pages: number;
  total: number;

  //Comments section
  totalComments: number;
  pagesComments: number;
  perPageComments: number = 10;
  pageCurrent: number =  1;

  id: string;
  modalProject: any;
  private route = inject(ActivatedRoute);
  private taskService = inject(TaskService);
  private projectService = inject(ProjectService);
  private userService = inject(UserService);
  private formBuilder = inject(FormBuilder);
  form: FormGroup = this.formBuilder.group({
    title: [''],
    description: [''],
    is_done: [0],
    project_id: [''],
    owner_id: ['']
  });

  formProject: FormGroup = this.formBuilder.group({
    name: [''],
    description: ['']
  });

  get message(): string {
    return this.taskService.getMessage()();
  }

  get loading(): boolean {
    return this.taskService.getLoading()();
  }

  loadMoreComments() {
    this.perPageComments += 10;
    this.pageCurrent += 1;
    this.showComments(this.perPageComments);
  }

  ngOnInit(): void {
    this.user = this.userService.getUser()();
    this.mode = this.route.snapshot.data['mode'];
    this.modalProject = new window.bootstrap.Modal(document.getElementById('projectModal'))
    this.route.params.subscribe(params => {
      this.id = params['id'];
      if (this.mode === 'edit' && this.id) {
        this.showById(this.id);
        this.showComments(10);
      }
    });
    this.show({ perPage: 10, page: 1, search: '' });
    this.showProjects();
    this.showUsers();
  }
  

  formComment: FormGroup = this.formBuilder.group({
    comment: [''],
    task_id: []
  })

  currentTaskStatus: number | null = null;
  updateTaskStatus(status: number | null): void {
    this.currentTaskStatus = status;
    this.show({ perPage: 10, page: 1, search: '' });
  }

  show(event: { perPage: number, page: number, search: string }) {
    this.taskService.show(event.perPage, event.page, event.search, this.currentTaskStatus)
      .pipe(tap(response => {
        this.tasks = response.itens;
        this.pages = response.pages;
        this.total = response.total;
      }))
      .subscribe();
  }

  showById(id: string) {
    this.taskService.showById(id).pipe(
      tap(
        response => {
          this.form.patchValue(response);
          this.task = response;
        }
      )
    ).subscribe();
  }

  delete(event: { id: string }) {
    console.log(event.id);
    this.taskService.delete(event.id)
      .pipe(
        tap(() => {
          this.show({ perPage: 10, page: 1, search: '' });
        })
      ).subscribe();
  }

  showComments(perPage: number) {
    this.taskService.comments(this.id, perPage).subscribe(response => {
      this.comments = response.itens,
        this.totalComments = response.total,
        this.pagesComments = response.pages
    });
  }

  showProjects() {
    this.projects = this.route.snapshot.data['projects'];
  }

  showUsers() {
    this.users = this.route.snapshot.data['users'];
  }

  getUserName(id: string): string | undefined {
    const selectedUser = this.users.find(user => user.id === id);
    return selectedUser ? selectedUser?.name : '';
  }

  onSubmit() {
    const form = this.form.getRawValue() as Task;

    const handleSuccess = () => {
      if (this.mode === 'new' || this.mode === 'view') {
        this.form.reset();
      }

      this.show({ perPage: 10, page: 1, search: '' });
      this.backendErrors = [];

      if (this.mode === 'edit' && this.id) {
        this.showComments(this.perPageComments);
        this.showById(this.id);
      }
    };

    const handleErrors = (error: HttpErrorResponse) => {
      this.backendErrors = Object.values(error.error.errors);
      return of(null);
    };

    if (this.mode === 'new' || this.mode === 'view') {
      this.taskService.store(form)
        .pipe(tap(handleSuccess), catchError(handleErrors))
        .subscribe();
    } else if (this.mode === 'edit' && this.id) {
      this.taskService.update(form, this.id)
        .pipe(tap(handleSuccess), catchError(handleErrors))
        .subscribe();
    }
  }


  onSubmitProject() {
    const form = this.formProject.getRawValue() as Project;
    const handleSuccess = () => {
      this.projectService.showWithoutPagination(['id', 'name']).subscribe(response => this.projects = response)
      this.backendProjectErrors = [];
      this.modalProject.hide();
    };
    const handleErrors = (error: HttpErrorResponse) => {
      this.backendProjectErrors = Object.values(error.error.errors);
      return of(null);
    };
    this.projectService.store(form)
      .pipe(tap(handleSuccess), catchError(handleErrors)).subscribe();
  }

  onSubmitComment() {
    this.formComment.patchValue({ task_id: this.task.id });
    this.taskService.storeComment(this.formComment.getRawValue() as TaskComment)
      .subscribe(response => {
        this.showComments(this.perPageComments);
        this.formComment.reset();
      })
  }

  get showLoadMoreButton(): boolean {
    return this.pageCurrent <= this.pagesComments;
  }

  changeIsDone(task: Task) {
    task.is_done = task.is_done === 0 ? 1 : 0;
    const is_done = {
      is_done: task.is_done,
      title: task.title,
      description: task.description,
      owner_id: task.owner_id
    }
    this.taskService.update(is_done as Task, task.id).subscribe();
  }

  openModalProject() {
    this.modalProject.show();
  }
}
