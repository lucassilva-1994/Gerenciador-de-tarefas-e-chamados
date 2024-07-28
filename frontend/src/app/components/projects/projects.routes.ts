import { Routes } from "@angular/router";
import { ProjectsComponent } from "./projects.component";

export const PROJECT_ROUTES: Routes = [
    {
        path: '',
        component: ProjectsComponent,
        title: 'Projetos',
        data: {
            mode: 'view'
        }
    },
    {
        path:'new',
        component: ProjectsComponent,
        title: 'Novo projeto',
        data: {
            mode: 'new'
        }
    },
    {
        path:'edit/:id',
        component: ProjectsComponent,
        title: 'Editar projeto',
        data: {
            mode:'edit'
        }
    }
];