<?php

namespace Mia\Survey\Handler\Invitation;

use Mia\Core\Exception\MiaException;
use Mia\Survey\Model\MiaSurveyInvitation;

/**
 * Description of ListHandler
 *
 * @author matiascamiletti
 */
class FetchByTokenHandler extends \Mia\Auth\Request\MiaAuthRequestHandler
{
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface 
    {
        // Obtenemos ID si fue enviado
        $surveyId = $this->getParam($request, 'survey_id', '');
        $token = $this->getParam($request, 'token', '');
        // Search Survey
        $item = \Mia\Survey\Model\MiaSurvey::find($surveyId);
        // verificar si existe
        if($item === null){
            throw new MiaException('Not exist');
        }
        // Search link public
        $inv = MiaSurveyInvitation::where('survey_id', $surveyId)->where('token', $token)->first();
        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($inv->toArray());
    }
}