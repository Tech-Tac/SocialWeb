@extends('layouts.app')

@section('content')
	@include('partials.post_form', ['post' => $post, 'group' => $post->group])
@endsection
