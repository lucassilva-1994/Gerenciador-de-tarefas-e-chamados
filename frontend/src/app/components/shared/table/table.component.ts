import { Component, EventEmitter, Input, Output } from '@angular/core';

@Component({
  selector: 'app-table',
  templateUrl: './table.component.html',
  styleUrls: ['./table.component.css']
})
export class TableComponent{
  @Input() cols: { key: string, label: string, icon?: string}[] = [];
  @Input() itens: any[] = [];
  @Input() path: string;
  @Output() deleteEvent = new EventEmitter<{id: string}>();

  delete(id: string){
    if(confirm('Tem certeza que deseja excluir esse item?')){
      this.deleteEvent.emit({id});
    }
  }
}
