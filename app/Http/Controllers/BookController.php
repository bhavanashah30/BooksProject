<?php

namespace App\Http\Controllers;

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
     * BookController constructor.
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
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
        $data = json_decode($request->data);
        $this->bookService->saveBook($data->bookName, $data->author, $data->genre);
        return response()->json('Success', 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request)
    {
        $data = json_decode($request->data);
        $this->bookService->updateBook($data->bookName, $data->author, $data->genre, $data->id);

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
}
