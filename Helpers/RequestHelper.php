<?php

namespace app\Helpers;

use app\Entities\Author\Entity\Author;
use yii\helpers\ArrayHelper;

class RequestHelper
{
    public static function errorsToStr (array $errorsArray)
    {
        $errors = [];

        if(!empty($errorsArray)) {

            foreach ($errorsArray as $fieldErrors) {
                array_push($errors, implode(';', $fieldErrors));
            }

            return implode(' ', $errors);
        }

        return '';
    }

    public static function errorsToArray ($models)
    {
        $errors = [];

        if ( !empty($models) ) {

            foreach ( $models as $model ) {
                foreach ( $model->getFirstErrors() as $key => $value ) {
                    $errors[] = ['field' => $key, 'message' => $value];
                }

            }
        }
        return $errors;
    }

    public static function setMessage($author_id, $book_title,$sender)
    {
        $author = Author::findOne($author_id);
        $usersIdSubscribeAuthor = ArrayHelper::getColumn($author->users, 'id');
        $message = sprintf("%s add book %s", $author->getFullName(), $book_title);

        foreach ($usersIdSubscribeAuthor as $userIdSubscribeAuthor) {
            $sender->send($userIdSubscribeAuthor, $message);
        }
    }
}