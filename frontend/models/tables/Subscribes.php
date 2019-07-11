<?php

namespace frontend\models\tables;

use Yii;

/**
 * This is the model class for table "subscribes".
 *
 * @property int $id
 * @property int $telegram_id
 * @property string $name Название подписки
 * @property int $status_id
 */
class Subscribes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telegram_id', 'status_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'telegram_id' => 'Telegram ID',
            'name' => 'Name',
            'status_id' => 'Status ID',
        ];
    }
}
