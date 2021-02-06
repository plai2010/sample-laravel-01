@extends('employees.shell')

@section('main')
<router-view :key="$route.fullPath"></router-view>
@endsection

{{-- vim: set ts=2 noexpandtab syntax=php: --}}
