<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Http\Requests\Categories\SaveFormRequest;
use App\Http\Requests\Categories\UpdateFormRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        // Initiate Permission
        $this->middleware('permission:category-list', ['only' => ['index']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-view', ['only' => ['show']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $categories = $this->categoryService->lists($data);

        $search = $request->search;

        return view("categories.list", compact(["categories", "search"]));
    }

    public function create()
    {
        $category_options = $this->categoryService->getParentsList();
        return view("categories.create", compact('category_options'));
    }

    public function edit($id)
    {
        $category_options = Category::pluck('name', 'id');
        $category = $this->categoryService->getById($id);

        return view("categories.edit", compact(["category", "category_options"]));
    }

    public function store(SaveFormRequest $request)
    {

        $validatedData = $request->all();

        $category = $this->categoryService->updateOrCreate($validatedData);

        if (is_null($category) === false) {
            $message = message("Category has been successfully created.");
        } else {
            $message = message("Category has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function update(UpdateFormRequest $request)
    {
        $validatedData = $request->all();

        $category = $this->categoryService->updateOrCreate($validatedData);

        if (is_null($category) === false) {
            $message = message("Category has been successfully updated.");
        } else {
            $message = message("Category has not updated.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function show($id)
    {
        $category = $this->categoryService->getById($id);

        return view("categories.view", compact(["category"]));
    }

    public function destroy(Category $category)
    {
        if ($category->items()->exists()) {

            $message = message("Category cannot be deleted. Because, items are assigned to it.", "error");
            
        } else {

            $response = $this->categoryService->delete($category);

            if ($response === true) {
                $message = message("Category has been successfully deleted.");
            } else {
                $message = message("Category has not deleted.", "error");
            }
        }

        session()->flash("message", $message);
        return redirect()->back();
    }
}
