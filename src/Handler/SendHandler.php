<?php

namespace Mia\Survey\Handler;

use Mia\Core\Exception\MiaException;
use Mia\Survey\Model\MiaSurvey;
use Mia\Survey\Model\MiaSurveyInvitation;

/**
 * Description of SaveHandler
 * 
 * @OA\Post(
 *     path="/mia_survey_done/save",
 *     summary="MiaSurveyDone Save",
 *     tags={"MiaSurveyDone"},
*      @OA\RequestBody(
 *         description="Object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/MiaSurveyDone")
 *         )
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/MiaSurveyDone")
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     },
 * )
 *
 * @author matiascamiletti
 */
class SendHandler extends \Mia\Auth\Request\MiaAuthRequestHandler
{
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface 
    {
        // Get Survey ID
        $surveyId = $this->getParam($request, 'survey_id', '');
        // Search Survey in DB
        $survey = \Mia\Survey\Model\MiaSurvey::find($surveyId);
        // Verify if exist
        if($survey === null){
            throw new MiaException('Not exist');
        }
        // Verify status survey
        if($survey->status != MiaSurvey::STATUS_ACTIVE){
            throw new MiaException('Not has permission');
        }
        // Process Invitations
        $this->processInvitations(
            $survey, 
            $this->getParam($request, 'invitations', []),
            $this->getParam($request, 'caption', ''));
        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse(true);
    }

    protected function processInvitations(MiaSurvey $survey, $invitations, $caption)
    {
        foreach($invitations as $inv){
            $item = new MiaSurveyInvitation();
            $item->survey_id = $survey->id;
            if(array_key_exists('user_id', $inv) && $inv['user_id'] > 0){
                $item->user_id = $inv['user_id'];
            }
            if(array_key_exists('email', $inv) && $inv['email'] != ''){
                $item->email = $inv['email'];
            }
            $item->caption = $caption;
            $item->token = md5($item->user_id . $item->email . time());
            $item->save();
        }
    }
}