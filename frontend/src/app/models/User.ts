import { Employee } from "./Employee";
import { Model } from "./Model";

export class User extends Model{
    email: string;
    employee: Employee
}