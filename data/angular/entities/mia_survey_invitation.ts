import { MiaModel } from "@agencycoda/mia-core";

export class MiaSurveyInvitation extends MiaModel {
    id: number = 0;
    survey_id: number = 0;
    user_id: number = 0;
    email: string = '';
    caption: string = '';
    created_at: string = '';
    updated_at: string = '';
    deleted: number = 0;
    token: string = '';

}