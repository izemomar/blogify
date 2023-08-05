<?php

namespace Tests\Feature\Api\V1;

use App\Enums\ArticleStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;

class ArticleControllerTest extends TestCase
{
    /**
     * @description Test it prevent creating an article with invalid data
     */
    public function test_it_prevent_creating_an_article_with_invalid_data()
    {
        $data = [
            'title' => '',
            'content' => '',
            'summary' => '',
            'image' => '',
            'status' => '',
        ];

        $response = $this->postJson("/api/v1/articles", $data);

        $response->assertStatus(422);

        $response->assertJson(
            fn (AssertableJson $json) => $json
                ->has('errors')
                ->etc()
        );
    }

    public function test_it_can_create_an_article()
    {
        $data = [
            'title' => 'Test title',
            'content' => 'Test content',
            'summary' => 'Test summary',
            'image' => UploadedFile::fake()->image('test.jpg'),
            'status' => ArticleStatusEnum::DRAFT,
        ];

        $response = $this->postJson("/api/v1/articles", $data);

        $response->assertStatus(201);

        $response->assertJson(
            fn (AssertableJson $json) => $json
                ->where('data.title', $data['title'])
                ->where('data.content', $data['content'])
                ->where('data.summary', $data['summary'])
                ->where('data.status', $data['status'])
                ->has('data.image')
                ->has('data.metas')
                ->etc()
        );
    }

    public function test_it_can_get_article_by_id()
    {
        $article = \App\Models\Api\V1\Article::factory()->create();

        $response = $this->getJson("/api/v1/articles/{$article->id}");

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) => $json
                ->where('data.title', $article->title)
                ->where('data.content', $article->content)
                ->where('data.summary', $article->summary)
                ->where('data.status', $article->status)
                ->has('data.image')
                ->has('data.metas')
                ->etc()
        );
    }
}
