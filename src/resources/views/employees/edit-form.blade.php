<form action="{{ $formActionUrl }}" method="POST">
	@csrf
	@if ($formMethod ?? null)
		@method($formMethod)
	@endif
	<div class="form-group mb-0">
		<label>{{ __('Name/Identity') }}</label>
	</div>
	<div class="form-inline">
		<div class="form-group">
			<label class="sr-only">{{ __('Name Prefix') }}</label>
			<input type="text" size="5" class="form-control mb-2 mr-sm-2"
				name="name_prefix" value="{{ old('name_prefix', $emp->name_prefix) }}"
				title="{{ __('Prefix (e.g. \'Mr.\')') }}" placeholder="{{ __('Mr.') }}"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
		<div class="form-group">
			<label class="sr-only">{{ __('First Name') }}</label>
			<input type="text" class="form-control mb-2 mr-sm-2"
				name="first_name" value="{{ old('first_name', $emp->first_name) }}"
				title="{{ __('First name') }}" placeholder="John"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
		<div class="form-group">
			<label class="sr-only">{{ __('Middle Initial') }}</label>
			<input type="text" size="1" class="form-control mb-2 mr-sm-2"
				name="middle_initial"
				value="{{ old('middle_initial', $emp->middle_initial) }}"
				title="{{ __('Middle initial') }}" placeholder="F"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
		<div class="form-group">
			<label class="sr-only">{{ __('Last Name') }}</label>
			<input type="text" class="form-control mb-2 mr-sm-2"
				name="last_name" value="{{ old('last_name', $emp->last_name) }}"
				title="{{ __('Last name') }}" placeholder="Kennedy"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
	</div>
	<div class="form-inline">
		<div class="form-group">
			<label class="sr-only">{{ __('Date of Birth') }}</label>
			<input type="date" class="form-control mb-2 mr-sm-2"
				name="date_of_birth"
				value="{{ old('date_of_birth', $emp->date_of_birth) }}"
				title="{{ __('Date of birth') }}" placeholder="10/31/1974"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
		<div class="form-group">
			<label class="sr-only">{{ __('Gender') }}</label>
			<select class="form-control mb-2 mr-sm-2" name="gender"
				title="{{ __('Gender M/F') }}"
				{{ $readOnly ? 'disabled' : '' }}>
				<option value=""></option>
				<option value="M"
					{{ old('gender', $emp->gender) == 'M' ? 'selected' : '' }}
				>M</option>
				<option value="F"
					{{ old('gender', $emp->gender) == 'F' ? 'selected' : '' }}
				>F</option>
			</select>
		</div>
		<div class="form-group">
			<label class="sr-only">{{ __('Social Security #') }}</label>
			<input type="text" class="form-control mb-2 mr-sm-2"
				name="ssn" value="{{ old('ssn', $emp->ssn) }}"
				title="{{ __('Social security number xxx-xx-xxxx') }}"
				placeholder="123-45-6789"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
	</div>
	<div class="form-group mb-0">
		<label>{{ __('HR Data') }}</label>
	</div>
	<div class="form-inline">
		<div class="form-group">
			<label class="sr-only">{{ __('Date of Joining') }}</label>
			<input type="date" class="form-control mb-2 mr-sm-2"
				name="date_of_joining"
				value="{{ old('date_of_joining', $emp->date_of_joining) }}"
				title="{{ __('Date of joining') }}" placeholder="02/28/2005"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
		<div class="form-group">
			<label class="sr-only">{{ __('Salary') }}</label>
			<input type="number" class="form-control mb-2 mr-sm-2"
				name="salary" value="{{ old('salary', $emp->salary) }}"
				title="{{ __('Salary') }}" placeholder="120000"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
		</div>
		<div class="form-group mb-0">
			<label>{{ __('Address') }}</label>
	</div>
	<div class="form-inline">
		<div class="form-group">
			<label class="sr-only">{{ __('City') }}</label>
			<input type="text" class="form-control mb-2 mr-sm-2"
				name="city" value="{{ old('city', $emp->city) }}"
				title="{{ __('City') }}" placeholder="Pleasanton"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
		<div class="form-group">
			<label class="sr-only">{{ __('State') }}</label>
			<input type="text" size="2" class="form-control mb-2 mr-sm-2"
				name="state" value="{{ old('state', $emp->state) }}"
				title="{{ __('State') }}" placeholder="CA"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
		<div class="form-group">
			<label class="sr-only">{{ __('Zip') }}</label>
			<input type="text" size="5" class="form-control mb-2 mr-sm-2"
				name="zip" value="{{ old('zip', $emp->zip) }}"
				title="{{ __('Zip code') }}" placeholder="94566"
				{{ $readOnly ? 'disabled' : '' }}
			>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label>{{ __('Email') }}</label>
				<input type="email" class="form-control"
					name="email" value="{{ old('email', $emp->email) }}"
					title="{{ __('Email address') }}" placeholder="jfk@example.com"
					{{ $readOnly ? 'disabled' : '' }}
				>
			</div>
		</div>
		<div class="col">
			<div class="form-group">
				<label>{{ __('Phone #') }}</label>
				<input type="text" class="form-control"
					name="phone_no" value="{{ old('phone_no', $emp->phone_no) }}"
					title="{{ __('Phone # xxx-xxx-xxxx') }}" placeholder="844-332-3320"
					{{ $readOnly ? 'disabled' : '' }}
				>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label>{{ __('Father\'s Name') }}</label>
				<input type="text" class="form-control"
					name="fathers_name" value="{{old('fathers_name',$emp->fathers_name)}}"
					{{ $readOnly ? 'disabled' : '' }}
				>
			</div>
		</div>
		<div class="col">
			<div class="form-group">
				<label>{{ __('Mother\'s Name') }}</label>
				<input type="text" class="form-control"
					name="mothers_name" value="{{old('mothers_name',$emp->mothers_name)}}"
					{{ $readOnly ? 'disabled' : '' }}
				>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label>{{ __('Mother\'s Maiden Name') }}</label>
				<input type="text" class="form-control"
					name="mothers_maiden_name"
					value="{{ old('mothers_maiden_name', $emp->mothers_maiden_name) }}"
					{{ $readOnly ? 'disabled' : '' }}
				>
			</div>
		</div>
		<div class="col"></div>
	</div>

	@if (!$readOnly)
	{{-- Regular edit --}}
	<button type="submit" class="btn btn-sm btn-primary">
		{{ $formSubmitLabel ?? __('Save') }}
	</button>
	<button type="button" class="btn btn-sm btn-secondary"
		onclick="window.history.back()"
	>{{ __('Cancel') }}</button>
	@endif
</form>

{{-- vim: set ts=2 noexpandtab syntax=php: --}}
