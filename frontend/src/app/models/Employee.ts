import { Department } from "./Department";
import { Model } from "./Model";
import { Position } from "./Position";
import { User } from "./User";

export class Employee extends Model{
    email: string;
    position: Position;
    department: Department;
    has_user: User
}