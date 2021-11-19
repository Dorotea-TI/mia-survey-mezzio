<?php

namespace Mia\Survey\Model;

/**
 * Description of Model
 * @property int $id ID of item
 * @property mixed $survey_id Description for variable
 * @property mixed $title Description for variable
 * @property mixed $caption Description for variable
 * @property mixed $type Description for variable
 * @property mixed $val Description for variable
 * @property mixed $data Description for variable
 * @property mixed $ord Description for variable

 *
 * @OA\Schema()
 * @OA\Property(
 *  property="id",
 *  type="integer",
 *  description=""
 * )
 * @OA\Property(
 *  property="survey_id",
 *  type="integer",
 *  description=""
 * )
 * @OA\Property(
 *  property="title",
 *  type="string",
 *  description=""
 * )
 * @OA\Property(
 *  property="caption",
 *  type="string",
 *  description=""
 * )
 * @OA\Property(
 *  property="type",
 *  type="integer",
 *  description=""
 * )
 * @OA\Property(
 *  property="val",
 *  type="string",
 *  description=""
 * )
 * @OA\Property(
 *  property="data",
 *  type="string",
 *  description=""
 * )
 * @OA\Property(
 *  property="ord",
 *  type="integer",
 *  description=""
 * )

 *
 * @author matiascamiletti
 */
class MiaSurveyQuestion extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'mia_survey_question';
    
    protected $casts = ['data' => 'array', 'val' => 'array'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
    * 
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function survey()
    {
        return $this->belongsTo(MiaSurvey::class, 'survey_id');
    }


    
}