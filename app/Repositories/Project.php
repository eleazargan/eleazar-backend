<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CRUDInterface;
use App\Repositories\Interfaces\ResponseInterface;
use Ramsey\Uuid\Uuid;

class Project implements CRUDInterface, ResponseInterface
{
    private $data;
    private $code;
    private $limit = 20;

    public function get(array $data)
    {
        $currentPage = array_has($data, 'page') ? (int)$data['page'] : 1;
        $currentTake = ($currentPage - 1) * $this->limit;

        $projects = app('db')->select('SELECT id, title, description, repo_url, demo_url, created_at, updated_at
                                            FROM projects
                                            WHERE deleted_at IS NULL
                                            ORDER BY id
                                            ASC LIMIT ?, ?', [$currentTake, $this->limit]);

        $total = app('db')->select('SELECT count(*) as total FROM projects');
        $totalPages = ceil($total[0]->total / $this->limit);
        $firstPage = 1;
        $lastPage = $totalPages;
        $nextPage = ($currentPage < $lastPage) ? $currentPage + 1 : null;

        $this->data = [
            'data' => $projects,
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
        $project = app('db')->select('SELECT id, title, description, repo_url, demo_url, created_at, updated_at
                                            FROM projects
                                            WHERE id = ?
                                            AND deleted_at IS NULL', [$id]);

        $this->data = [
            'data' => $project
        ];
        $this->code = 200;

        return $this;
    }

    public function create(array $data)
    {
        $uuid = Uuid::uuid4()->toString();
        app('db')->insert('INSERT INTO projects (id, title, description, repo_url, demo_url, created_at, updated_at)
                                VALUES (?, ?, ?, ?, ?, ?, ?)', [
            $uuid,
            $data['title'],
            $data['description'],
            $data['repo_url'],
            $data['demo_url'],
            date_create(),
            date_create()
        ]);

        $project = app('db')->select('SELECT id, title, description, repo_url, demo_url, created_at, updated_at
                                            FROM projects
                                            WHERE id = ?', [$uuid]);

        $this->data = [
            'data' => $project[0]
        ];
        $this->code = 201;

        return $this;
    }

    public function update($id, array $data)
    {
        $fields = array_keys($data);
        $query = 'UPDATE projects SET ';

        foreach ($fields as $field) {
            $query .= $field . " = '{$data[$field]}', ";
        }
        $query = rtrim($query, ', ');
        $query .= ', updated_at = ? WHERE id = ?';

        app('db')->update($query, [date_create(), $id]);

        $project = app('db')->select('SELECT id, title, description, repo_url, demo_url, created_at, updated_at
                                            FROM projects
                                            WHERE id = ?', [$id]);

        $this->data = [
            'data' => $project[0]
        ];
        $this->code = 200;

        return $this;
    }

    public function delete($id)
    {
        app('db')->delete('UPDATE projects SET deleted_at = ? WHERE id = ?', [date_create(), $id]);

        $this->data = [];
        $this->code = 204;

        return $this;
    }

    public function json()
    {
        return response()->json($this->data, $this->code);
    }
}
