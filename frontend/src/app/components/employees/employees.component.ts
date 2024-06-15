import { Component, ElementRef, OnDestroy, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Subject, debounceTime, finalize, switchMap, takeUntil, tap } from 'rxjs';
import { Department } from 'src/app/models/Department';
import { Employee } from 'src/app/models/Employee';
import { Position } from 'src/app/models/Position';
import { DepartmentService } from 'src/app/services/department.service';
import { EmployeeService } from 'src/app/services/employee.service';
import { PositionService } from 'src/app/services/position.service';

@Component({
  templateUrl: './employees.component.html',
  styleUrls: ['./employees.component.css']
})
export class EmployeesComponent implements OnInit, OnDestroy {
  title: string = 'Funcionários';
  employees: Employee[] = [];
  positions: Position[] = [];
  departments: Department[] = [];
  loading: boolean = true;
  perPage: number = 10;
  page: number = 1;
  pages: number;
  total: number;
  options: Number[] = [5, 10, 25, 50, 100];
  search: string = '';
  showMessage: boolean = false;
  columnToSort: string = '';
  sortDirection: number = 1;
  private searchSubject: Subject<string> = new Subject();
  private destroy$ = new Subject<void>();
  @ViewChild('employeeEditModal') employeeEditModal: ElementRef;
  employee: Employee;
  formEdit: FormGroup;
  constructor(
    private employeeService: EmployeeService, 
    private positionService: PositionService,
    private departmentService: DepartmentService,
    private formBuilder: FormBuilder) { }
  ngOnInit(): void {
    this.show();
    this.searchSubject.pipe(
      debounceTime(3000),
      switchMap(search => this.employeeService.show(this.perPage, this.page, search)),
      tap(response => {
        this.employees = response.itens;
        this.pages = response.pages;
        this.total = response.total;
        this.title = `Funcionários (${this.total})`;
        if (this.page > this.pages) {
          this.page = 1;
          this.show();
        }
      }),
      takeUntil(this.destroy$)
    ).subscribe(() => this.loading = false);
    this.formEdit = this.formBuilder.group({
      id:[''],
      name: ['',[Validators.required, Validators.maxLength(100), Validators.minLength(3)]],
      email: ['',[Validators.required, Validators.minLength(10), Validators.maxLength(100), Validators.email]],
      position_id: ['', [Validators.required]],
      department: ['']
    })
  }

  ngOnDestroy(): void {
    this.destroy$.next();
    this.destroy$.complete();
  }

  filter() {
    this.searchSubject.next(this.search);
  }

  show() {
    this.employeeService.show(this.perPage, this.page, this.search).subscribe(response => {
      this.employees = response.itens;
      this.pages = response.pages;
      this.total = response.total;
      this.title = `Funcionários (${this.total})`;
      if (this.page > this.pages) this.page = 1;
      this.loading = false;
    });
    this.positionService.show(100)
    .pipe(tap( response => {
      this.positions = response.itens;
    })).subscribe();

    this.departmentService.show(100)
    .pipe(tap( response => {
      this.departments = response.itens;
    })).subscribe();
  }

  openModalEditEmployee(employee: Employee){
    this.formEdit.patchValue({
      id: employee.id,
      name: employee.name,
      email: employee.email,
      position_id: employee.position.id,
      department: employee.department.id
    });
  }
  
  updateEmployee(){
    this.employeeService.update(this.formEdit.getRawValue() as Employee, this.formEdit.get('id')?.value)
    .pipe(tap(response => {
      this.employeeEditModal.nativeElement.style.display = 'none';
      document.querySelector('.modal-backdrop')?.remove();
      this.show();
    })).subscribe();
  }

  sortBy(columnName: string) {
    const sortOrder = (columnName === this.columnToSort) ? -this.sortDirection : 1;
    this.columnToSort = columnName;

    this.employees.sort((a, b) => {
      const aValue = this.getPropertyValue(a, columnName);
      const bValue = this.getPropertyValue(b, columnName);

      if (aValue === bValue) return 0;
      return (aValue < bValue ? -1 : 1) * sortOrder;
    });
    this.sortDirection = sortOrder;
  }

  getPropertyValue(obj: any, propertyName: string) {
    return propertyName.split('.').reduce((acc, prop) => acc?.[prop], obj);
  }

  delete(id: string) {
    if (confirm("Tem certeza que deseja excluir este item?")) {
      this.employeeService.delete(id)
        .pipe(tap(response => {
          this.show();
          alert(response.message);
        }))
        .subscribe();
    }
  }

  onChangePerPage(event: Event) {
    const target = event.target as HTMLSelectElement;
    this.perPage = parseInt(target.value, 10);
    this.page = 1;
    this.show();
  }

  changePage(page: number) {
    if (page >= 1 && page <= this.pages) {
      this.page = page;
      this.show();
    }
  }

  //Pegando a quantidade de páginas que vem do backend e transformando em um array iniciando em 5 e finalizando na quantidade informada pelo backend
  pageNumbers(): number[] {
    const pageNumbers: number[] = [];
    const numLinksToShow = 5;
    let startPage = Math.max(1, this.page - numLinksToShow);
    let endPage = Math.min(this.pages, this.page + numLinksToShow);
    if (this.page <= numLinksToShow) {
      endPage = Math.min(numLinksToShow * 2 + 1, this.pages);
    } else if (this.page >= this.pages - numLinksToShow) {
      startPage = Math.max(this.pages - numLinksToShow * 2, 1);
    }
    for (let i = startPage; i <= endPage; i++) {
      pageNumbers.push(i);
    }
    return pageNumbers;
  }
}
