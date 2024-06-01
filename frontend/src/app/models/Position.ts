import { Department } from "./Department";
import { Employee } from "./Employee";
import { Model } from "./Model";

export class Position extends Model{
    department: Department;
    employees: Employee[]
}