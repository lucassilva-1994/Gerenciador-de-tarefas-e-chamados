import { Model } from "./Model";
import { Project } from "./Project";

export class Task extends Model{
    title: string;
    project: Project;
    status: 'OPEN' | 'IN_PROGRESS' | 'COMPLETED'
}