import { NgModule } from "@angular/core";
import { LayoutComponent } from "./layout/layout.component";
import { CommonModule } from "@angular/common";
import { RouterLink } from "@angular/router";
import { TableComponent } from './table/table.component';

@NgModule({
    declarations: [
        LayoutComponent,
        TableComponent
    ], 
    imports: [
        CommonModule,
        RouterLink
    ],
    exports: [
        LayoutComponent,
        TableComponent
    ]
})
export class SharedModule{}