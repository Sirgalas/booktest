<?php

namespace app\Helpers;

class HelperView
{
    public static function template(string $role, string $template): string
    {
        $returnTemplate = "{view}";
        if(\Yii::$app->user->can($role)){
            $returnTemplate .= $template;
        }
        return $returnTemplate;
    }
}