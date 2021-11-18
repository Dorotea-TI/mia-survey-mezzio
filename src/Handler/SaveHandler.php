<?php

namespace Mia\Survey\Handler;

/**
 * Description of SaveHandler
 * 
 * @OA\Post(
 *     path="/mia_survey/save",
 *     summary="MiaSurvey Save",
 *     tags={"MiaSurvey"},
*      @OA\RequestBody(
 *         description="Object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/MiaSurvey")
 *         )
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/MiaSurvey")
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
        $item->title = $this->getParam($request, 'title', '');
        $item->caption = $this->getParam($request, 'caption', '');
        $item->type = intval($this->getParam($request, 'type', '0'));
        $item->photo = $this->getParam($request, 'photo', '');
        //$item->completed = intval($this->getParam($request, 'completed', ''));        
        
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
     * @return \App\Model\MiaSurvey
     */
    protected function getForEdit(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $user = $this->getUser($request);
        // Obtenemos ID si fue enviado
        $itemId = $this->getParam($request, 'id', '');
        // Buscar si existe el item en la DB
        $item = \Mia\Survey\Model\MiaSurvey::find($itemId);
        // verificar si existe
        if($item === null){
            return new \Mia\Survey\Model\MiaSurvey([
                'creator_id' => $user->id
            ]);
        }
        // Devolvemos item para editar
        return $item;
    }
}