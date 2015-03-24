<?php
// Timestamp файлов сборки
require(__DIR__."/_staticFileBuildTs.php");

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<link rel="stylesheet" href="/static/css/main.css?<?= BUILD_TIMESTAMP; ?>">
    <?php $this->head() ?>
</head>
<body ng-app="app">
<?php $this->beginBody() ?>

	<div style="max-width: 1200px; margin: auto;">
			<div ng-view></div>
	</div>

<?php $this->endBody() ?>
<script type="application/javascript" src="/static/js-app/main.js?<?= BUILD_TIMESTAMP; ?>"></script>
</body>
</html>
<?php $this->endPage() ?>
