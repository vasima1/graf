<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "vertex".
 *
 * @property int $id
 * @property int $name
 * @property int $chk
 * @property int $metka
 *
 * @property Arrow[] $arrows
 */
class Vertex extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vertex';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'chk', 'metka'], 'integer'],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'chk' => 'Chk',
            'metka' => 'Metka',
        ];
    }

    /**
     * Gets query for [[Arrows]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArrows()
    {
        return $this->hasMany(Arrow::className(), ['b' => 'name']);
    }
}
