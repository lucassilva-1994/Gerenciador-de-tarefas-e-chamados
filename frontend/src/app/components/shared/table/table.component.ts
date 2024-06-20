import { Component, EventEmitter, Input, Output } from '@angular/core';
import { GenericPipe } from './../../../pipes/generic-pipe.pipe';

@Component({
  selector: 'app-table',
  templateUrl: './table.component.html',
  styleUrls: ['./table.component.css'],
  providers: [GenericPipe]
})
export class TableComponent {
  @Input() cols: { key: string, label: string, icon?: string }[] = [];
  @Input() itens: any[] = [];
  @Input() path: string = '';
  @Output() deleteEvent = new EventEmitter<{ id: string }>();

  constructor(private genericPipe: GenericPipe){

  }
  delete(id: string) {
    if (confirm('Tem certeza que deseja excluir esse item?')) {
      this.deleteEvent.emit({ id });
    }
  }

  itemValue(item: any, key: string): any {
    switch (key) {
      case 'positions':
      case 'employees':
        return item[key].length;
      case 'created_by':
      case 'modified_by':
      case 'department':
      case 'owner':
      case 'project':
        return item[key] ? item[key].name  : 'Não informado';
      case 'status':
        return this.genericPipe.transform(item[key]);
      default:
        return item[key];
    }
  }
}
