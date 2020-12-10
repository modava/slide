<?php

namespace modava\slide\models\table;

use backend\components\MyModel;
use common\models\User;
use modava\slide\models\query\SlideQuery;
use modava\slide\models\SlideCategory;
use modava\slide\models\SlideType;
use Yii;

class SlideTable extends MyModel
{
    const STATUS_DISABLED = 0;
    const STATUS_PUBLISHED = 1;

    public static function tableName()
    {
        return 'slide';
    }

    public static function find()
    {
        return new SlideQuery(get_called_class());
    }

    public function afterDelete()
    {
        $cache = Yii::$app->cache;
        $keys = [];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        $cache = Yii::$app->cache;
        $keys = [];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * Gets query for [[SlideCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSlideCategory()
    {
        return $this->hasOne(SlideCategory::class, ['id' => 'slide_category']);
    }

    /**
     * Gets query for [[SlideType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSlideType()
    {
        return $this->hasOne(SlideType::class, ['id' => 'slide_type']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCreated()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserUpdated()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
