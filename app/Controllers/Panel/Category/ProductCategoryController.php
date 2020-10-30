<?php

namespace App\Controllers\Panel\Category;

use App\Controllers\Controller;
use App\Models\Category;
use App\Providers\CSRFToken;
use App\Providers\QueryBuilder;
use App\Providers\Redirect;
use App\Providers\Request;
use App\Providers\Session;
use App\Providers\ValidateRequest;

class ProductCategoryController extends Controller
{
    public $table_name = "categories";
    public $categories;
    public $links;

    public function __construct()
    {
        $total = Category::all()->count();
        $object = new Category();
        list($this->categories, $this->links) = paginate(5, $total, $this->table_name, $object);
    }

    public function index()
    {
        return view('panel/categories/index', [
            'categories' => $this->categories,
            'links' => $this->links,
        ]);
    }

    public function create()
    {
        return view('panel/categories/create');
    }

    public function store()
    {
        if(Request::has('post'))
        {
//            dd(session('success', 'Category Deleted'));
            $request = Request::input('post');
            //session khali mishavad
            if(CSRFToken::verifyCSRFToken($request->token))
            {
                $rules = [
                    'name' => [
                        'required' => true,
                        'maxLength' => 1,
                        'string' => true,
                        'unique' => 'categories',
                        ]
                ];

                $validator = new ValidateRequest();
                $validator->abide($_POST, $rules);

                if($validator->hasError())
                {
                    $errors = $validator->getErrorMessages();
                    dd($errors);
                    return view('/admin/products/categories', [
                        'categories' => $this->categories,
                        'links' => $this->links,
                        'errors' => $errors,
                    ]);
                }

                $category = new Category();
                $category->name = $request->name;
                $category->slug = slug($request->name);
//                $category->save();
                $total = Category::all()->count();
                list($this->categories, $this->links) = paginate(5, $total, $this->table_name, new Category());
                if($category->save())
//                      return Redirect::to('/admin/product/categories');
//                    $message = "success";
//                    $categories = Category::all();
                    return view('panel/categories/index', [
                        'categories' => $this->categories,
                        'links' => $this->links,
                        'success' => 'Category Created'
                    ]);
            }

            throw new \Exception('Token mismatch');
        }
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
//        dd($category);
        return view('panel/categories/show', compact('category'));
    }

    public function edit($id)
    {
        if(Request::has('post'))
        {
            $request = Request::input('post');
            //session khali mishavad
            if(CSRFToken::verifyCSRFToken($request->token))
            {
                $rules = [
                    'name' => [
                        'required' => true,
                        'maxLength' => 1,
                        'string' => true,
                        'unique' => 'categories',
                    ]
                ];

                dd($rules);

                $validator = new ValidateRequest();
                $validator->abide($_POST, $rules);

                if($validator->hasError())
                {
                    $errors = $validator->getErrorMessages();
                    dd($errors);
                    header('HTTP/1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($errors);
                    exit;
                }

                Category::where('id', $id)->update(['name' => $request->name]);
                echo json_encode(['success' => 'Record Update Successfully']);
                exit;
            }

            throw new \Exception('Token mismatch');
        }
    }

    public function update()
    {

    }

    public function destroy($id)
    {
        if(Request::has('post'))
        {
            $request = Request::input('post');
            //session khali mishavad
            if(CSRFToken::verifyCSRFToken($request->token))
            {
                Category::destroy($id);
                session('success', 'Category Deleted');
                back();
            }

            throw new \Exception('Token mismatch');
        }
    }
}