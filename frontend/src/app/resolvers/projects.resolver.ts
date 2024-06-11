import { ActivatedRouteSnapshot, Resolve, RouterStateSnapshot } from "@angular/router";
import { Injectable } from "@angular/core";
import { Observable, EMPTY } from "rxjs";
import { map } from "rxjs/operators";
import { Project } from "../models/Project";
import { ProjectService } from "../services/project.service";

@Injectable({
  providedIn: 'root'
})
export class ProjectResolver implements Resolve<Project[]> {
  constructor(private projectService: ProjectService) {}

  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<Project[]> {
    return this.projectService.show(100).pipe(
      map(response => response.itens)
    );
  }
}
