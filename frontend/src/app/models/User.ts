import { Department } from "./Department";
import { Model } from "./Model";

export class User extends Model{
    username: string;
    email: string;
    photo: string;
    visibility: string | undefined;
    department: Department;
    password_expires_at: Date
}