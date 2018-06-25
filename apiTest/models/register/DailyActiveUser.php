<?php

namespace backend\modules\apiTest\models\register;

use DateTime;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * Регистр посещений
 *
 * @property int      $user_id
 * @property DateTime $date_time
 */
class DailyActiveUser extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $result['date_time'] = [
            'class'      => AttributeBehavior::className(),
            'attributes' => [
                self::EVENT_BEFORE_INSERT => 'date_time',
                self::EVENT_BEFORE_UPDATE => 'date_time',
            ],
            'value'      => function () {
                return (new DateTime())->format('Y-m-d H:i:s');
            },
        ];

        return array_merge(parent::behaviors(), $result);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['user_id'], 'integer'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{test_reg_daily_active_user}}';
    }
}