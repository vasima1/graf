<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "arrow".
 *
 * @property int $id
 * @property int $a
 * @property int $b
 * @property int $w
 *
 * @property Vertex $b0
 */
class Arrow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arrow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['a', 'b', 'w'], 'required'],
            [['a', 'b', 'w'], 'integer'],
            [['b'], 'exist', 'skipOnError' => true, 'targetClass' => Vertex::className(), 'targetAttribute' => ['b' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'a' => 'A',
            'b' => 'B',
            'w' => 'W',
        ];
    }

    /**
     * Gets query for [[B0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getB0()
    {
        return $this->hasOne(Vertex::className(), ['name' => 'b']);
    }
}
