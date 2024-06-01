import { Component, OnDestroy, OnInit } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { Department } from 'src/app/models/Department';
import { DepartmentService } from 'src/app/services/department.service';
import { debounceTime,  switchMap, take, takeUntil, tap } from 'rxjs/operators';
import { FormBuilder, FormGroup } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { PositionService } from 'src/app/services/position.service';
import { Position } from 'src/app/models/Position';

@Component({
  selector: 'app-departments',
  templateUrl: './departments.component.html',
  styleUrls: ['./departments.component.css']
})
export class DepartmentsComponent implements OnInit, OnDestroy {
  departments$: Observable<Department[]>;
  departments: Department[] = [];
  form: FormGroup;
  title: string = 'Departamentos';
  id: string;
  departmentName: string;
  formPosition: FormGroup;
  loading: boolean = true;
  perPage: number = 10;
  page: number = 1;
  pages: number;
  total: number;
  options: Number[] = [5, 10, 25, 50, 100];
  search: string = '';
  private searchSubject: Subject<string> = new Subject();
  private destroy$ = new Subject<void>();
  constructor(
    private departmentService: DepartmentService,
    private positionService: PositionService,
    private formBuilder: FormBuilder,
    private router: ActivatedRoute
  ) { }

  ngOnInit(): void {
    this.form = this.formBuilder.group({
      name: ['']
    })
    this.formPosition = this.formBuilder.group({
      department_id: [''],
      name: ['']
    });
    this.router.params.subscribe(params => {
      if (params['id']) {
        this.departmentService.showById(params['id'])
          .pipe(take(1))
          .subscribe(response => {
            this.id = params['id'];
            this.form.patchValue(response);
          })
      }
    });
    this.show();
    this.searchSubject.pipe(
      debounceTime(3000),
      switchMap(search => this.departmentService.show(this.perPage, this.page, search)),
      tap(response => {
        this.departments = response.itens;
        this.pages = response.pages;
        this.total = response.total;
        this.title = `Departamentos (${this.total})`;
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

  show() {
    this.departmentService.show(this.perPage, this.page, this.search).subscribe(response => {
      this.departments = response.itens;
      this.pages = response.pages;
      this.total = response.total;
      this.title = `Departamentos (${this.total})`;
      if (this.page > this.pages) this.page = 1;
      this.loading = false;
    });
  }

  filter() {
    this.searchSubject.next(this.search);
  }

  store() {
    this.departmentService.store(this.form.getRawValue() as Department)
    .pipe(tap(response => {
      this.form.reset();
      this.show();
      alert(response.message);
    }))
    .subscribe();
  }

  update(id: string) {
    this.departmentService.update(this.form.getRawValue() as Department, id)
    .pipe(tap(response => {
      this.show();
      alert(response.message);
    })).subscribe();
  }

  delete(department: Department) {
    if(confirm('Tem certeza que deseja excluir esse item?')){
      this.departmentService.delete(department.id)
      .pipe(
        tap(response => {
          this.show();
          alert(response.message);
        })
      ).subscribe();
    }
  }

  openModal(department: Department){
      this.departmentName = department.name;
      this.formPosition.patchValue({
        department_id: department.id
      });
  }

  storePosition() {
    this.positionService.store(this.formPosition.getRawValue() as Position)
    .pipe(
      tap(() => {
        this.formPosition.get('name')?.setValue('');
        this.show()
      })
    ).subscribe()
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

  //Pegando a quantidade de páginas que vem do backend e transformando em um array iniciando em 1 e finalizando na quantidade informada pelo backend
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
