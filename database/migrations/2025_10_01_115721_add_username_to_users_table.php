<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;
   use App\Models\User;
   use Illuminate\Support\Str;

   return new class extends Migration
   {
       public function up(): void
       {
           // Пропускаем создание столбца, если он уже есть
           if (!Schema::hasColumn('users', 'username')) {
               Schema::table('users', function (Blueprint $table) {
                   $table->string('username', 20)->nullable()->after('name');
               });
           }

           // Заполняем username для пользователей с NULL или пустыми строками
           $users = User::whereNull('username')->orWhere('username', '')->get();
           foreach ($users as $index => $user) {
               $baseUsername = Str::slug($user->name, '') ?: 'user';
               $username = $baseUsername;
               $counter = $index + 1;

               while (User::where('username', $username)->exists()) {
                   $username = $baseUsername . $counter;
                   $counter++;
               }

               $user->username = $username;
               $user->save();
           }

           // Добавляем уникальный индекс и делаем not nullable
           Schema::table('users', function (Blueprint $table) {
               $table->string('username', 20)->nullable(false)->unique()->change();
           });
       }

       public function down(): void
       {
           Schema::table('users', function (Blueprint $table) {
               $table->dropUnique(['username']);
               $table->dropColumn('username');
           });
       }
   };