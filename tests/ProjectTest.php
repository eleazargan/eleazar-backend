<?php


use App\Models\Project;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Ramsey\Uuid\Uuid;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetArticles()
    {
        $this->projects();
        $this->get('projects');

        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'id',
                    'title',
                    'description',
                    'repo_url',
                    'demo_url',
                    'created_at',
                    'updated_at'
                ]
            ],
            'meta' => [
                'total_pages',
                'current_page',
                'first_page',
                'next_page'
            ]
        ]);
    }

    public function testGetArticlesFromValidPage()
    {
        $this->projects();
        $this->get('projects?page=1');

        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'id',
                    'title',
                    'description',
                    'repo_url',
                    'demo_url',
                    'created_at',
                    'updated_at'
                ]
            ],
            'meta' => [
                'total_pages',
                'current_page',
                'first_page',
                'next_page'
            ]
        ]);
    }

    public function testGetProjectsFromInvalidPage()
    {
        $this->projects();
        $this->get('projects?page=100');

        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [],
            'meta' => [
                'total_pages',
                'current_page',
                'first_page',
                'next_page'
            ]
        ]);
    }

    public function testCreateProject()
    {
        $parameters = [
            'title' => 'Test Project',
            'description' => 'Test Description',
            'repo_url' => 'http://asas.com/arer-rerer',
            'demo_url' => 'http://asas.com/arer-rerer'
        ];

        $this->post('projects', $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJsonStructure(
            ['data' => [
                'id',
                'title',
                'description',
                'repo_url',
                'demo_url',
                'created_at',
                'updated_at'
            ]
            ]
        );
    }

    public function projects()
    {
        return factory(Project::class, 20)->create();
    }

}
