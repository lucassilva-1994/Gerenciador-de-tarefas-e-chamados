import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subject, debounceTime, finalize, switchMap, takeUntil, tap } from 'rxjs';
import { Employee } from 'src/app/models/Employee';
import { EmployeeService } from 'src/app/services/employee.service';

@Component({
  templateUrl: './employees.component.html',
  styleUrls: ['./employees.component.css']
})
export class EmployeesComponent implements OnInit, OnDestroy {
  title: string = 'Funcionários';
  employees: Employee[] = [];
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
  constructor(private employeeService: EmployeeService) { }
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
