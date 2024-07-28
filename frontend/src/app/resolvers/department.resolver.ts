import { Resolve } from "@angular/router";
import { Department } from "../models/Department";
import { inject, Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { DepartmentService } from "../services/department.service";

@Injectable({ providedIn: 'root' })
export class DepartmentResolver implements Resolve<Department[]> {
  private departmentService = inject(DepartmentService);
  resolve(): Observable<Department[]> {
    return this.departmentService.showWithoutPagination(['id', 'name']);
  }
}