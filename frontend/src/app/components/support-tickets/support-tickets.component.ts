import { Component, ElementRef, OnDestroy, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { Observable, Subject, tap } from 'rxjs';
import { Employee } from 'src/app/models/Employee';
import { Project } from 'src/app/models/Project';
import { SupportTicket } from 'src/app/models/SupportTicket';
import { User } from 'src/app/models/User';
import { ProjectService } from 'src/app/services/project.service';
import { SupportticketService } from 'src/app/services/support_tickets.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-support-tickets',
  templateUrl: './support-tickets.component.html',
  styleUrls: ['./support-tickets.component.css']
})
export class SupportTicketsComponent implements OnInit, OnDestroy {
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'title', label: 'Titulo', icon: 'fas fa-tasks' },
    { key: 'description', label: 'Descrição', icon: 'fas fa-align-left' },
    { key: 'project', label: 'Projeto', icon: 'fas fa-project-diagram' },
    { key: 'status', label: 'Status', icon: 'fas fa-clipboard-check' },
    { key: 'owner', label: 'Responsável', icon: 'fas fa-user-tag' },
    { key: 'created_by', label: 'Criado por', icon: 'fas fa-user-plus' },
    { key: 'modified_by', label: 'Alterado por', icon: 'fas fa-user-edit' },
  ];
  user$: Observable<User | null>;
  form: FormGroup;
  classColTitle: string = 'col-sm-8';
  formProject: FormGroup;
  employees: Employee[] = [];
  projects: Project[] = [];
  supportTickets: SupportTicket[] = [];
  @ViewChild('projectModal') projectModal: ElementRef;
  private destroy$ = new Subject<void>();
  constructor(
    private formBuilder: FormBuilder,
    private supportTicketService: SupportticketService,
    private projectService: ProjectService,
    private route: ActivatedRoute,
    private userService: UserService) { }
  ngOnInit(): void {
    this.user$ = this.userService.getUser().pipe(
      tap(user => {
        if (user?.visibility_level == 'RESTRICTED') {
          this.form.patchValue({
            owner_id: user.employee_id
          });
          this.classColTitle = 'col-sm-12';
        }
      })
    );
    this.employees = this.route.snapshot.data['employees'];
    this.projects = this.route.snapshot.data['projects'];
    this.form = this.formBuilder.group({
      title: ['', [Validators.required, Validators.maxLength(100)]],
      description: ['', Validators.minLength(10)],
      owner_id: ['', [Validators.required]],
      project_id: ['']
    });
    this.formProject = this.formBuilder.group({
      name: ['', [Validators.required, Validators.minLength(3), Validators.maxLength(50)]],
      description: ['', Validators.minLength(10)]
    });
    this.show();
  }

  show() {
    this.projectService.showWithoutPagination('id,name')
      .pipe(tap(response => this.projects = response))
      .subscribe();
    this.supportTicketService.show().subscribe(response => {
      this.supportTickets = response.itens
      console.log(this.supportTickets);
    });
  }

  getEmployeeName(id: string): string {
    const selectedEmployee = this.employees.find(employee => employee.id === id);
    return selectedEmployee ? selectedEmployee.name : '';
  }

  ngOnDestroy(): void {
    this.destroy$.next();
    this.destroy$.complete();
  }

  store() {
    this.supportTicketService.store(this.form.getRawValue() as SupportTicket)
      .pipe(
        tap(response => {
          this.show();
          alert(response.message);
          this.form.patchValue({
            title: '',
            description: '',
            project_id: ''
          })
        })
      ).subscribe();
  }

  storeProject() {
    this.projectService.store(this.formProject.getRawValue() as Project)
      .pipe(tap(
        () => {
          this.formProject.reset();
          this.show();
          this.projectModal.nativeElement.style.display = 'none';
          document.querySelector('.modal-backdrop')?.remove();
        }
      )).subscribe();
  }

  delete(event: {id: string}){
    this.supportTicketService.delete(event.id).pipe(tap(() => this.show())).subscribe();
  }
}
