<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\db\User;

class Profile extends Model
{
    public $bank_account;
    public $address;

    public $username;
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['bank_account', 'string', 'length' => 16],
            ['address', 'string', 'max' => 100],
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $user->setAttributes($this->attributes);
        return $user->save();
    }
}
