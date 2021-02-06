@extends('employees.shell')

@section('main')
<div class="card">
	<div class="card-header">
		{{ __('Employees') }}
	</div>
	<div class="card-body">
		@include('employees.messages')
		@include('employees.view-list', [ 'route_show' => 'employees.show' ])
	</div>
</div>
@endsection

{{-- vim: set ts=2 noexpandtab syntax=php: --}}
