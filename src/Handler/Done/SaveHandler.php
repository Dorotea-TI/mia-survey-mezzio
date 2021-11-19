<?php

namespace Mia\Survey\Handler\Done;

use Mia\Core\Exception\MiaException;
use Mia\Survey\Model\MiaSurvey;

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
class SaveHandler extends \Mia\Auth\Request\MiaAuthRequestHandler
{
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface 
    {
        // Get Current User
        $user = $this->getUser($request);
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
        // Obtener item a procesar
        $item = new \Mia\Survey\Model\MiaSurveyDone();
        $item->survey_id = $survey->id;

        if($user !== null){
            $item->user_id = $user->id;
        }

        $item->email = $this->getParam($request, 'email', '');
        $item->data = $this->getParam($request, 'data', []);
        $item->duration = intval($this->getParam($request, 'duration', '0'));
                
        try {
            $item->save();
        } catch (\Exception $exc) {
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse(-2, $exc->getMessage());
        }

        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($item->toArray());
    }
}