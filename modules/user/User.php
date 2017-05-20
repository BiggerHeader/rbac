<?php

namespace app\modules\user;

/**
 * user module definition class
 */
class User extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //配置子模块
        $this->modules=[
            'login' => [
                'class' => 'app\modules\user\modules\Login',
            ],
        ];

        // custom initialization code goes here
    }
}
