@foreach ($errors->all() as $err)
	<div class="alert alert-danger">{{ $err }}</div>
@endforeach
@if (session('employee-status'))
	<div class="alert alert-success" role="alert">
		{{ session('employee-status') }}
	</div>
@endif

{{-- vim: set ts=2 noexpandtab syntax=php: --}}
