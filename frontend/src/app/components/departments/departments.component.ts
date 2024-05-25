import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { Department } from 'src/app/models/Department';
import { DepartmentService } from 'src/app/services/department.service';
import { map, switchMap, take, tap } from 'rxjs/operators';
import { FormBuilder, FormGroup } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-departments',
  templateUrl: './departments.component.html',
  styleUrls: ['./departments.component.css']
})
export class DepartmentsComponent implements OnInit{
  departments$: Observable<Department[]>;
  form: FormGroup;
  title: string = 'Departamentos';
  id: string;
  constructor(
    private departmentService: DepartmentService, 
    private formBuilder: FormBuilder,
    private router: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.form = this.formBuilder.group({
      name:['']
    })
    this.router.params.subscribe( params => {
      if(params['id']){
        this.departmentService.showById(params['id'])
          .pipe(take(1))
          .subscribe(response => {
            console.log(response);
            this.id = params['id'];
            this.form.patchValue(response);
          })
      }
    });
    this.show();  
  }

  show(): void {
    this.departments$ = this.departmentService.show();
  }

  store(){
    this.departments$ = this.departmentService.store(this.form.getRawValue() as Department)
      .pipe(switchMap(() => this.departmentService.show()))
      .pipe(tap(() => this.form.reset()));
  }

  update(id: string){
    this.departments$ = this.departmentService.update(this.form.getRawValue() as Department, id)
    .pipe(switchMap(() => this.departmentService.show()));
  }

  delete(department: Department){
    if(confirm('Tem certeza que deseja excluir esse registro?')){
      this.departments$ = this.departmentService.delete(department.id)
      .pipe(switchMap(() => this.departmentService.show()));
    }
  }

  getTotalEmployees(department: Department): number {
    return department.positions.reduce((total, position) => total + position.employees.length, 0);
  }
}
