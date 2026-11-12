<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Optional locale of a redirect: on a site with one domain or prefix per locale, the same old path can lead to a
     * different page in each locale. A redirect without locale applies to every locale.
     */
    public function up(): void
    {
        Schema::table('redirects', function (Blueprint $table) {
            $table->string('locale', 20)->nullable()->after('id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('redirects', function (Blueprint $table) {
            $table->dropColumn('locale');
        });
    }
};
