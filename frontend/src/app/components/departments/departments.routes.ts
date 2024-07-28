import { Routes } from "@angular/router";
import { DepartmentsComponent } from "./departments.component";

export const DEPARTMENT_ROUTES: Routes = [
    {
        path: '',
        component: DepartmentsComponent,
        title: 'Departamentos',
        data: {
            mode: 'view'
        }
    },
    {
        path:'new',
        component: DepartmentsComponent,
        title: 'Novo departamento',
        data: {
            mode: 'new'
        }
    },
    {
        path:'edit/:id',
        component: DepartmentsComponent,
        title: 'Editar departamento',
        data: {
            mode:'edit'
        }
    }
];