import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Permission } from 'src/app/models/Permission';
import { Role } from 'src/app/models/Role';
import { RoleService } from 'src/app/services/role.service';
import { PermissionRoleService } from './../../services/permission_role.service';
import { take, tap } from 'rxjs';
import { PermissionService } from 'src/app/services/permission.service';
import { Employee } from 'src/app/models/Employee';
import { ActivatedRoute } from '@angular/router';

@Component({
  templateUrl: './roles.component.html',
  styleUrls: ['./roles.component.css']
})
export class RolesComponent implements OnInit {
  roles: Role[] = [];
  title: string = 'Grupo de usuários/Papeis';
  form: FormGroup;
  permissions: Permission[] = [];
  permissionsRoles: Permission[] = [];
  employees: Employee[] = [];
  roleName: string;
  roleId: string;
  id: string;
  constructor(private roleService: RoleService,
    private permissionService: PermissionService,
    private permissionRoleService: PermissionRoleService,
    private formBuilder: FormBuilder,
  private router: ActivatedRoute) { }
  ngOnInit(): void {
    this.form = this.formBuilder.group({
      name: ['', [Validators.required, Validators.minLength(10), Validators.maxLength(40)]],
      description: ['', [Validators.minLength(3), Validators.maxLength(100)]]
    })
    this.router.params.subscribe(params => {
      if (params['id']) {
        this.roleService.showById(params['id'])
          .pipe(take(1))
          .subscribe(response => {
            this.id = params['id'];
            this.form.patchValue(response);
          })
      }
    });
    this.show();
    this.showPermissions();
  }

  show() {
    this.roleService.show()
      .pipe(tap(response => {
        this.roles = response.itens
      }))
      .subscribe();
  }

  store(){
    this.roleService.store(this.form.getRawValue() as Role)
    .pipe(tap((response => {
      alert(response.message);
      this.show();
      this.form.reset();
    })))
    .subscribe();
  }

  update(id: string){
    this.roleService.update(this.form.getRawValue() as Role, id)
    .pipe(tap(response => {
      alert(response.message);
      this.show();
    })).subscribe();
  }

  delete(role: Role){
    if(confirm('Tem certeza que deseja excluir esse item?')){
      this.roleService.delete(role.id)
      .pipe(tap( response => {
        alert(response.message);
        this.show();
      }))
      .subscribe();
    }
  }

  showPermissions() {
    this.permissionService.show(100)
      .pipe(tap(response => {
        this.permissions = response.itens
      })).subscribe();
  }

  openModalPermissions(role: Role) {
    this.roleName = role.name;
    this.permissionsRoles = role.permissions;
    this.roleId = role.id;
    this.permissions.forEach(permission => {
      permission.checked = this.permissionsRoles.some(permissionRole => permissionRole.id === permission.id);
    });
  }

  openModalEmployees(role: Role){
    this.roleName = role.name;
    this.employees = role.employees;
    console.log(this.employees);
  }


  deletePermissions(roleId: string, permissionId: string) {
    this.permissionRoleService.delete(roleId, permissionId)
      .pipe(tap(() => this.show()))
      .subscribe();
  }

  storePermissions(roleId: string, permissionId: string) {
    this.permissionRoleService.store(roleId, permissionId)
      .pipe(tap(() => this.show()))
      .subscribe();
  }

  onCheckboxChange(event: Event, roleId: string, permissionId: string): void {
    const isChecked = (event.target as HTMLInputElement).checked;
    if (isChecked) {
      this.storePermissions(roleId, permissionId);
    } else {
      this.deletePermissions(roleId, permissionId);
    }
  }
}
