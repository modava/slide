<?php

namespace modava\slide\models;

use common\models\User;
use modava\slide\models\table\SlideTable;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use common\helpers\MyHelper;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "slide".
 *
 * @property int $id
 * @property int $slide_type
 * @property int $slide_category
 * @property string $title
 * @property string $slug
 * @property string $image
 * @property string $link
 * @property string $description
 * @property int $position
 * @property int $status
 * @property string $language
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property SlideCategory $slideCategory
 * @property SlideType $slideType
 * @property User $updatedBy
 */
class Slide extends SlideTable
{
    public $toastr_key = 'slide';

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'slug' => [
                    'class' => SluggableBehavior::class,
                    'immutable' => false,
                    'ensureUnique' => true,
                    'value' => function () {
                        return MyHelper::createAlias($this->title);
                    }
                ],
                [
                    'class' => BlameableBehavior::class,
                    'createdByAttribute' => 'created_by',
                    'updatedByAttribute' => 'updated_by',
                ],
                'timestamp' => [
                    'class' => 'yii\behaviors\TimestampBehavior',
                    'preserveNonEmptyValues' => false,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slide_type', 'slide_category', 'position', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'slug'], 'required'],
            [['description'], 'string'],
            [['title', 'slug', 'image', 'link'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 25],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['slide_category'], 'exist', 'skipOnError' => true, 'targetClass' => SlideCategory::class, 'targetAttribute' => ['slide_category' => 'id']],
            [['slide_type'], 'exist', 'skipOnError' => true, 'targetClass' => SlideType::class, 'targetAttribute' => ['slide_type' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'slide_type' => Yii::t('backend', 'Slide Type'),
            'slide_category' => Yii::t('backend', 'Slide Category'),
            'title' => Yii::t('backend', 'Title'),
            'slug' => Yii::t('backend', 'Slug'),
            'image' => Yii::t('backend', 'Image'),
            'link' => Yii::t('backend', 'Link'),
            'description' => Yii::t('backend', 'Description'),
            'position' => Yii::t('backend', 'Position'),
            'status' => Yii::t('backend', 'Status'),
            'language' => Yii::t('backend', 'Language'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
            'created_by' => Yii::t('backend', 'Created By'),
            'updated_by' => Yii::t('backend', 'Updated By'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->on(yii\db\BaseActiveRecord::EVENT_AFTER_INSERT, function (yii\db\AfterSaveEvent $e) {
            if ($this->position == null)
                $this->position = $this->primaryKey;
            $this->save();
        });
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
