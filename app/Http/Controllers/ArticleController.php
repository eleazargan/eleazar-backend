<?php

namespace App\Http\Controllers;

use App\Repositories\Article;
use App\Repositories\Staircase;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private $article;
    private $staircase;

    public function __construct(Article $article, Staircase $staircase)
    {
        $this->article = $article;
        $this->staircase = $staircase;
    }

    public function get(Request $request)
    {
        $this->validate($request, [
            'page' => 'nullable',
            'title' => 'nullable',
            'description' => 'nullable',
            'tags' => 'nullable'
        ]);

        $response = $this->article->get($request->input());

        return $response->json();
    }

    public function getById($articleId)
    {
        $response = $this->article->getById($articleId);

        return $response->json();
    }

    public function create(Request $request)
    {
        $response = $this->article->create($request->all());

        return $response->json();
    }

    public function update(Request $request, $articleId)
    {
        $response = $this->article->update($articleId, $request->all());

        return $response->json();
    }

    public function delete($articleId)
    {
        $response = $this->article->delete($articleId);

        return $response->json();
    }
}
