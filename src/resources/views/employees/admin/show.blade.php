@extends('employees.shell')

@section('main')
<div class="card">
	<div class="card-header">
		{{ __('Employee') }} #{{ $employee->id }}
	</div>

	<div class="card-body">
		@include('employees.messages')
		{{-- Just use edit form to show the data. --}}
		@include('employees.view-form', [ 'emp' => $employee ])
		<div class="row float-left pl-3">
			{{-- Admin has edit/delete buttons. --}}
      <form action="{{ route('employees.edit',['employee'=>$employee->id]) }}" method="GET">
        <button type="submit" class="btn btn-sm btn-primary mr-2">
          {{ __('Edit') }}
        </button>
      </form>
      <form action="{{ route('employees.destroy',['employee'=>$employee->id]) }}" method="POST">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-sm btn-primary btn-danger mr-2"
          onclick="return confirm({{ json_encode(__('Delete employee?')) }})"
        >{{ __('Delete') }}</button>
      </form>
			<button type="button" class="btn btn-sm btn-primary mr-2"
				onclick="window.history.back()"
			>{{ __('Back') }}</button>
		</div>
	</div>
</div>
@endsection

{{-- vim: set ts=2 noexpandtab syntax=php: --}}
