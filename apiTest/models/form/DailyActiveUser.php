<?php

namespace backend\modules\apiTest\models\form;

use backend\modules\apiTest\models\reference\User;
use yii\base\Model;
use yii\db\Query;

/**
 * Модель формы для смены пароля
 */
class DailyActiveUser extends Model
{
    /**
     * @var string Новый пароль
     */
    public $startDate;

    /**
     * @var string Повтор нового пароля
     */
    public $endDate;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['startDate', 'endDate',], 'required',],
            [['startDate', 'endDate',], 'date', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    public function getDailyActiveUser()
    {
        return (new Query())
            ->select([
                'login' => 'u.login',
                'count' => 'count(*)'
            ])
            ->from(['reg' => \backend\modules\apiTest\models\register\DailyActiveUser::tableName()])
            ->innerJoin(['u' => User::tableName()], 'reg.user_id = u.id')
            ->andWhere(['>=', 'date_time', $this->startDate])
            ->andWhere(['<=', 'date_time', $this->endDate])
            ->groupBy('u.id')
            ->all();
    }
}