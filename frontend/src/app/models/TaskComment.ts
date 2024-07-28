import { Model } from "./Model";
import { User } from "./User";

export class TaskComment extends Model{
    comment: string;
    source: string;
    user: User;
}