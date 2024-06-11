import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SupportTicketsRoutingModule } from './support-tickets-routing.module';
import { SupportTicketsComponent } from './support-tickets.component';
import { SharedModule } from '../shared/shared.module';
import { ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    SupportTicketsComponent
  ],
  imports: [
    CommonModule,
    SupportTicketsRoutingModule,
    SharedModule,
    ReactiveFormsModule
  ]
})
export class SupportTicketsModule { }
