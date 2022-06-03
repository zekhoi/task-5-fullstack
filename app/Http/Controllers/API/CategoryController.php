<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::all();
        if($data){
            return response()->json([
                "message" => "Success",
                "data" => $data
            ], 200);
        }
        else
            return response()->json([
                "message" => "Not Found"
            ], 404);
    }

    public function show($id){
        $data = Category::find($id);
        if($data){
            return response()->json([
                "message" => "Success",
                "data" => $data
            ], 200);
        }
        else
            return response()->json([
                "message" => "Not Found"
            ], 404);
    }

    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'name' => 'required',
            'user_id' => 'required',
        ]);
        
        if ($validateData->fails()) {
            return response()->json([
                "message" => "Bad Request",
                "data" => $validateData->errors()
            ], 400);
        }
        
        $category=new Category();
        $category->name = $request->name;
        $category->user_id = auth()->user()->id;
        $category->save();

        return response()->json(
            [
            "message" => "Success",
            "data" => $category,
            ], 200);
    }

    public function update(Request $request, $id)
    {
        if($category = Category::find($id))
        {   

            $validateData = Validator::make($request->all(), [
                'name' => 'required',
                'user_id'=>'required',
            ]);
            
            if ($validateData->fails()) {
                return response()->json([
                    "message" => "Bad Request",
                    "data" => $validateData->errors()
                ], 400);
            }

            $name = $request->name;
            $user_id = auth()->user()->id;

            $category->name = $name;
            $category->user_id = $user_id;
            $category->save();

            return response()->json([
                "message" => "Success",
                "data" => $category], 201);
        }
        else
            return response()->json(["message" => "Not Found"], 404);
    }


    public function destroy($id){
        if($data = Category::find($id))
        {
            $article = Article::where('category_id',$id);
            $article->delete();
            $data->delete();
            return response()->json([
                "message" => "Success",
                ], 200);
        }
        else
            return response()->json([
                "message" => "Not Found"
            ], 404);
    }
}