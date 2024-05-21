import { NgModule } from "@angular/core";
import { LayoutComponent } from "./layout/layout.component";
import { CommonModule } from "@angular/common";
import { RouterLink } from "@angular/router";

@NgModule({
    declarations: [
        LayoutComponent
    ], 
    imports: [
        CommonModule,
        RouterLink
    ],
    exports: [
        LayoutComponent
    ]
})
export class SharedModule{}