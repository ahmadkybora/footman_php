<?php

namespace App\Controllers\Panel\Category;

use App\Controllers\Controller;
use App\Models\Category;
use App\Providers\CSRFToken;
use App\Providers\Request;
use App\Providers\ValidateRequest;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function store()
    {
        if(Request::has('post'))
        {
//            dd(session('success', 'Category Deleted'));
            $request = Request::get('post');
            $extra_errors = [];
            //session khali mishavad
            if(CSRFToken::verifyCSRFToken($request->token))
            {
                $rules = [
                    'name' => ['required', 'maxLength' => 1, 'string' => true],
                    'category_id' => ['required'],
                ];

                $validator = new ValidateRequest();
                $validator->abide($_POST, $rules);

                $deplicate_subcategory = SubCategory::where('name', $request->name)
                    ->where('category_id', $request->category_id)->exists();

                if($deplicate_subcategory)
                {
                    $extra_errors['name'] = array('subcategory already exist');
                }

                $category = Category::where('id', $request->category_id);
                if(!$category)
                {
                    $extra_errors['name'] = array('Invalid Product category already exist');
                }

                if($validator->hasError() or $deplicate_subcategory or !$category)
                {
                    $errors = $validator->getErrorMessages();
                    count($extra_errors) ? $response = array_merge($errors, $extra_errors) : $response = $errors;
                    header('HTTP/1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($response);
                    exit;

//                    dd($errors);
//                    return view('/admin/products/categories', [
//                        'categories' => $this->categories,
//                        'links' => $this->links,
//                        'errors' => $errors,
//                    ]);
                }

                $SubCategory = new SubCategory();
                $SubCategory->name = $request->name;
                $SubCategory->slug = slug($request->name);
//                $category->save();
                $total = SubCategory::all()->count();
                list($this->SubCategory, $this->links) = paginate(5, $total, $this->table_name, new SubCategory());
                if($SubCategory->save())
                    echo json_encode(['success' => 'subcategory create successfully']);
                    exit;
//                      return Redirect::to('/admin/product/categories');
//                    $message = "success";
//                    $categories = Category::all();
                    return view('panel/categories/index', [
                        'categories' => $this->SubCategory,
                        'links' => $this->links,
                        'success' => 'Category Created'
                    ]);
            }

            throw new \Exception('Token mismatch');
        }
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}