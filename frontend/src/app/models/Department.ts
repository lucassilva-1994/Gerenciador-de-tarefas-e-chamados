import { Model } from "./Model";
import { Position } from "./Position";
import { User } from "./User";

export class Department extends Model{
    created_by: User;
    modified_by: User;
    positions: Position[];
}