<?php

namespace Mia\Survey\Handler\Invitation;

use Mia\Core\Exception\MiaException;
use Mia\Survey\Model\MiaSurveyInvitation;

/**
 * Description of ListHandler
 *
 * @author matiascamiletti
 */
class PublicLinkHandler extends \Mia\Auth\Request\MiaAuthRequestHandler
{
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface 
    {
        // Obtenemos ID si fue enviado
        $itemId = $this->getParam($request, 'id', '');
        // Search Survey
        $item = \Mia\Survey\Model\MiaSurvey::find($itemId);
        // verificar si existe
        if($item === null){
            throw new MiaException('Not exist');
        }
        // Search link public
        $inv = MiaSurveyInvitation::where('survey_id', $itemId)->where('type', MiaSurveyInvitation::TYPE_MULTIPLE)->first();
        if($inv === null){
            $inv = new MiaSurveyInvitation();
            $inv->survey_id = $itemId;
            $inv->type = MiaSurveyInvitation::TYPE_MULTIPLE;
            $inv->token = md5($itemId . time() . $itemId);
            $inv->save();
        }
        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($inv->toArray());
    }
}