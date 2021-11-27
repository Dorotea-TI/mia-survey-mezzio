<?php

namespace Mia\Survey\Handler;

use \Illuminate\Database\Capsule\Manager as DB;
use Mia\Survey\Handler\Question\RemoveHandler;
use Mia\Survey\Handler\Question\SaveHandler as QuestionSaveHandler;
use Mia\Survey\Model\MiaSurvey;

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
        $item->photo = $this->getParam($request, 'photo', null);
        $item->token = md5(time() . $item->title);
        //$item->completed = intval($this->getParam($request, 'completed', ''));        
        
        try {
            // Init Transactions
            DB::beginTransaction();
            // Save Survey
            $item->save();
            // Process Questions
            $this->processQuestions($request, $item);
            // Commit transactions
            DB::commit();
        } catch (\Exception $exc) {
            // Cancel transaction
            DB::rollBack();
            // Return Error
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse(-2, $exc->getMessage());
        }

        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($item->toArray());
    }

    protected function processQuestions(\Psr\Http\Message\ServerRequestInterface $request, MiaSurvey $survey)
    {
        $questions = $this->getParam($request, 'questions', []);
        foreach($questions as $question){
            if(array_key_exists('deleted', $question) && $question['deleted'] == 1){
                $handler = new RemoveHandler();
            } else {
                $handler = new QuestionSaveHandler();
            }
            $handler->handle($request->withParsedBody($question));
        }
    }
    
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Mia\Survey\Model\MiaSurvey
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