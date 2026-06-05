@extends('layouts.didacta')

@section('content')

<h1 class="titulo forum-anim" style="text-align:center;">Crear nuevo tema</h1>

<div class="forum-card forum-anim">
    <form action="{{ route('community.topic.store', $category->id) }}" method="POST">
        @csrf

        <input type="text" name="title" placeholder="Título del tema"
               style="width:100%; padding:12px; margin-bottom:12px; border-radius:10px;" required>

        <textarea name="content" rows="4" placeholder="Primer mensaje"
                  style="width:100%; padding:12px; margin-bottom:12px; border-radius:10px;" required></textarea>

        <button class="forum-button">Crear tema</button>
    </form>
</div>

@endsection
