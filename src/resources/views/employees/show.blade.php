@extends('employees.shell')

@section('main')
<div class="card">
	<div class="card-header">
		{{ __('Employee') }} #{{ $employee->id }}
	</div>

	<div class="card-body">
		@include('employees.messages')
		@include('employees.view-form', [ 'emp' => $employee ])
		<div class="row float-left pl-3">
			<button type="button" class="btn btn-sm btn-primary mr-2"
				onclick="window.history.back()"
			>{{ __('Back') }}</button>
		</div>
	</div>
</div>
@endsection

{{-- vim: set ts=2 noexpandtab syntax=php: --}}
