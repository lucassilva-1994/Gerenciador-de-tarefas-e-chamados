import { Resolve } from "@angular/router";
import { inject, Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { User } from "../models/User";
import { UserService } from "../services/user.service";

@Injectable({ providedIn: 'root' })
export class UserResolver implements Resolve<User[]> {
  private userService = inject(UserService);
  resolve(): Observable<User[]> {
    return this.userService.showWithoutPagination(['id', 'name']);
  }
}