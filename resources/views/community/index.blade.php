@extends('layouts.didacta')

@section('content')

<h1 class="titulo forum-anim" style="text-align:center;">Foro de la Comunidad</h1>


@foreach($categories as $cat)
    <a href="{{ route('community.category', $cat->id) }}" 
       class="forum-card forum-anim"
       style="display:block; text-decoration:none; color:inherit;">

        <h3 style="font-weight:700;">💬 {{ $cat->name }}</h3>
        <p style="margin-top:8px;">{{ $cat->description }}</p>

    </a>
@endforeach

@endsection
