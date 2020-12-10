<?php

namespace modava\slide\models\table;

use backend\components\MyModel;
use cheatsheet\Time;
use modava\slide\models\query\SlideCategoryQuery;
use Yii;

class SlideCategoryTable extends MyModel
{
    const STATUS_DISABLED = 0;
    const STATUS_PUBLISHED = 1;

    public static function tableName()
    {
        return 'slide_category';
    }

    public static function find()
    {
        return new SlideCategoryQuery(get_called_class());
    }

    public static function getAllSlideCategory($lang = null)
    {
        $cache = Yii::$app->cache;
        $key = 'redis-get-all-slide-category-' . $lang;

        $data = $cache->get($key);

        if ($data === false) {
            $query = self::find();
            if ($lang != null)
                $query->where(['language' => $lang]);
            $data = $query->published()->sortDescById()->all();
            $cache->set($key, $data, Time::SECONDS_IN_A_MONTH);
        }

        return $data;
    }

    public function afterDelete()
    {
        $cache = Yii::$app->cache;
        $keys = [
            'redis-get-all-slide-category-' . $this->language,
        ];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        $cache = Yii::$app->cache;
        $keys = [
            'redis-get-all-slide-category-' . $this->language,
        ];
        foreach ($keys as $key) {
            $cache->delete($key);
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
