@extends('employees.shell')

@section('main')
<div class="card">
	<div class="card-header">
		{{ __('New Employee') }}
	</div>

	<div class="card-body">
		@include('employees.messages')
		@include('employees/edit-form', [
			'emp' => $employee,
			'formActionUrl' => route('employees.store'),
			'formMethod' => 'POST',
			'formSubmitLabel' => __('Save'),
			'readOnly' => false,
		])
	</div>
</div>
@endsection

{{-- vim: set ts=2 noexpandtab syntax=php: --}}
