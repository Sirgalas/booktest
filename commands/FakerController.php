<?php

namespace app\commands;

use app\Entities\Author\Form\AuthorForm;
use app\Entities\Author\Services\AuthorService;
use app\Entities\Book\Form\AuthorsBookForm;
use app\Entities\Book\Form\BookForm;
use app\Entities\Book\Services\BookService;
use Faker\Factory;
use yii\console\Controller;

class FakerController extends Controller
{

    private $bookService;
    private $authorService;
    private $faker;

    public function __construct(
        $id,
        $module,
        BookService $service,
        AuthorService $authorService,
        $config = []
    ) {
        $this->bookService = $service;
        $this->authorService = $authorService;
        $this->faker = Factory::create();
        parent::__construct($id, $module, $config);
    }

    public function actionBook()
    {

        for($i = 0; $i < 20; $i ++) {
            $book = [
                'title' => $this->faker->title,
                'year' => $this->faker->year(),
                'description' => $this->faker->text,
                'isbn' => $this->faker->randomFloat(),
            ];
            $bookForm = new BookForm();
            $bookForm->load($book,'');
            $this->bookService->create($bookForm);
        }
    }

    public function actionAuthor()
    {
        for($i = 0; $i < 20; $i ++) {
            $author = [
                'name' => $this->faker->firstName,
                'family' => $this->faker->lastName,
                'surname' => $this->faker->name
            ];
            $authorForm = new AuthorForm();
            $authorForm->load($author,'');
            $this->authorService->create($authorForm);
        }
    }

    public function actionAuthorBook()
    {

        for($i = 1; $i < 21; $i ++) {
            $book = $this->bookService->repository->find($i);
            if(!$book){
                continue;
            }
            $authorId = $this->faker->numberBetween(1,21);
            $authorBookForm = new AuthorsBookForm();
            $authorBookForm->load(['author_id' =>$authorId],'');
            $this->bookService->addAuthor($authorBookForm,$book);
        }
    }
}