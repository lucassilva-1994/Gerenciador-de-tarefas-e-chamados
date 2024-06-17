import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TasksComponent } from './tasks.component';
import { ProjectResolver } from 'src/app/resolvers/projects.resolver';
import { EmployeeResolver } from 'src/app/resolvers/employees.resolver';

const routes: Routes = [
  { 
    path: '', 
    component: TasksComponent,
    title: 'Tarefas',
    resolve: {
      projects: ProjectResolver,
      employees: EmployeeResolver
    }
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TasksRoutingModule { }
