import { Injectable } from '@angular/core';
import { MiaSurveyInvitation } from '../entities/mia_survey_invitation';
import { MiaBaseCrudHttpService } from '@agencycoda/mia-core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class MiaSurveyInvitationService extends MiaBaseCrudHttpService<MiaSurveyInvitation> {

  constructor(
    protected http: HttpClient
  ) {
    super(http);
    this.basePathUrl = environment.baseUrl + 'mia_survey_invitation';
  }
 
}