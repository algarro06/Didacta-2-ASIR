@extends('layouts.didacta')

@section('content')

<h1 class="titulo forum-anim" style="text-align:center;">
    {{ $category->name }}
</h1>

<a href="{{ route('community.topic.create', $category->id) }}" class="forum-button forum-anim">
    + Crear nuevo tema
</a>

@foreach($topics as $topic)
    <a href="{{ route('community.topic', $topic->id) }}" 
       class="forum-card forum-anim"
       style="display:block; text-decoration:none; color:inherit;">

        <h3 style="font-weight:700;">📝 {{ $topic->title }}</h3>
        <p style="margin-top:8px;">Creado por: <strong>{{ $topic->user->name }}</strong></p>

    </a>
@endforeach

@endsection
