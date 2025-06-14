 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->unsignedBigInteger('views')->default(0)->after('status');
        $table->unsignedInteger('sales')->default(0)->after('views');
        $table->decimal('revenue', 10, 2)->default(0.00)->after('sales');
        $table->decimal('conversionRate', 5, 2)->default(0.00)->after('revenue');
        $table->decimal('avgRating', 3, 2)->default(0.00)->after('conversionRate');
        $table->unsignedInteger('totalReviews')->default(0)->after('avgRating');
        $table->string('currency')->default('USD')->after('commission');
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn([
            'views',
            'sales',
            'revenue',
            'conversionRate',
            'avgRating',
            'totalReviews',
            'currency'
        ]);
    });
}

};
