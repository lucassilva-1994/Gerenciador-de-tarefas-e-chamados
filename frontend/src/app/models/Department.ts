import { Model } from "./Model";
import { User } from "./User";

export class Department extends Model{
    created_by: User;
    modified_by: User;
}