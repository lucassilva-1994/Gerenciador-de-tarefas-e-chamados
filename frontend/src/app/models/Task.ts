import { Model } from "./Model";

export class Task extends Model{
    title: string;
    comments_count:number;
    is_done: number;
    owner_id: string
}