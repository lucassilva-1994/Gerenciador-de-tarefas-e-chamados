import { Model } from "./Model";

export class User extends Model{
    username: string;
    email: string;
    photo: string;
    visibility: number;
    visibility_name: string;
    department: string;
    password_expires_at: Date
}