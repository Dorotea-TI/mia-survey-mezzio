import { MiaModel } from "@agencycoda/mia-core";

export class MiaSurveyDone extends MiaModel {
    id: number = 0;
    survey_id: number = 0;
    user_id: number = 0;
    email: string = '';
    data: string = '';
    duration: number = 0;
    created_at: string = '';
    updated_at: string = '';
    deleted: number = 0;

}