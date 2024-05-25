import { Department } from "./Department";
import { Employee } from "./Employee";
import { Model } from "./Model";
import { User } from "./User";

export class Position extends Model{
    department: Department;
    created_by: User;
    modified_by: User;
    employees: Employee[]
}