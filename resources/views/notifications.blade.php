@extends('layouts.app')
@php
  $templates = [
      'post_like' => ['icon' => 'heart-fill', 'link' => fn($t) => route('posts.show', $t), 'text' => fn($s, $t) => "$s liked your post \"$t->title\""],
      'comment_like' => ['icon' => 'heart-fill', 'link' => fn($t) => route('comments.show', $t), 'text' => fn($s, $t) => "$s liked your comment \"$t->content\""],
      'comment' => ['icon' => 'chat-square-fill', 'link' => fn($t) => route('comments.show', $t), 'text' => fn($s, $t) => "$s commented \"$t->content\" on your post \"" . $t->post->title . '"'],
      'reply' => ['icon' => 'chat-square-quote-fill', 'link' => fn($t) => route('comments.show', $t), 'text' => fn($s, $t) => "$s replied \"$t->content\" to your comment \"" . $t->comment->content . '"'],
      'friend_request' => ['icon' => 'person-plus-fill', 'link' => fn($t) => route('users.show', $t), 'text' => fn($s, $t) => "$s sent you a friend request"],
      'friend_accept' => ['icon' => 'person-check-fill', 'link' => fn($t) => route('users.show', $t), 'text' => fn($s, $t) => "$s accepted your friend request"],
      'invite' => ['icon' => 'reply-fill', 'link' => fn($t) => route('groups.show', $t), 'text' => fn($s, $t) => "$s invited you to join \"$t->name\""],
  ];
@endphp
@section('content')
  <h1>Notifications</h1>
  <br>
  @foreach ($notifications as $notification)
    <a id="notification_{{ $notification->id }}"
      class="card notification mb-3 text-decoration-none {{ $notification->unread ? 'border-info' : '' }}"
      href="{{ $templates[$notification->type]['link']($notification->target) }}">
      <div class="card-body row">
        <div class="col-auto">
          <i class="fs-1 mx-3 bi bi-{{ $templates[$notification->type]['icon'] }}"></i>
        </div>
        <div class="col">
          <h5 class="card-title">
            {{ $templates[$notification->type]['text']($notification->sender->name, $notification->target) }}
          </h5>
          <time class="card-text" title="{{ $notification->created_at }}"
            datetime="{{ $notification->created_at }}">{{ $notification->created_at->diffForHumans() }}</time>
        </div>
      </div>
    </a>

    @php
      if ($notification->unread) {
          $notification->update(['unread' => false]);
      }
    @endphp
  @endforeach
@endsection
