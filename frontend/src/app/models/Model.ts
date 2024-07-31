import { User } from "./User";

export class Model{
    id:string;
    sequence?: number;
    name: string;
    description?: string;
    created_by?: User;
    modified_by?:User;
    created_at?: Date 
    updated_at?: Date 
}