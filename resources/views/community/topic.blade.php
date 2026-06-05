@extends('layouts.didacta')

@section('content')

<h1 class="titulo forum-anim" style="text-align:center;">
    {{ $topic->title }}
</h1>

@foreach($posts as $post)
    <div class="forum-card forum-anim">
        <p><strong>{{ $post->user->name }}:</strong></p>
        <p>{{ $post->content }}</p>
    </div>
@endforeach

<div class="forum-card forum-anim">
    <form action="{{ route('community.post.store', $topic->id) }}" method="POST">
        @csrf

        <textarea name="content" rows="4" placeholder="Escribe tu respuesta..."
                  style="width:100%; padding:12px; margin-bottom:12px; border-radius:10px;" required></textarea>

        <button class="forum-button">Responder</button>
    </form>
</div>

@endsection
