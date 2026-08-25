<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentModerationTest extends TestCase
{
    use RefreshDatabase;

    private function subscriber(): User
    {
        return User::factory()->create([
            'role_id'   => Role::factory()->create(['name' => 'subscriber'])->id,
            'is_active' => 1,
        ]);
    }

    public function test_guests_cannot_post_comments(): void
    {
        $post = Post::factory()->create();

        $this->post(route('comments.store', $post->id), ['body' => 'Spam'])
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_a_comment_from_a_subscriber_awaits_moderation(): void
    {
        $post = Post::factory()->create();

        $this->actingAs($this->subscriber())
            ->post(route('comments.store', $post->id), ['body' => 'Nice post']);

        $this->assertDatabaseHas('comments', [
            'post_id'   => $post->id,
            'body'      => 'Nice post',
            'is_active' => 0,
        ]);
    }

    public function test_a_comment_from_an_admin_is_published_immediately(): void
    {
        $post = Post::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('comments.store', $post->id), ['body' => 'Thanks!']);

        $this->assertDatabaseHas('comments', [
            'body'      => 'Thanks!',
            'is_active' => 1,
        ]);
    }

    /**
     * post_id comes from the route and the relationship, never from user input,
     * so a forged field in the request body must be ignored.
     */
    public function test_post_id_cannot_be_forged_through_the_request(): void
    {
        $target = Post::factory()->create();
        $other  = Post::factory()->create();

        $this->actingAs($this->subscriber())
            ->post(route('comments.store', $target->id), [
                'body'    => 'Forged',
                'post_id' => $other->id,
            ]);

        $this->assertDatabaseHas('comments', [
            'body'    => 'Forged',
            'post_id' => $target->id,
        ]);
    }

    public function test_a_comment_requires_a_body(): void
    {
        $post = Post::factory()->create();

        $this->actingAs($this->subscriber())
            ->post(route('comments.store', $post->id), ['body' => ''])
            ->assertSessionHasErrors('body');
    }

    public function test_an_admin_can_approve_a_comment(): void
    {
        $comment = Comment::factory()->create(['is_active' => 0]);

        $this->actingAs(User::factory()->admin()->create())
            ->patch(route('comments.update', $comment->id), ['is_active' => 1]);

        $this->assertDatabaseHas('comments', [
            'id'        => $comment->id,
            'is_active' => 1,
        ]);
    }

    /**
     * The approve/disapprove endpoint must not double as a content editor
     * for fields it wasn't given.
     */
    public function test_approving_a_comment_cannot_rewrite_its_author(): void
    {
        $comment = Comment::factory()->create([
            'author'    => 'Real Author',
            'is_active' => 0,
        ]);

        $this->actingAs(User::factory()->admin()->create())
            ->patch(route('comments.update', $comment->id), [
                'is_active' => 1,
                'post_id'   => Post::factory()->create()->id,
            ]);

        $this->assertDatabaseHas('comments', [
            'id'      => $comment->id,
            'author'  => 'Real Author',
            'post_id' => $comment->post_id,
        ]);
    }

    public function test_only_approved_comments_appear_on_the_post_page(): void
    {
        $post = Post::factory()->create();

        Comment::factory()->approved()->create([
            'post_id' => $post->id,
            'body'    => 'Approved comment',
        ]);

        Comment::factory()->create([
            'post_id' => $post->id,
            'body'    => 'Pending comment',
        ]);

        $this->get(route('home.post', $post->slug))
            ->assertSee('Approved comment')
            ->assertDontSee('Pending comment');
    }
}