<?php

namespace Tests\Unit;

use App\Models\Post;
use Tests\TestCase;

class PostMarkdownTest extends TestCase
{
    public function test_raw_html_is_stripped_from_the_body(): void
    {
        $post = new Post(['body' => 'Hello <script>alert("xss")</script> world.']);

        $this->assertStringNotContainsString('<script>', $post->body_html);
        $this->assertStringContainsString('Hello', $post->body_html);
    }

    public function test_fenced_code_blocks_render_with_a_language_class(): void
    {
        $post = new Post(['body' => "```csharp\nvar x = 1;\n```"]);

        $this->assertStringContainsString('language-csharp', $post->body_html);
    }

    public function test_the_excerpt_strips_markup_and_truncates(): void
    {
        $post = new Post(['body' => str_repeat('word ', 200)]);

        $this->assertStringNotContainsString('<p>', $post->excerpt);
        $this->assertLessThanOrEqual(303, strlen($post->excerpt));
    }
}