import { Component, OnInit } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Role } from 'src/app/models/Role';
import { RoleService } from 'src/app/services/role.service';

@Component({
  selector: 'app-roles',
  templateUrl: './roles.component.html',
  styleUrls: ['./roles.component.css']
})
export class RolesComponent implements OnInit{
  roles: Role[] = [];
  title: string = 'Grupo de usuários/Papeis';
  form: FormGroup;
  constructor(private roleService: RoleService){

  }
  ngOnInit(): void {  
      this.roleService.show().subscribe( roles => {
        this.roles = roles.itens
      });
  }
}
