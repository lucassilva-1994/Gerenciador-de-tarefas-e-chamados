import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PositionsRoutingModule } from './positions-routing.module';
import { PositionsComponent } from './positions.component';


@NgModule({
  declarations: [
    PositionsComponent
  ],
  imports: [
    CommonModule,
    PositionsRoutingModule
  ]
})
export class PositionsModule { }
