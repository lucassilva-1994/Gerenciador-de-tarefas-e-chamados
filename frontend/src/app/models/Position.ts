import { Department } from "./Department";
import { Model } from "./Model";
import { User } from "./User";

export class Position extends Model{
    department: Department;
    created_by: User;
    modified_by: User;
}