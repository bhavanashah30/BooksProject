<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Detail;
use App\Services\BookService;

use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BookTest extends TestCase
{
    //use DatabaseTransactions;

    private $bookService;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookService = app()->make(BookService::class);
    }

    public function test_getBooks()
    {
        $books = $this->bookService->getBooks();
        $this->assertNotEmpty($books);
    }

    public function test_saveBook_savesBooktoDatabase()
    {
        $this->bookService->saveBook('Test Book', 'Peter', 'Horror');
        $this->assertDatabaseHas('Books', ['name'=>'Test Book']);
    }

    public function test_saveBook_savesDetailtoDatabase()
    {
        $this->bookService->saveBook('Test', 'Peter Pan', 'Children');
        $this->assertDatabaseHas('Details', ['author'=>'Peter Pan', 'genre' => 'Children']);
    }

    public function test_updateBook_updatesBookName() {
        //create fake book
        $book = Book::create([
            'name'=>'Test Update'
        ]);
        $this->assertDatabaseHas('Books', ['id'=>$book->id, 'name'=>$book->name]);
        $detail = Detail::create([
            'book_id' => $book->id,
            'author' => 'Author1',
            'genre' => 'Children'
        ]);
        $this->assertDatabaseHas('Details', ['book_id'=>$book->id, 'author'=>$detail->author, 'genre'=>$detail->genre]);
        $this->bookService->updateBook('Test', $detail->author, $detail->genre, $book->id);
        $this->assertDatabaseHas('Books', ['id'=>$book->id, 'name'=>'Test']);
        $this->assertDatabaseHas('Details', ['book_id'=>$book->id, 'author'=>$detail->author, 'genre'=>$detail->genre]);
    }

    public function test_updateBook_updatesBookDetails() {
        //create fake book
        $book = Book::create([
            'name'=>'Test Detail Update'
        ]);
        $detail = Detail::create([
            'book_id' => $book->id,
            'author' => 'Author Name',
            'genre' => 'Fiction'
        ]);
        $this->assertDatabaseHas('Books', ['id'=>$book->id, 'name'=> $book->name]);
        $this->assertDatabaseHas('Details', ['book_id'=>$book->id, 'author'=>$detail->author, 'genre'=>$detail->genre]);

        $this->bookService->updateBook($book->name, 'Arthur', 'Love Story', $book->id);
        $this->assertDatabaseHas('Books', ['id'=>$book->id, 'name'=> $book->name]);
        $this->assertDatabaseHas('Details', ['book_id'=>$book->id, 'author'=>  'Arthur', 'genre'=> 'Love Story']);
    }

    public function test_updateBook_throwsBookNotFoundException()
    {
        $this->expectException(Exception::class);
        $this->bookService->updateBook('Test', 'Arthur', 'Love Story', 5000);
    }

    public function test_deleteBook_deletesBookAndAssociatedDetails()
    {
        $book = Book::create([
            'name'=>'Test Delete'
        ]);
        $detail = Detail::create([
            'book_id' => $book->id,
            'author' => 'Author for Delete',
            'genre' => 'Genre For Delete'
        ]);
        $this->assertDatabaseHas('Books', ['name'=>$book->name]);
        $this->assertDatabaseHas('Details', ['book_id'=>$book->id, 'author'=>$detail->author]);
        $this->bookService->deleteBook($book->id);
        $this->assertDatabaseMissing('Books', ['name'=>$book->name]);
        $this->assertDatabaseMissing('Details', ['book_id'=>$book->id, 'author'=>$detail->author]);
    }

    public function test_deleteBook_throwsException()
    {
        $this->expectException(Exception::class);
        $this->bookService->deleteBook(5000);
    }

    public function test_test()
    {
        $data = new \stdClass();
        $data->bookName = 'Text Book';
        $data->author = 'Jane Doe';
        $data->genre = 'Academics';
        dd(json_encode($data));

    }

}
