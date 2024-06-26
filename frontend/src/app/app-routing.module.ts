import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  { path: '', loadChildren: () => import('./components/sign-in/sign-in.module').then(m => m.SignInModule) }, 
  { path: 'projects', loadChildren: () => import('./components/projects/projects.module').then(m => m.ProjectsModule) }, 
  { path: 'departments', loadChildren: () => import('./components/departments/departments.module').then(m => m.DepartmentsModule) }, 
  { path: 'positions', loadChildren: () => import('./components/positions/positions.module').then(m => m.PositionsModule) }, 
  { path: 'employees', loadChildren: () => import('./components/employees/employees.module').then(m => m.EmployeesModule) },
  { path: 'access-denied', loadChildren: () => import('./components/access-denied/access-denied.module').then(m => m.AccessDeniedModule) },
  { path: 'roles', loadChildren: () => import('./components/roles/roles.module').then(m => m.RolesModule) },
  { path: 'not-found', loadChildren: () => import('./components/not-found/not-found.module').then(m => m.NotFoundModule) },
  { path: 'support-tickets', loadChildren: () => import('./components/support-tickets/support-tickets.module').then(m => m.SupportTicketsModule) },
  { path: 'tasks', loadChildren: () => import('./components/tasks/tasks.module').then(m => m.TasksModule) }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
