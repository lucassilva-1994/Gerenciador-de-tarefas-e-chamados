import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  { path: '', loadChildren: () => import('./components/sign-in/sign-in.module').then(m => m.SignInModule) }, 
  { path: 'projects', loadChildren: () => import('./components/projects/projects.module').then(m => m.ProjectsModule) }, 
  { path: 'departments', loadChildren: () => import('./components/departments/departments.module').then(m => m.DepartmentsModule) }, 
  { path: 'positions', loadChildren: () => import('./components/positions/positions.module').then(m => m.PositionsModule) }, 
  { path: 'employees', loadChildren: () => import('./components/employees/employees.module').then(m => m.EmployeesModule) }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }