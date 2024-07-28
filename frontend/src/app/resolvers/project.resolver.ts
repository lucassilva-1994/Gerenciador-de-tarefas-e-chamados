import { Resolve } from "@angular/router";
import { inject, Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { Project } from './../models/Project';
import { ProjectService } from "../services/project.service";

@Injectable({ providedIn: 'root' })
export class ProjectResolver implements Resolve<Project[]> {
  private projectService = inject(ProjectService);
  resolve(): Observable<Project[]> {
    return this.projectService.showWithoutPagination(['id', 'name']);
  }
}