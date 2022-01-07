<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>

    <style type="text/css">
        .footer {
            font-size: 1.2em;
            font-weight: 600;
            color: #e0e0e0;
            text-align: center;
            letter-spacing: 0;
            background-color: #2f2f2f;
            border-radius: 2px;
        }

        table.header {
            font-size: 1.2em;
            font-weight: 600;
            padding: 15px 0 15px 0;
        }

        .header .logo {
            width: 300px;
            max-width: 300px;
        }

        .header .logo img {
            max-width: 300px;
        }

        .header .storehouse {
            text-align: right;
            text-transform: capitalize;
            font-size: 20px;
        }

        .py-4 {padding-top: 15px;padding-bottom: 15px;}
        .px-4 {padding-left: 15px;padding-right: 15px;}
        .storehouse-table {
            position: relative;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px 0 rgba(0,0,0,.15);
            -moz-box-shadow: 0 0 10px 0 rgba(0,0,0,.15);
            -webkit-box-shadow: 0 0 10px 0 rgba(0,0,0,.15);
            -o-box-shadow: 0 0 10px 0 rgba(0,0,0,.15);
            width: 800px;
            font-family:Arial,Helvetica Neue,Helvetica,sans-serif;
        }
        .storehouse-table .header {
            box-shadow: 0 0 10px 0 rgba(0,0,0,.1);
            -moz-box-shadow: 0 0 10px 0 rgba(0,0,0,.1);
            -webkit-box-shadow: 0 0 10px 0 rgba(0,0,0,.1);
            -o-box-shadow: 0 5px 20px 0 rgba(0,0,0,.1);
            border-radius: 5px 5px 0 0;
        }
        .storehouse-table th {
            padding-top: 18px;
            padding-bottom: 18px;
        }

        .storehouse-table .cell {
            font-size: 1em;
            color: #eb0a0a;
            line-height: 1.4;
            background-color: transparent;
            font-weight: bold;
        }

        .storehouse-table tbody tr {
            border-bottom: 1px solid #C7CAD8;
        }

        .storehouse-table tbody td {
            border-bottom: 1px solid #C7CAD8;
            padding-left: 15px;
            padding-right: 10px;
        }

        .storehouse-table .row {
            font-size: 15px;
            color: gray;
            line-height: 1.4;
            padding-top: 16px;
            padding-bottom: 16px;
        }
        .ref {
            color: red;
            text-decoration: none;
            text-transform: uppercase;
        }

        .storehouse-table td.subheader{
            color: #e0e0e0;
            background-color: #1b1e24;
            border-bottom: 4px solid #9ea7af;
            font-size: 20px;
            font-weight: 100;
            padding: 15px;
            text-align: left;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            vertical-align: middle;
        }
    </style>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
