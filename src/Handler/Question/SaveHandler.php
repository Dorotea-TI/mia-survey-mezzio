<?php

namespace Mia\Survey\Handler\Question;

/**
 * Description of SaveHandler
 * 
 * @OA\Post(
 *     path="/mia_survey_question/save",
 *     summary="MiaSurveyQuestion Save",
 *     tags={"MiaSurveyQuestion"},
*      @OA\RequestBody(
 *         description="Object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/MiaSurveyQuestion")
 *         )
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/MiaSurveyQuestion")
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
        // Obtener item a procesar
        $item = $this->getForEdit($request);
        // Guardamos data
        $item->survey_id = intval($this->getParam($request, 'survey_id', '0'));
        $item->title = $this->getParam($request, 'title', '');
        $item->caption = $this->getParam($request, 'caption', '');
        $item->type = intval($this->getParam($request, 'type', ''));
        $item->val = $this->getParam($request, 'val', []);
        $item->data = $this->getParam($request, 'data', []);
        $item->ord = intval($this->getParam($request, 'ord', '0'));        
        
        try {
            $item->save();
        } catch (\Exception $exc) {
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse(-2, $exc->getMessage());
        }

        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($item->toArray());
    }
    
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \App\Model\MiaSurveyQuestion
     */
    protected function getForEdit(\Psr\Http\Message\ServerRequestInterface $request)
    {
        // Obtenemos ID si fue enviado
        $itemId = $this->getParam($request, 'id', '');
        // Verify exist param
        if($itemId == ''){
            return new \Mia\Survey\Model\MiaSurveyQuestion();
        }
        // Buscar si existe el item en la DB
        $item = \Mia\Survey\Model\MiaSurveyQuestion::find($itemId);
        // verificar si existe
        if($item === null){
            return new \Mia\Survey\Model\MiaSurveyQuestion();
        }
        // Devolvemos item para editar
        return $item;
    }
}