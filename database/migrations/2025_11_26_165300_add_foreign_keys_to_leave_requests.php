<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_foreign_keys_to_leave_requests.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            // Tambahkan semua foreign key di sini, setelah tabel pasti sudah ada
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('restrict');
            $table->foreign('leader_approver_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('hrd_approver_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['leave_type_id']);
            $table->dropForeign(['leader_approver_id']);
            $table->dropForeign(['hrd_approver_id']);
        });
    }
};
