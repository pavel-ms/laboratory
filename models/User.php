<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $ts
 * @property string $ts_update
 * @property string $login
 * @property string $password
 * @property string $token
 * @property string $name
 *
 * @property Message[] $messages
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	// Соль для хеширования паролей
	const PASSWORD_SALT = 'qW-Dvb6t8TRb12ZzM--';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'password', 'token', 'name'], 'required'],
            [['id'], 'integer'],
            [['id', 'ts', 'ts_update'], 'safe'],
            [['login'], 'string', 'max' => 255],
            [['password', 'token', 'name'], 'string', 'max' => 120]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ts' => 'Ts',
            'ts_update' => 'Ts Update',
            'login' => 'Login',
            'password' => 'Password',
            'token' => 'Token',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['user_id' => 'id']);
    }

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		foreach (self::$users as $user) {
			if ($user['accessToken'] === $token) {
				return new static($user);
			}
		}

		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->authKey;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->authKey === $authKey;
	}

	/**
	 * Finds user by username
	 *
	 * @param  string  $login
	 * @return static|null
	 */
	public static function findByUsername($login)
	{
		return static::find('login = :l', [
			':l' => $login,
		]);
	}

	/**
	 * Функция хеширования пароля
	 * @param $password
	 */
	public static function hashPassword($password)
	{
		return hash('sha256', ($password . self::PASSWORD_SALT));
	}

	/**
	 * Генерируем случайный хэш
	 */
	public static function generateToken()
	{
		return hash('sha256', (rand(). microtime() . self::PASSWORD_SALT));
	}
}
