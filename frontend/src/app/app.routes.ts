import { Routes } from '@angular/router';
import { ForbiddenComponent } from './components/forbidden/forbidden.component';
import { NotFoundComponent } from './components/not-found/not-found.component';
import { ChangePasswordComponent } from './components/change-password/change-password.component';

export const APP_ROUTES: Routes = [
    { path: '', loadChildren: () => import('./components/auth/auth.routes').then(r => r.AUTH_ROUTES)},
    { path: 'tasks', loadChildren: () => import('./components/tasks/tasks.routes').then(r => r.TASK_ROUTES)},
    { path: 'projects', loadChildren: () => import('./components/projects/projects.routes').then(r => r.PROJECT_ROUTES)},
    { path: 'departments', loadChildren: () => import('./components/departments/departments.routes').then(r => r.DEPARTMENT_ROUTES)},
    { path: 'users', loadChildren: () => import('./components/users/users.routes').then(r => r.USER_ROUTES)},
    { path: 'forbidden', loadComponent:() => ForbiddenComponent, title: 'Acesso negado'},
    { path: 'not-found', loadComponent:() => NotFoundComponent, title: 'Página não encontrada'},
    { path: 'change-password', loadComponent:() => ChangePasswordComponent, title: 'Alterar senha'}
];
