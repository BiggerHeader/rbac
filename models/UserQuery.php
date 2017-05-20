<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserRole]].
 *
 * @see UserRole
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return UserRole[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserRole|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
