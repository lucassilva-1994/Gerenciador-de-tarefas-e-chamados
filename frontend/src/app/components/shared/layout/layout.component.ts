
import { Component, inject, Input } from '@angular/core';
import { RouterLink } from '@angular/router';
import { User } from '../../../models/User';
import { UserService } from '../../../services/user.service';

@Component({
  selector: 'app-layout',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './layout.component.html',
  styleUrl: './layout.component.css'
})
export class LayoutComponent {  
  user: User | null = null;
  @Input() title: string;
  private userService = inject(UserService);
  constructor(){
    this.user = this.userService.getUser()();
  }
  signOut(){
    this.userService.signOut();
  }
}
