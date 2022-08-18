<?php

namespace Mia\Survey\Repository;

use \Illuminate\Database\Capsule\Manager as DB;
use Mia\Survey\Model\MiaSurveyInvitation;

/**
 * Description of MiaSurveyInvitationRepository
 *
 * @author matiascamiletti
 */
class MiaSurveyInvitationRepository 
{
    /**
     * 
     * @param \Mia\Database\Query\Configure $configure
     * @return \Illuminate\Pagination\Paginator
     */
    public static function fetchByConfigure(\Mia\Database\Query\Configure $configure)
    {
        $query = \Mia\Survey\Model\MiaSurveyInvitation::select('mia_survey_invitation.*');
        
        if(!$configure->hasOrder()){
            $query->orderByRaw('id DESC');
        }
        $search = $configure->getSearch();
        if($search != ''){
            //$values = $search . '|' . implode('|', explode(' ', $search));
            //$query->whereRaw('(firstname REGEXP ? OR lastname REGEXP ? OR email REGEXP ?)', [$values, $values, $values]);
        }
        
        // Procesar parametros
        $configure->run($query);

        return $query->paginate($configure->getLimit(), ['*'], 'page', $configure->getPage());
    }

    public static function create($surveyId, $userId, $email, $caption = '')
    {
        $item = new MiaSurveyInvitation();
        $item->survey_id = $surveyId;
        $item->user_id = $userId;
        $item->email = $email;
        $item->caption = $caption;
        $item->token = md5($item->user_id . $item->email . time());
        $item->save();
        return $item;
    }
}
