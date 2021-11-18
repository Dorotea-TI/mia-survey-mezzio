<?php

namespace Mia\Survey\Handler;

/**
 * Description of FetchHandler
 * 
 * @OA\Get(
 *     path="/mia_survey/fetch/{id}",
 *     summary="MiaSurvey Fetch",
 *     tags={"MiaSurvey"},
 *     @OA\Parameter(
 *         name="id",
 *         description="Id of Item",
 *         required=true,
 *         in="path"
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/MiaSurvey")
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 *
 * @author matiascamiletti
 */
class FetchHandler extends \Mia\Auth\Request\MiaAuthRequestHandler
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
        // Verify has withs in query
        $withs = $this->getParam($request, 'withs', '');
        if($withs != ''){
            // Convert to array
            $with = explode(',', $withs);
            // Search item in DB
            $item = \Mia\Survey\Model\MiaSurvey::with($with)->where('id', $itemId)->first();
        } else {
            // Buscar si existe el tour en la DB
            $item = \Mia\Survey\Model\MiaSurvey::find($itemId);
        }
        // verificar si existe
        if($item === null){
            throw new MiaException('Not exist');
        }
        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($item->toArray());
    }
}