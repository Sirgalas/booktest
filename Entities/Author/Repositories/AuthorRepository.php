<?php

namespace app\Entities\Author\Repositories;

use app\Entities\Author\Entity\Author;
use app\Helpers\RequestHelper;
use RuntimeException;
use yii\data\SqlDataProvider;
use yii\db\ActiveQuery;
use yii\db\DataReader;

class AuthorRepository
{
    public function one(int $id): Author
    {
        if(!$Author = Author::findOne($id)) {
            throw new RuntimeException("Author not find");
        }
        return $Author;
    }

    public function find(int $id):? Author
    {
        if(!$Author = Author::findOne($id)) {
            return null;
        }
        return $Author;
    }


    public function save(Author $Author): Author
    {
        if(!$Author->save()){
            throw  new RuntimeException(RequestHelper::errorsToStr($Author->errors));
        }
        return $Author;
    }

    public function remove(int $id): void
    {
        $Author = $this->one($id);
        $Author->delete();
    }

    public function topTen(string $year):SqlDataProvider
    {
        $sql = "
            select *, (
                select
                    count(*)
                from
                    book
                where
                    book.id in (
                        select
                            book_id
                        from
                            book_author
                        where
                            author_id = a.id
                        
                    )
                and 
                    book.year = $year
                ) as bc
            from author a
            order by bc desc
            limit 10;
        ";
        return new SqlDataProvider([
            'sql' => $sql,
            'totalCount' =>10
        ]);
    }

    public static function getAll(): array
    {
        return Author::find()->all();
    }
}