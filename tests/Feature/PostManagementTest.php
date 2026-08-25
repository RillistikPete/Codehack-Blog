<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_create_a_post(): void
    {
        $admin    = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $this->actingAs($admin)
            ->post('/admin/posts', [
                'title'       => 'Fixing Swagger in .NET 10',
                'category_id' => $category->id,
                'body'        => 'The `AddSecurityRequirement` signature changed.',
            ])
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'title'   => 'Fixing Swagger in .NET 10',
            'user_id' => $admin->id,
        ]);
    }

    public function test_creating_a_post_generates_a_slug(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post('/admin/posts', [
            'title'       => 'Fixing Swagger in .NET 10',
            'category_id' => Category::factory()->create()->id,
            'body'        => 'Body text.',
        ]);

        $this->assertSame('fixing-swagger-in-net-10', Post::first()->slug);
    }

    public function test_a_post_requires_a_title_and_body(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/posts', ['category_id' => Category::factory()->create()->id])
            ->assertSessionHasErrors(['title', 'body']);

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_an_uploaded_photo_is_stored_and_linked(): void
    {
        Storage::fake('s3');

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post('/admin/posts', [
            'title'       => 'Post With Photo',
            'category_id' => Category::factory()->create()->id,
            'body'        => 'Body text.',
            'photo_id'    => UploadedFile::fake()->image('My Photo #2.jpg'),
        ]);

        $post = Post::first();

        $this->assertNotNull($post->photo_id);

        // filename must be slugged - no spaces or hashes in the S3 key
        $this->assertSame('my-photo-2.jpg', $post->photo->file);
        Storage::disk('s3')->assertExists('my-photo-2.jpg');
    }

    public function test_the_public_post_page_renders_markdown(): void
    {
        $post = Post::factory()->create([
            'title' => 'Markdown Test',
            'body'  => "## A heading\n\nSome **bold** text.",
        ]);

        $this->get(route('home.post', $post->slug))
            ->assertOk()
            ->assertSee('<h2>A heading</h2>', false)
            ->assertSee('<strong>bold</strong>', false);
    }

    public function test_raw_html_in_a_post_body_is_stripped(): void
    {
        $post = Post::factory()->create([
            'body' => 'Hello <script>alert("xss")</script> world.',
        ]);

        $this->assertStringNotContainsString('<script>', $post->body_html);
        $this->assertStringContainsString('Hello', $post->body_html);
    }

    public function test_an_unknown_slug_returns_404(): void
    {
        $this->get('/post/does-not-exist')->assertNotFound();
    }
}