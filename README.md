# mia-survey-mezzio

1. Incluir librerias:

2. Incluir rutas:
```php
$app->route('/mia-survey/fetch/{id}', [\Mia\Auth\Handler\AuthHandler::class, Mia\Survey\Handler\FetchHandler::class], ['GET', 'OPTIONS', 'HEAD'], 'mia_survey.fetch');
$app->route('/mia-survey/list', [\Mia\Auth\Handler\AuthHandler::class, Mia\Survey\Handler\ListHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_survey.list');
$app->route('/mia-survey/remove/{id}', [\Mia\Auth\Handler\AuthHandler::class, Mia\Survey\Handler\RemoveHandler::class], ['GET', 'DELETE', 'OPTIONS', 'HEAD'], 'mia_survey.remove');
$app->route('/mia-survey/save', [\Mia\Auth\Handler\AuthHandler::class, Mia\Survey\Handler\SaveHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_survey.save');
$app->route('/mia-survey/send-invitations', [\Mia\Auth\Handler\AuthHandler::class, Mia\Survey\Handler\SendHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_survey.send-invitations');
$app->route('/mia-survey/fetch-public-link/{id}', [\Mia\Auth\Handler\AuthHandler::class, Mia\Survey\Handler\Invitation\PublicLinkHandler::class], ['GET', 'OPTIONS', 'HEAD'], 'mia_survey.fetch-public-link');
$app->route('/mia-survey/fetch-by-token/{survey_id}/{token}', [\Mia\Auth\Handler\AuthHandler::class, Mia\Survey\Handler\Invitation\FetchByTokenHandler::class], ['GET', 'OPTIONS', 'HEAD'], 'mia_survey.fetch-by-token');
//$app->route('/mia_survey_done/fetch/{id}', [\Mia\Auth\Handler\AuthHandler::class, App\Handler\MiaSurveyDone\FetchHandler::class], ['GET', 'OPTIONS', 'HEAD'], 'mia_survey_done.fetch');
$app->route('/mia-survey/done/list', [\Mia\Auth\Handler\AuthOptionalHandler::class, Mia\Survey\Handler\Done\ListHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_survey_done.list');
//$app->route('/mia_survey_done/remove/{id}', [\Mia\Auth\Handler\AuthHandler::class, App\Handler\MiaSurveyDone\RemoveHandler::class], ['GET', 'DELETE', 'OPTIONS', 'HEAD'], 'mia_survey_done.remove');
$app->route('/mia-survey/done/save', [\Mia\Auth\Handler\AuthHandler::class, Mia\Survey\Handler\Done\SaveHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_survey_done.save');
$app->route('/mia-survey/done/save-invitation', [\Mia\Auth\Handler\AuthHandler::class, Mia\Survey\Handler\Done\SaveWithInvitationHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_survey_done.save-with-invitation');
//$app->route('/mia_survey_invitation/fetch/{id}', [\Mia\Auth\Handler\AuthHandler::class, App\Handler\MiaSurveyInvitation\FetchHandler::class], ['GET', 'OPTIONS', 'HEAD'], 'mia_survey_invitation.fetch');
//$app->route('/mia_survey_invitation/list', [\Mia\Auth\Handler\AuthHandler::class, App\Handler\MiaSurveyInvitation\ListHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_survey_invitation.list');
//$app->route('/mia_survey_invitation/remove/{id}', [\Mia\Auth\Handler\AuthHandler::class, App\Handler\MiaSurveyInvitation\RemoveHandler::class], ['GET', 'DELETE', 'OPTIONS', 'HEAD'], 'mia_survey_invitation.remove');
//$app->route('/mia_survey_invitation/save', [\Mia\Auth\Handler\AuthHandler::class, App\Handler\MiaSurveyInvitation\SaveHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_survey_invitation.save');
//$app->route('/mia_survey_question/fetch/{id}', [\Mia\Auth\Handler\AuthHandler::class, App\Handler\MiaSurveyQuestion\FetchHandler::class], ['GET', 'OPTIONS', 'HEAD'], 'mia_survey_question.fetch');
//$app->route('/mia_survey_question/list', [\Mia\Auth\Handler\AuthHandler::class, App\Handler\MiaSurveyQuestion\ListHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_survey_question.list');
//$app->route('/mia_survey_question/remove/{id}', [\Mia\Auth\Handler\AuthHandler::class, App\Handler\MiaSurveyQuestion\RemoveHandler::class], ['GET', 'DELETE', 'OPTIONS', 'HEAD'], 'mia_survey_question.remove');
//$app->route('/mia_survey_question/save', [\Mia\Auth\Handler\AuthHandler::class, App\Handler\MiaSurveyQuestion\SaveHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_survey_question.save');
```