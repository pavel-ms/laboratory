<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 25.03.2015
 * Time: 14:14
 */

namespace app\controllers;


use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

class BaseRestController extends Controller
{
	/**
	 * Отменяем проверку токена для REST контроллеров
	 * @var bool
	 */
	public $enableCsrfValidation = false;

	public function runAction($id, $params = [])
	{
		$result = null;
		try {
			$result = parent::runAction($id, $params = []);
		} catch (\Exception $e) {
			if ($e instanceof BadRequestHttpException) {
				$result = $this->getRestResponse(400, ['err' => $e->getMessage()]);
			} elseif ($e instanceof ForbiddenHttpException) {
				$result = $this->getRestResponse(401, ['err' => $e->getMessage()]);
			} else {
				throw $e;
			}
		}

		return $result;
	}

	/**
	 * @param $code
	 * @param $data
	 * @return string
	 */
	public function getRestResponse($code, $data)
	{
		\Yii::$app->response->setStatusCode($code);
		// Ставим заголовки json
		\Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
		\Yii::$app->response->headers->add('Content-Type', 'application/json');
		return json_encode($data);
	}
}