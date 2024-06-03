import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { RolesComponent } from './roles.component';

const routes: Routes = [
  { 
    path: '', 
    component: RolesComponent, 
    title: 'Grupo de usuários/Papéis'
  },
  { 
    path: ':id', 
    component: RolesComponent, 
    title: 'Editar papel'
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class RolesRoutingModule { }
