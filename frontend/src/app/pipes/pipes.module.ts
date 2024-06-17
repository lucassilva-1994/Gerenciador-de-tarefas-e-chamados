import { NgModule } from "@angular/core";
import { GenericPipe } from "./generic-pipe.pipe";

@NgModule({
    declarations: [
        GenericPipe
    ],
    exports: [
        GenericPipe
    ]
})
export class PipesModule{}