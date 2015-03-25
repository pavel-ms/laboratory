<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 25.03.2015
 * Time: 9:30
 */

namespace app\commands;


use app\models\User;
use yii\console\Controller;

class UserController extends Controller
{
	/**
	 * Генерируем пользователя в базу данных
	 *
	 * @example:
	 * $ php yii user/add test-name test-login test-password
	 **/
	public function actionAdd($name, $login, $password)
	{
		$usr = new User();
		$usr->attributes = [
			'login' => $login,
			'name' => $name,
			'password' => User::hashPassword($password),
			'token' => User::generateToken(),
		];
		if (!$usr->save()) {
			print_r($usr->errors);
		}
	}
}