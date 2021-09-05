<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Загрузка изображений
 */
class UploadImage extends Model
{
    public $img;

    public function rules()
    {
        return
        [
            [['img'], 'file', 'extensions' => 'png, jpg', 'maxSize' => 2024*1024],
        ];
    }


    public function upload()
    {
        if($this->validate() && Yii::$app->request->post()) {
            $this->img->saveAs("../web/post_images/{$this->img->baseName}.{$this->img->extension}");
        } else {
            return false;
        }

    }
    
}
