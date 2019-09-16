<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CRUDInterface;
use App\Repositories\Interfaces\ResponseInterface;
use Ramsey\Uuid\Uuid;

class Article implements CRUDInterface, ResponseInterface
{
    private $data;
    private $code;
    private $limit = 20;

    public function get(array $data)
    {
        $currentPage = array_has($data, 'page') ? (int)$data['page'] : 1;
        $currentTake = ($currentPage - 1) * $this->limit;
        unset($data['page']);

        $query = $this->getArticleQuery($data);

        $articles = app('db')->select($query, [$currentTake, $this->limit]);

        $total = app('db')->select('SELECT count(*) as total FROM articles');
        $totalPages = ceil($total[0]->total / $this->limit);
        $firstPage = 1;
        $lastPage = $totalPages;
        $nextPage = ($currentPage < $lastPage) ? $currentPage + 1 : null;

        $this->data = [
            'data' => $articles,
            'meta' => [
                'total_pages' => $totalPages,
                'current_page' => $currentPage,
                'first_page' => $firstPage,
                'next_page' => $nextPage
            ]
        ];
        $this->code = 200;

        return $this;
    }

    public function getById($id)
    {
        $article = app('db')->select('SELECT id, title, description, content, tags, created_at, updated_at
                                            FROM articles
                                            WHERE id = ?
                                            AND archived_at IS NULL', [$id]);

        $this->data = [
            'data' => $article
        ];
        $this->code = 200;

        return $this;
    }

    public function create(array $data)
    {
        $tags = explode(',', preg_replace("/ /", "", $data['tags']));
        $uuid = Uuid::uuid4()->toString();
        app('db')->insert('INSERT INTO articles (id, title, description, content, tags, created_at, updated_at)
                                VALUES (?, ?, ?, ?, ?, ?, ?)', [
            $uuid,
            $data['title'],
            $data['description'],
            $data['content'],
            json_encode($tags),
            date_create(),
            date_create()
        ]);

        $article = app('db')->select('SELECT id, title, description, content, tags, created_at, updated_at
                                            FROM articles
                                            WHERE id = ?', [$uuid]);

        $this->data = [
            'data' => $article[0]
        ];
        $this->code = 201;

        return $this;
    }

    public function update($id, array $data)
    {
        $fields = array_keys($data);
        $query = 'UPDATE articles SET ';

        foreach ($fields as $field) {
            $query .=  "{$field} = '{$data[$field]}', ";
        }
        $query = rtrim($query, ', ');
        $query .= ', updated_at = ? WHERE id = ?';

        app('db')->update($query, [date_create(), $id]);

        $article = app('db')->select('SELECT id, title, description, content, tags, created_at, updated_at
                                            FROM articles
                                            WHERE id = ?', [$id]);

        $this->data = [
            'data' => $article[0]
        ];
        $this->code = 200;

        return $this;
    }

    public function delete($id)
    {
        app('db')->delete('UPDATE articles SET archived_at = ? WHERE id = ?', [date_create(), $id]);

        $this->data = [];
        $this->code = 204;

        return $this;
    }

    public function json()
    {
        return response()->json($this->data, $this->code);
    }

    private function getArticleQuery($data)
    {
        $query = 'SELECT id, title, description, content, tags, created_at, updated_at
                                            FROM articles
                                            WHERE archived_at IS NULL ';

        foreach ($data as $key => $datum) {
            if ($key == 'tags') {
                $tags = explode(',', str_replace(', ', ',', $datum));
                $tags = json_encode($tags);

                $query .= "AND json_contains({$key}, '{$tags}') ";
            } else {
                $query .= "AND {$key} LIKE '%{$datum}%' ";
            }
        }

        $query .= 'ORDER BY id ASC LIMIT ?, ?';

        return $query;
    }
}
