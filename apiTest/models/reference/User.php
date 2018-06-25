<?php

namespace backend\modules\apiTest\models\reference;

use yii\db\ActiveRecord;

/**
 * Модель пользователя
 *
 * @property string $login
 * @property string $name
 *
 */
class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [['login'], 'string', 'max' => 50],
                [['name'], 'string', 'max' => 250],
                [['login'], 'unique'],
            ]
        );
    }

    public static function tableName()
    {
        return '{{test_ref_user}}';
    }
}