<form action="{{ route(Route::currentRouteName()) }}" method="GET">
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label>{{ __('Last Name') }}</label>
				<input type="text" class="form-control"
					name="last_name" value="{{ $last_name ?? null }}"
				>
			</div>
		</div>
		<div class="col">
			<div class="form-group">
				<label>{{ __('First Name') }}</label>
				<input type="text" class="form-control"
					name="first_name" value="{{ $first_name ?? null }}"
				>
			</div>
		</div>
	</div>
	<div>
		<div class="float-left">
			{{ $employees->links() }}
		</div>
		<div class="float-right pb-3">
			<button type="submit" class="btn btn-primary">{{ __('Find') }}</button>
		</div>
	</div>
</form>
<table class="table table-sm mt-3">
	@forelse ($employees as $emp)
	<tr>
		<td>
			<a href="{{ route($route_show, ['employee'=>$emp->id]) }}">
				#{{ $emp->id }}
			</a>
		</td>
		<td>
			{{ $emp->last_name }}, {{ $emp->first_name }}
		</td>
	</tr>
	@empty
	<tr>
		<td colspan="2">{{ __('No match.') }}</td>
	</tr>
	@endforelse
</table>

{{-- vim: set ts=2 noexpandtab syntax=php: --}}
