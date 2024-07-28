import { Routes } from '@angular/router';
import { TasksComponent } from './tasks.component';
import { UserResolver } from '../../resolvers/user.resolver';
import { ProjectResolver } from '../../resolvers/project.resolver';

export const TASK_ROUTES: Routes = [
    {
        path: '',
        component: TasksComponent,
        title: 'Tarefas',
        data: {
            mode: 'view'
        }
    },
    {
        path:'new',
        component: TasksComponent,
        title: 'Nova tarefa',
        data: {
            mode: 'new'
        },
        resolve: {
            users: UserResolver,
            projects: ProjectResolver
        }
    },
    {
        path:'edit/:id',
        component: TasksComponent,
        title: 'Editar tarefa',
        data: {
            mode:'edit'
        },
        resolve: {
            users: UserResolver,
            projects: ProjectResolver
        }
    }
]

