@if ($message)
	@php
		$type = $type ?? 'primary';
	@endphp
	<div class="alert alert-{{ $type }}">
		{{ $message }}
	</div>
@endif
