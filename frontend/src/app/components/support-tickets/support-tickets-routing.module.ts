import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { SupportTicketsComponent } from './support-tickets.component';
import { ProjectResolver } from 'src/app/resolvers/projects.resolver';
import { EmployeeResolver } from 'src/app/resolvers/employees.resolver';

const routes: Routes = [
  {
    path: '',
    component: SupportTicketsComponent,
    title: 'Chamados',
    //Carregando os dados antes da rota ser ativada!!!
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
export class SupportTicketsRoutingModule { }
