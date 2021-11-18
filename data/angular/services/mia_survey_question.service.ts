import { Injectable } from '@angular/core';
import { MiaSurveyQuestion } from '../entities/mia_survey_question';
import { MiaBaseCrudHttpService } from '@agencycoda/mia-core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class MiaSurveyQuestionService extends MiaBaseCrudHttpService<MiaSurveyQuestion> {

  constructor(
    protected http: HttpClient
  ) {
    super(http);
    this.basePathUrl = environment.baseUrl + 'mia_survey_question';
  }
 
}