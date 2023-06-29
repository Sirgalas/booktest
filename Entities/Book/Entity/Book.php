<?php

namespace app\Entities\Book\Entity;

use app\Entities\Author\Entity\Author;
use app\Entities\Author\Entity\BookAuthor;
use app\Entities\Book\Form\BookForm;
use app\Entities\File\Entity\File;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $year
 * @property string|null $description
 * @property float|null $isbn
 * @property int|null $file_id
 *
 * @property Author[] $authors
 * @property BookAuthor[] $bookAuthors
 * @property File $file
 */
class Book extends \yii\db\ActiveRecord
{

    const PATH_FIRST='book';

    public function behaviors(): array
    {
        return [
            [
                'class'     => SaveRelationsBehavior::class,
                'relations' => ['file','authors'],
            ],
        ];
    }

    public static function create(BookForm $form): self
    {
        $book = new static();
        $book->title = $form->title;
        $book->year = $form->year;
        $book->description = $form->description;
        $book->isbn = $form->isbn;
        return $book;
    }

    public function edit(BookForm $form): void
    {
        $this->title = $form->title;
        $this->year = $form->year;
        $this->description = $form->description;
        $this->isbn = $form->isbn;
        $this->file_id = $form->file_id;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'file_id' => 'File ID',
        ];
    }

    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->via('bookAuthors');
    }

    public function getBookAuthors(): ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    public function getFile():ActiveQuery
    {
        return $this->hasOne(File::class, ['id' => 'file_id']);
    }

    public function addFile(UploadedFile $file)
    {

        if (is_object($this->file)) {
            $this->file->deleteFiles();
        }
        $fileUpload = File::create($file, $this->getUrl(), );
        $this->updateFile($fileUpload);
    }

    public function getUrl() {
        return self::PATH_FIRST;
    }

    public function addAuthors(Author $author): void
    {
        $authors = $this->authors;
        foreach ($authors as $oneAuthor) {
            if($oneAuthor->isHasAuthor($author->id)) {
                return;
            }
        }
        $authors[] = $author;
        $this->authors = $authors;
    }

    public function removeAuthor(int $id) {
        $authors = $this->authors;
        foreach ($authors as  $key => $author) {
            if($author->isHasAuthor($id)) {
                unset($authors[$key]);
            }
        }
        $this->authors = $authors;
    }

    public function dropAuthor(int $authorId) {
        foreach ($this->authors as $oneAuthor) {
            if($oneAuthor->id == $authorId) {

            }
        }
    }

    private function updateFile($files): void
    {
        $this->file = $files;
    }




}
