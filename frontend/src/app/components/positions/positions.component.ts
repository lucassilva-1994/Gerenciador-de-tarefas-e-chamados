import { Component, OnInit } from '@angular/core';
import { pipe, tap } from 'rxjs';
import { Position } from 'src/app/models/Position';
import { PositionService } from 'src/app/services/position.service';

@Component({
  templateUrl: './positions.component.html',
  styleUrls: ['./positions.component.css']
})
export class PositionsComponent implements OnInit {
  title: string = 'Cargos';
  positions: Position[] = [];
  cols: { key: string, label: string, icon?: string }[] = [
    { key: 'name', label: 'Nome', icon: 'fas fa-id-badge' },
    { key: 'employees', label: 'Funcionários', icon: 'fas fa-user-friends' },
    { key: 'department', label: 'Departamento', icon: 'fas fa-building' },
    { key: 'created_by', label: 'Criado por', icon: 'fas fa-user-plus' },
    { key: 'modified_by', label: 'Alterado por', icon: 'fas fa-user-edit' },
  ];
  constructor(private positionService: PositionService) {
  }
  ngOnInit(): void {
    this.show();
  }

  show() {
    this.positionService.show()
      .subscribe(response => {
        this.positions = response.itens
        console.log(this.positions)
      })
  }

  delete(event: { id: string }){
    this.positionService.delete(event.id).pipe(tap(() => this.show())).subscribe();
  }
}
