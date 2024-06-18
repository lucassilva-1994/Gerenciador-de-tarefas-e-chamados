import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-table',
  templateUrl: './table.component.html',
  styleUrls: ['./table.component.css']
})
export class TableComponent{
  @Input() cols: { key: string, label: string, icon?: string}[] = [];
  @Input() itens: any[] = [];
}
