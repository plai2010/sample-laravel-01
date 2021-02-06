@extends('employees.shell')

@section('main')
<div class="card">
	<div class="card-header">
		{{ __('Employee') }} #{{ $employee->id }}
	</div>

	<div class="card-body">
		@include('employees.messages')
		@include('employees/edit-form', [
			'emp' => $employee,
			'formActionUrl' => route('employees.update',  [
				'employee' => $employee->id,
			]),
			'formMethod' => 'PUT',
			'formSubmitLabel' => __('Update'),
			'readOnly' => false,
		])
	</div>
</div>
@endsection

{{-- vim: set ts=2 noexpandtab syntax=php: --}}
