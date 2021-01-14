<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Detail;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class BookService
 * @package App\Services
 */
class BookService
{
    /**
     * @return Collection
     */
    public function getBooks(): Collection
    {
        return Book::with('detail')->get();
    }


    /**
     * @param string $bookName
     * @param string $author
     * @param string $genre
     * @throws Exception
     */
    public function saveBook(string $bookName, string $author, string $genre): void
    {
        DB::beginTransaction();
        try {
           $book = Book::create([
               'name' => $bookName
           ]);
           Detail::create([
               'book_id' => $book->id,
               'author' => $author,
               'genre' => $genre
           ]);
           DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param string $bookName
     * @param string $author
     * @param string $genre
     * @param int|null $bookId
     * @throws Exception
     */
    public function updateBook(string $bookName, string $author, string $genre, int $bookId = null): void
    {
        DB::beginTransaction();
        try {
            $book = Book::findOrFail($bookId);
            Book::where('id', $book->id)
                ->update([
                    'name' => $bookName
                ]);
            Detail::where('book_id', $bookId)
                ->update([
                    'author' => $author,
                    'genre' => $genre
                ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param int $bookId
     * @throws Exception
     */
    public function deleteBook(int $bookId): void
    {
        DB::beginTransaction();
        try{
            $book = Book::findOrFail($bookId);
            Detail::where('book_id', $book->id)
                ->delete();
            Book::where('id', $book->id)
                ->delete();
            DB::commit();
        } catch(Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

}
