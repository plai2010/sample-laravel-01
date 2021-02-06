@extends('employees.shell')

@section('main')
<div class="card">
	<div class="card-header">
		{{ __('Employee Admin') }}
	</div>
	<div class="card-body">
		@include('employees.messages')
		@include('employees.view-list', [ 'route_show' => 'employees.admin.show' ])
		<form action="{{ route('employees.create') }}" method="GET">
			<button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
		</form>
	</div>
</div>
@endsection

{{-- vim: set ts=2 noexpandtab syntax=php: --}}
