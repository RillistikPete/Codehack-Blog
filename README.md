# Codehack Blog

![tests](https://github.com/RillistikPete/Codehack-Blog/actions/workflows/tests.yml/badge.svg)

A publishing platform and CMS built with Laravel 12 — originally written on Laravel 5.7 in 2018 and brought forward seven major versions in 2026.

**Live:** [your-domain.com](https://your-domain.com)

<!-- Add 2-3 screenshots: home page, an article, the admin dashboard.
     Store them in docs/screenshots/ and reference them here. -->

---

## What it does

- **Markdown articles** with fenced code blocks, syntax highlighting, and server-side sanitisation
- **Comment threads** with replies, and a moderation queue — comments from non-admins are held for approval, admin comments publish immediately
- **Role-based admin panel** for posts, users, categories, media, and moderation
- **S3-backed media library** with orphan detection and bulk deletion
- **Contact form** protected by a honeypot and per-IP rate limiting

## Stack

| | |
|---|---|
| Framework | Laravel 12.4.1, PHP 8.5.0 |
| Database | PostgreSQL 18 |
| Auth | Laravel Fortify |
| Storage | AWS S3 (Flysystem) |
| Frontend | Blade, Bootstrap 3, Vite |
| Local env | Laravel Sail (Docker) |
| Testing | PHPUnit 11 |

Notable packages: [eloquent-sluggable](https://github.com/cviebrock/eloquent-sluggable) for RESTful URLs,
[laravel-honeypot](https://github.com/spatie/laravel-honeypot) for spam protection,
[league/commonmark](https://commonmark.thephpleague.com/) for Markdown rendering.

---

## Running it locally

Requires Docker.

```bash
git clone https://github.com/RillistikPete/codehack-blog.git
cd codehack-blog

cp .env.example .env
composer install
./vendor/bin/sail up -d
sail artisan key:generate
sail artisan migrate --seed
sail npm install && sail npm run build
```

The seeder creates the `administrator`, `author`, and `subscriber` roles plus an admin
account, and prints its password to the console. Set `SEED_ADMIN_PASSWORD` in `.env`
to choose your own.

Visit `http://localhost` (or whatever you set `APP_PORT` to).

### Environment

| Variable | Purpose |
|---|---|
| `DB_*` | PostgreSQL connection (Sail provides these by default) |
| `AWS_*` | S3 bucket for media uploads |
| `MAIL_CONTACT_TO` | Recipient for contact form submissions |
| `SEED_ADMIN_PASSWORD` | Optional — admin password used by the seeder |

Media uploads need a bucket with a public-read bucket policy. Without one, uploads
succeed but images return 403.

## Tests

```bash
sail artisan test
```

Feature tests run against an in-memory SQLite database, so no setup is needed.
They cover admin authorisation, post creation and slug generation, S3 upload
handling, Markdown rendering and HTML sanitisation, and the comment moderation
workflow.
Anyone who clones the repo runs sail artisan test and it works.
No second database to create, no CI service container to configure, no credentials.

If you're having trouble fixing failed tests, add this line at the top of the test:
$this->withoutExceptionHandling();
That will show the specific exception to help you debug.

---

## Implementation notes

A few decisions worth explaining, since they're the parts a reader might question.

**Markdown over WYSIWYG.** Articles are stored as Markdown and rendered with CommonMark
configured as `html_input => 'strip'`. Raw HTML in a post body is discarded rather than
escaped, which removes the stored-XSS surface entirely without a separate sanitiser.
The previous TinyMCE setup produced HTML that had to be trusted.

**Image URLs are derived, not stored.** `Post::getObjUrlAttribute()` returns the stored
`obj_url` if one exists and otherwise builds the S3 URL from the related photo.
`Storage::disk('s3')->url()` performs no network call — it composes a string from config —
so listing posts costs no S3 requests. The column remains as a per-post override.

**Foreign keys come from relationships, never from request input.** Comments are created
via `$post->comments()->create()`, which sets `post_id` from the route-bound model.
`post_id` is deliberately absent from `$fillable` so a forged form field cannot reattach
a comment to a different post. There's a regression test for this.

**Auth is Fortify, not scaffolding.** Registration assigns a fixed `subscriber` role
server-side; role and status are never read from request input, which would otherwise
allow privilege escalation through the registration form.

## Upgrading from Laravel 5.7

The framework upgrade was the easy half. The application code needed:

- Model references updated from `App\User` to `App\Models\User` — silent runtime failures, since the strings were only resolved when a relationship was touched
- The `Auth` scaffolding controllers removed; `AuthenticatesUsers` was dropped from the framework in Laravel 8, and controller-constructor middleware in Laravel 11
- All Blade forms converted from `laravelcollective/html` (abandoned, no Laravel 12 support) to plain HTML — 137 call sites across 15 views
- String controller actions (`'PostsController@store'`) replaced with named routes, removed in Laravel 8
- Migrations normalised to `bigint` keys with real foreign key constraints

## License

MIT
