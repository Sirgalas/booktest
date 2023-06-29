<?php
namespace app\Entities\Book\Form;
use app\Entities\Author\Entity\Author;
use app\Entities\Book\Entity\Book;
use app\Entities\File\Entity\File;

class BookForm extends \yii\base\Model
{
    public $title;
    public $year;
    public $description;
    public $isbn;



    public function __construct(Book $book = null, $config = [])
    {
        parent::__construct($config);

        if($book){
            $this->title = $book->title;
            $this->year = $book->year;
            $this->description = $book->description;
            $this->isbn = $book->isbn;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['isbn'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['year'], 'string', 'max' => 5],
            /*[
                ['file_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => File::class,
                'targetAttribute' => ['file_id' => 'id']
            ],
            [
                ['author_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Author::class,
                'targetAttribute' => ['file_id' => 'id']
            ],*/

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
        ];
    }

}