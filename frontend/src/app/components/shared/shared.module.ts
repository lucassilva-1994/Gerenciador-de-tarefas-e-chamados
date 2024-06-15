import { NgModule } from "@angular/core";
import { LayoutComponent } from "./layout/layout.component";
import { CommonModule } from "@angular/common";
import { RouterLink } from "@angular/router";
import { TableComponent } from './table/table.component';
import { SpinnerComponent } from './spinner/spinner.component';
import { SearchAndSelectQuantityComponent } from './search-and-select-quantity/search-and-select-quantity.component';
import { MessageComponent } from "./message/message.component";
import { MessagesValidatorsComponent } from './messages-validators/messages-validators.component';

@NgModule({
    declarations: [
        LayoutComponent,
        TableComponent,
        SpinnerComponent,
        SearchAndSelectQuantityComponent,
        MessageComponent,
        MessagesValidatorsComponent
    ], 
    imports: [
        CommonModule,
        RouterLink
    ],
    exports: [
        LayoutComponent,
        TableComponent,
        SpinnerComponent,
        SearchAndSelectQuantityComponent,
        MessageComponent,
        MessagesValidatorsComponent
    ]
})
export class SharedModule{}