<?php

namespace Mia\Survey\Handler\Done;

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
class SaveWithInvitationHandler extends \Mia\Auth\Request\MiaAuthRequestHandler
{
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface 
    {
        // Get Survey ID
        $token = $this->getParam($request, 'token', '');
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
        // Search Invitation
        $inv = MiaSurveyInvitation::where('survey_id', $surveyId)->where('token', $token)->first();
        // Verify if limit
        if($inv->limit <= 0){
            throw new MiaException('Already completed.');
        }

        // Obtener item a procesar
        $item = new \Mia\Survey\Model\MiaSurveyDone();
        $item->survey_id = $survey->id;
        $item->user_id = $inv->user_id;
        $item->email = $inv->email;
        $item->data = $this->getParam($request, 'data', []);
        $item->duration = intval($this->getParam($request, 'duration', '0'));
                
        try {
            $item->save();

            $inv->limit -= 1;
            $inv->save();
        } catch (\Exception $exc) {
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse(-2, $exc->getMessage());
        }

        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($item->toArray());
    }
}