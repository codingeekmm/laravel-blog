<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    public function index()
    {
        // $data = [
        //     ["id" => 1, "title" => 'First Article'],
        //     ["id" => 2, "title" => 'Second Article'],
        // ];

        // $articles = [
        //     [
        //         "userId" => 1,
        //         "id" => 1,
        //         "title" => "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
        //         "body" => "quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto"
        //     ],
        //     [
        //         "userId" => 1,
        //         "id" => 2,
        //         "title" => "qui est esse",
        //         "body" => "est rerum tempore vitae\nsequi sint nihil reprehenderit dolor beatae ea dolores neque\nfugiat blanditiis voluptate porro vel nihil molestiae ut reiciendis\nqui aperiam non debitis possimus qui neque nisi nulla"
        //     ],
        // ];


        // print($articles);
        // return 'Controller - Article List';
        // return view('articles/index');
        // return view('articles/index', ['articles' => $articles]);

        // $articles = Http::get('https://jsonplaceholder.typicode.com/posts');
        // return view('articles/index')->with('articles', json_decode($articles, true));;

        // $data = Article::all();
        $data = Article::latest()->paginate(5);
        return view('articles.index', [
            'articles' => $data
        ]);
    }

    public function detail($id)
    {
        $data = Article::find($id);
        return view('articles.detail', [
            'article' => $data
        ]);
        // return "Cotnroller - Article Detail - $id";
    }

    public function add()
    {
        $data = Category::all();
        return view('articles.add', [
            'categories' => $data
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();
        return redirect('/articles');
    }

    public function delete($id)
    {
        $article = Article::find($id);
        $article->delete();
        return redirect('/articles')->with('info', 'Article deleted');
    }
}
