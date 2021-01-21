<?php

namespace App\Http\Controllers;

use App\Services\APIService;
use App\Services\BookService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * @var BookService
     */
    private $bookService;

    /**
     * @var APIService
     */
    private $apiService;


    /**
     * BookController constructor.
     * @param BookService $bookService
     * @param APIService $apiService
     */
    public function __construct(BookService $bookService, APIService $apiService)
    {
        $this->bookService = $bookService;
        $this->apiService = $apiService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('booksList');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->data;
        $this->bookService->saveBook($data['bookName'], $data['author'], $data['genre']);
        return response()->json('Success', 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request)
    {
        $data = $request->data;
        $this->bookService->updateBook($data['bookName'], $data['author'], $data['genre'], $data['id']);

        return response()->json('Success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($id): JsonResponse
    {
        $this->bookService->deleteBook($id);

        return response()->json('Success', 200);
    }

    /**
     * @return JsonResponse
     */
    public function getBooks(): JsonResponse
    {
        $books = $this->bookService->getBooks();

        return response()->json($books, 200);
    }

    /**
     * @return View
     */
    public function bookSuggestions(): View
    {
        return view('bookSuggestions');
    }

    /**
     * @return JsonResponse
     */
    public function getBooksInDescendingOrder(): JsonResponse
    {
        $books = $this->bookService->sortBooksByNameDescending();

        return response()->json($books, 200);
    }

    /**
     * @return JsonResponse
     */
    public function getBooksFromPublicAPI(): JsonResponse
    {
        $books = $this->apiService->get(config('api.booksApiUrl'));

        return response()->json($books, 200);
    }
}
