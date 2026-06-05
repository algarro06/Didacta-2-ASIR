<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumCategory;
use App\Models\ForumTopic;
use App\Models\ForumPost;

class ForumController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::all();
        return view('community.index', compact('categories'));
    }

    public function category($id)
    {
        $category = ForumCategory::findOrFail($id);
        $topics = ForumTopic::where('category_id', $id)
                            ->with('user')
                            ->latest()
                            ->get();

        return view('community.topics', compact('category', 'topics'));
    }

    public function topic($id)
    {
        $topic = ForumTopic::with(['user', 'posts.user'])->findOrFail($id);
        $posts = $topic->posts;

        return view('community.topic', compact('topic', 'posts'));
    }

    public function createTopic($category_id)
    {
        $category = ForumCategory::findOrFail($category_id);
        return view('community.create-topic', compact('category'));
    }

    public function storeTopic(Request $request, $category_id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $topic = ForumTopic::create([
            'category_id' => $category_id,
            'user_id' => auth()->id(),
            'title' => $request->title,
        ]);

        ForumPost::create([
            'topic_id' => $topic->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('community.topic', $topic->id);
    }

    public function storePost(Request $request, $topic_id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        ForumPost::create([
            'topic_id' => $topic_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back();
    }
}
