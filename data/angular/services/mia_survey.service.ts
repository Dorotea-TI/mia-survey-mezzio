import { Injectable } from '@angular/core';
import { MiaSurvey } from '../entities/mia_survey';
import { MiaBaseCrudHttpService } from '@agencycoda/mia-core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class MiaSurveyService extends MiaBaseCrudHttpService<MiaSurvey> {

  constructor(
    protected http: HttpClient
  ) {
    super(http);
    this.basePathUrl = environment.baseUrl + 'mia_survey';
  }
 
}