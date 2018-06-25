<?php

namespace backend\modules\apiTest\controllers;

use backend\modules\apiTest\models\reference\User;
use backend\modules\apiTest\models\register\DailyActiveUser;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

/**
 *
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        $result = parent::verbs();
        $result['set-active-user'] = ['GET'];

        return $result;
    }

    /**
     * Регистрация посещения пользователя
     *
     * @param string $login
     *
     * @return bool|BadRequestHttpException
     * @throws BadRequestHttpException
     */
    public function actionSetActiveUser(string $login)
    {
        if ($user = User::findOne(['login' => $login])) {
            $reg = new DailyActiveUser();
            $reg->user_id = $user->primaryKey;
            $reg->save();

            return true;
        }

        throw new BadRequestHttpException("No user with login - {$login}");
    }

    /**
     *  количества уникальных пользователей для заданного промежутка дат
     *
     * @param string $startDate
     * @param string $endDate
     *
     * @return array
     */
    public function actionGetDailyActiveUsers($startDate, $endDate)
    {
        $form = new \backend\modules\apiTest\models\form\DailyActiveUser();
        $form->startDate = $startDate;
        $form->endDate = $endDate;
        if ($form->validate()) {
            $result = [
                'data'   => $form->getDailyActiveUser(),
                'result' => 'success',
            ];
        } else {
            $result[] = [
                'message' => $form->getErrors(),
                'result'  => 'error',
            ];
        }

        return $result;
    }
}