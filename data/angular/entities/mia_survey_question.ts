import { MiaModel } from "@agencycoda/mia-core";

export class MiaSurveyQuestion extends MiaModel {
    id: number = 0;
    survey_id: number = 0;
    title: string = '';
    caption: string = '';
    type: number = 0;
    val: string = '';
    data: string = '';
    ord: number = 0;

}