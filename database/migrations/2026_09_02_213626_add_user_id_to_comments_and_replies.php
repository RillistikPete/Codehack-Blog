<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('post_id')
              ->constrained()->nullOnDelete();
        });
        Schema::table('comment_replies', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('comment_id')
                ->constrained()->nullOnDelete();
        });

        // backfill existing rows by matching the stored email
        if (DB::getDriverName() === 'pgsql') { // SQLite in memory, and update...from isn't portable
            DB::statement('UPDATE comments c SET user_id = u.id FROM users u WHERE u.email = c.email');
            DB::statement('UPDATE comment_replies r SET user_id = u.id FROM users u WHERE u.email = r.email');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // must come before drop column
            $table->dropColumn('user_id');
        });

        Schema::table('comment_replies', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
