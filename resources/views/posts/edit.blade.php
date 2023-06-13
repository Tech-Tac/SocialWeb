@extends('layouts.app')

@section('content')
	@include('partials.new_post', ['post' => $post, 'group' => $post->group])
@endsection
