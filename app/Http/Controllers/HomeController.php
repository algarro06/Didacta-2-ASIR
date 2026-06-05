<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->id_role, [1, 2])) {
            $courses = Course::all();
        } else {
            $courses = $user->courses;
        }

        return view('principal', compact('courses'));
    }
}