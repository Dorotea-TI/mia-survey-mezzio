import { MiaModel } from "@agencycoda/mia-core";

export class MiaSurvey extends MiaModel {
    id: number = 0;
    creator_id: number = 0;
    title: string = '';
    caption: string = '';
    type: number = 0;
    photo: string = '';
    completed: number = 0;
    created_at: string = '';
    updated_at: string = '';
    deleted: number = 0;

}