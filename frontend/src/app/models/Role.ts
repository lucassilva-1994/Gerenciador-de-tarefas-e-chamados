import { Employee } from "./Employee";
import { Model } from "./Model";
import { Permission } from "./Permission";

export class Role extends Model{
    permissions: Permission[];
    employees: Employee[];
}