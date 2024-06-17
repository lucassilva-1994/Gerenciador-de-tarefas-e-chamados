import { Employee } from "./Employee";

export class Model {
    id: string;
    name: string;
    sequence: number;
    created_by: Employee;
    modified_by: Employee;
    owner: Employee;
    description: string;
    created_at: Date;
    updated_at: Date;
}