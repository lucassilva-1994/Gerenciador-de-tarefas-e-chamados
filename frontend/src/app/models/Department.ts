import { Employee } from "./Employee";
import { Model } from "./Model";
import { Position } from "./Position";

export class Department extends Model{
    positions: Position[];
    employees: Employee[];
}