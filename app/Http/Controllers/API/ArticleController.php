<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    public function index()
    {
        $data = Article::paginate(5);
        if ($data) {
            return response()->json([
                "message" => "Success",
                "data" => $data
            ], 200);
        } else
            return response()->json([
                "message" => "Not Found"
            ], 404);
    }

    public function show($id)
    {
        $data = Article::find($id);
        if ($data) {
            return response()->json([
                "message" => "Success",
                "data" => $data
            ], 200);
        } else
            return response()->json([
                "message" => "Not Found"
            ], 404);
    }

    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|url',
            'category_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validateData->fails()) {
            dd($validateData->errors());
            return response()->json([
                "message" => "Bad Request",
                "data" => $validateData->errors()
            ], 400);
        }

        $article = new Article();
        $article->title = $request->title;
        $article->image = $request->image;
        $article->category_id = $request->category_id;
        $article->content = $request->content;
        $article->user_id = auth()->user()->id;
        $article->save();

        return response()->json(
            [
                "message" => "Success",
                "data" => $article,
            ],
            201
        );
    }

    public function update(Request $request, $id)
    {
        if ($article = Article::find($id)) {

            $validateData = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                'image' => 'required|url',
                'category_id' => 'required',
                'user_id' => 'required',
            ]);

            $article = Article::findOrFail($id);
            if ($request->file('image')) {
                if ($request->image) {
                    File::delete(public_path('assets/' . $article->image));
                }


                $data = $request->image->hashName();
                $request->image->move('assets', $data);
                $article->image = $data;
            }

            $article->user_id = auth()->user()->id;
            $article->category_id = $request->category_id;
            $article->title = $request->title;
            $article->content = $request->content;
            $article->save();

            return response()->json([
                "message" => "Success",
                "data" => $article
            ], 201);
        } else
            return response()->json(["message" => "Not Found"], 404);
    }

    public function destroy($id)
    {
        if ($article = Article::find($id)) {
            File::delete(public_path('assets/' . $article->image));
            $article->delete();
            return response()->json([
                "message" => "Success",
            ], 200);
        } else
            return response()->json([
                "message" => "Not Found"
            ], 404);
    }
}