@extends('layouts.app')

@section('content')
	@include('partials.post', ['post' => $post])
@endsection
