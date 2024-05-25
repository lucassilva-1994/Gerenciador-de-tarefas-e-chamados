import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { DepartmentsComponent } from './departments.component';

const routes: Routes = [
  { 
    path: '', 
    component: DepartmentsComponent,
    title: 'Departamentos'
  },
  {
    path: ':id',
    component: DepartmentsComponent,
    title: 'Editar departamento'
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class DepartmentsRoutingModule { }
