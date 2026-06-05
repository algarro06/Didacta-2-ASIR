<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SectionController;
use App\Http\Middleware\EnsureUserIsAuthenticated;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/error', function () {
    return view('error');
})->name('error');
Route::get('/403', function () {
    return view('403');
})->name('403');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/home');
    }
    return redirect('/login');
});

Route::middleware([EnsureUserIsAuthenticated::class])->group(function () {

Route::get('/home', [HomeController::class, 'index']);

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
Route::delete('/courses/{id}/destroy', [CourseController::class, 'destroy'])->name('courses.destroy');
Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
Route::put('/courses/{id}/update', [CourseController::class, 'update'])->name('courses.update');
Route::get('/courses/{title}/students', [CourseController::class, 'students'])->name('courses.students');
Route::post('/courses/{title}/enroll', [CourseController::class, 'enrollStudent'])->name('courses.enroll');
Route::delete('/courses/{title}/remove/{userId}', [CourseController::class, 'removeStudent'])->name('courses.remove');
Route::get('/courses/{title}', [CourseController::class, 'show'])->name('courses.show');

Route::post('/courses/{courseId}/sections', [SectionController::class, 'storeSection'])->name('sections.store');
Route::delete('/sections/{sectionId}', [SectionController::class, 'destroySection'])->name('sections.destroy');
Route::post('/sections/{sectionId}/items', [SectionController::class, 'storeItem'])->name('items.store');
Route::get('/items/{itemId}/edit', [SectionController::class, 'editItem'])->name('items.edit');
Route::put('/items/{itemId}/update', [SectionController::class, 'updateItem'])->name('items.update');
Route::delete('/items/{itemId}', [SectionController::class, 'destroyItem'])->name('items.destroy');
Route::get('/items/{itemId}/task', [SectionController::class, 'showTask'])->name('items.task');
Route::post('/items/{itemId}/submit', [SectionController::class, 'submitTask'])->name('items.submit');
Route::get('/items/{itemId}/submissions', [SectionController::class, 'viewSubmissions'])->name('items.submissions');

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/day/{date}', [EventController::class, 'byDay']);
Route::get('/events/create/{date}', [EventController::class, 'create']);
Route::post('/events/store', [EventController::class, 'store']);
Route::delete('/events/delete/{id}', [EventController::class, 'destroy']);
Route::get('/events/edit/{id}', [EventController::class, 'edit']);
Route::put('/events/update/{id}', [EventController::class, 'update']);

Route::get('/news', function () {
    return view('news');
});


Route::get('/admin/users/create', [UserController::class, 'create']);
Route::post('/admin/users', [UserController::class, 'store']);

Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}/delete', [UserController::class, 'destroy'])->name('admin.users.delete');

Route::get('/community', [ForumController::class, 'index'])->name('community.index');
Route::get('/community/{id}', [ForumController::class, 'category'])->name('community.category');
Route::get('/community/topic/{id}', [ForumController::class, 'topic'])->name('community.topic');
Route::get('/community/{id}/topic/create', [ForumController::class, 'createTopic'])->name('community.topic.create');
Route::post('/community/{id}/topic/store', [ForumController::class, 'storeTopic'])->name('community.topic.store');
Route::post('/community/{id}/post/store', [ForumController::class, 'storePost'])->name('community.post.store');
});

use Illuminate\Support\Facades\Process;

Route::get('/probar-backup', function () {
    // Tus datos reales de Aiven mapeados en el comando
    $comando = 'mysqldump -h mysql-11f4bf50-pepito11ortiz-49e6.i.aivencloud.com -P 19185 -u avnadmin -pAVNS_6TysVsPqL3k1qI1_UcY --ssl-mode=REQUIRED --column-statistics=0 defaultdb';
    
    // Ejecutamos el comando dentro de Render
    $resultado = Process::run($comando);

    if ($resultado->successful()) {
        // Si funciona, nos va a pintar el código SQL directamente en la pantalla
        return response($resultado->output(), 200)
            ->header('Content-Type', 'text/plain');
    }

    // Si falla, nos mostrará el error exacto por pantalla
    return response("Error al hacer backup: " . $resultado->errorOutput(), 500);
});