<?php

namespace matejch\iot24meter\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 */
class Alert extends Widget
{
    public function init()
    {
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $html = '';
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            if (is_array($message)) {
                $html .= '<div class="font-bold w-full" style="max-width: 1400px;margin: 20px auto 0 auto;">';
                foreach ($message as $m) {
                    $class = $alertClasses[$key] ?? '';
                    $icon = $headerIcons[$key] ?? '';
                    $html .= "<p class='px-4 py-4 w-full alert alert-dismissible $class'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close' style='top: unset;right: unset'>&times;</a>
                          $icon $m
                    </p>";
                }
                $html .= '</div>';
            } else {
                $class = $alertClasses[$key] ?? '';
                $icon = $headerIcons[$key] ?? '';
                $html .= "<p class='px-4 py-4 font-bold w-full alert alert-dismissible  $class' style='max-width: 1400px;margin: 20px auto 0 auto;'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close' style='top: unset;right: unset'>&times;</a>
                 $icon  $message
            </p>";
            }
        }

        return $html;
    }
}