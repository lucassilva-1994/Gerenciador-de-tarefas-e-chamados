import { ActivatedRouteSnapshot, Resolve, RouterStateSnapshot } from '@angular/router';
import { Employee } from '../models/Employee';
import { EmployeeService } from '../services/employee.service';
import { Observable } from 'rxjs';
import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root'})
export class EmployeeResolver implements Resolve<Employee[]>{
    constructor(private employeeService: EmployeeService){ }

    resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot):  Observable<Employee[]>  {
        return this.employeeService.showWithoutPagination('id,name');
    }
}

