import { Routes } from '@angular/router';
import { UsersComponent } from './users.component';
import { DepartmentResolver } from '../../resolvers/department.resolver';

export const USER_ROUTES: Routes = [
    {
        path: '',
        component: UsersComponent,
        title: 'Usuários',
        data: {
            mode: 'view'
        }
    },
    {
        path:'new',
        component: UsersComponent,
        title: 'Novo usuário',
        data: {
            mode: 'new'
        },
        resolve: {
            departments: DepartmentResolver
        }
    },
    {
        path:'edit/:id',
        component: UsersComponent,
        title: 'Editar usuário',
        data: {
            mode:'edit'
        },
        resolve: {
            departments: DepartmentResolver
        }
    }
]

