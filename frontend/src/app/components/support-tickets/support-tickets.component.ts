import { Component, ElementRef, OnDestroy, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { Subject, tap } from 'rxjs';
import { Employee } from 'src/app/models/Employee';
import { Project } from 'src/app/models/Project';
import { SupportTicket } from 'src/app/models/SupportTicket';
import { EmployeeService } from 'src/app/services/employee.service';
import { ProjectService } from 'src/app/services/project.service';
import { SupportticketService } from 'src/app/services/support_tickets.service';

@Component({
  selector: 'app-support-tickets',
  templateUrl: './support-tickets.component.html',
  styleUrls: ['./support-tickets.component.css']
})
export class SupportTicketsComponent implements OnInit, OnDestroy {
  title: string = 'Chamados';
  form: FormGroup;
  formProject: FormGroup;
  employees: Employee[] = [];
  projects: Project[] = [];
  @ViewChild('projectModal') projectModal: ElementRef;
  private destroy$ = new Subject<void>();
  constructor(
    private formBuilder: FormBuilder,
    private employeeService: EmployeeService,
    private supportTicketService: SupportticketService,
    private projectService: ProjectService,
    private route: ActivatedRoute) { }
  ngOnInit(): void {
    this.projects = this.route.snapshot.data['projects'];
    this.employees = this.route.snapshot.data['employees'];
    this.form = this.formBuilder.group({
      title: [''],
      description: [''],
      owner_id: [''],
      project_id: ['']
    });
    this.formProject = this.formBuilder.group({
      name: [''],
      description: ['']
    });
    this.show();
  }

  ngOnDestroy(): void {
    this.destroy$.next();
    this.destroy$.complete();
  }

  show() {
    this.employeeService.show(100)
      .pipe(
        tap(response => {
          this.employees = response.itens
        })
      ).subscribe();
    this.projectService.show(100)
    .pipe( tap(response => {
      this.projects = response.itens
    })).subscribe();
  }

  store() {
    this.supportTicketService.store(this.form.getRawValue() as SupportTicket)
    .pipe(
      tap(response => {
        this.form.reset();
        this.show();
        alert(response.message);
      })
    ).subscribe();
  }

  storeProject() {
    this.projectService.store(this.formProject.getRawValue() as Project)
    .pipe(tap(
       () => {
        this.show();
        this.formProject.reset();
        this.projectModal.nativeElement.style.display = 'none';
        document.querySelector('.modal-backdrop')?.remove();
      }
    )).subscribe();
  }
}
