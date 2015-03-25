<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 25.03.2015
 * Time: 12:23
 */

namespace app\controllers;


use app\models\LoginForm;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

class AuthController extends BaseRestController
{

	/**
	 * Авторизация пользователя
	 */
	public function actionGetToken()
	{
		$reqParams = \Yii::$app->request->getBodyParams();
		if (isset($reqParams['login']) && isset($reqParams['password'])) {
			$loginForm  = new LoginForm();
			$loginForm->attributes = $reqParams;

			if ($loginForm->validate()) {
				$usr = $loginForm->getUser();
				return $this->getRestResponse(200, $usr->attributes);
			} else {
				throw new ForbiddenHttpException('Such user can not be found');
			}

		} else {
			throw new BadRequestHttpException('Params login and password must be specified');
		}
	}
}