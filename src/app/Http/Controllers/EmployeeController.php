<?php
namespace App\Http\Controllers;

use App\Employee;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Session;

class EmployeeController extends Controller
{
	/** Basic input validation rules. */
	const INPUT_RULES = [
		'name_prefix' => 'required|string|max:7',
		'first_name' => 'required|string|max:255',
		'middle_initial' => 'nullable|string|max:1',
		'last_name' => 'required|string|max:255',
		'gender' => 'required|in:M,F',
		'email' => 'required|email',
		'fathers_name' => 'required|string|max:255',
		'mothers_name' => 'required|string|max:255',
		'mothers_maiden_name' => 'required|string|max:255',
		'date_of_birth' => 'required|date',
		'date_of_joining' => 'required|date',
		'salary' =>  'required|numeric|min:1',
		'ssn' =>  'required|regex:/^[0-9]{3}-[0-9]{2}-[0-9]{4}$/',
		'phone_no' =>  'required|regex:/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/',
		'city' =>  'required|string|max:255',
		'state' =>  'required|string|max:2',
		'zip' => 'required|regex:/^[0-9]{5}$/',
	];

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		/*
		// Middleware for auth set in routes, as the controller
		// is used for both web and API requests.
		$this->middleware('auth');
		$this->middleware('auth:admin')->except([
			'index',
			'show',
		]);
		*/
	}

	/**
	 * Get validation rules for storing a new employee.
	 * @return array
	 */
	private function getStoreValidation() {
		// Modify rules to ensure some unique attributes.
		$rules = static::INPUT_RULES;
		$rules['ssn'] .= "|unique:employees,ssn";
		$rules['email'] .= "|unique:employees,email";
		return $rules;
	}

	/**
	 * Get validation rules for updating an employee.
	 * @param int $id Employee ID.
	 * @return array
	 */
	private function getUpdateValidation($id) {
		// Modify rules to ensure some unique attributes.
		$rules = static::INPUT_RULES;
		$rules['ssn'] .= "|unique:employees,ssn,$id";
		$rules['email'] .= "|unique:employees,email,$id";
		return $rules;
	}

	/**
	 * Get validated attributes.
	 * For web request, validation exception is thrown on error. For
	 * API request, a 400 error response is produced.
	 * @param  \Illuminate\Http\Request  $req
	 * @param  string $rules
	 * @return array | object Attributes or error response.
	 */
	private function getValidatedAttrs($req, $rules) {
		if ($req->wantsJson()) {
			$attrs = $req->input('data');
			if (!$attrs || !is_array($attrs))
				return $this->badRequest();

			try {
				return validator()->validate($attrs, $rules);
			}
			catch (ValidationException $ex) {
				// Just return first error.
				$errors = $ex->errors();
				return $this->badRequest(reset($errors));
			}
		}
		else {
			return $req->validate($rules);
		}
	}

	/**
	 * Construct a 400 response with error message for API request.
	 * @param string $msg
	 */
	private function badRequest($msg=null) {
		return response()->json([
			'error' => $msg ? $msg : __('Invalid/malformed API request'),
		])->setStatusCode(400);
	}

	/**
	 * Construct error response when employee not found.
	 * @param  \Illuminate\Http\Request  $req
	 * @param  int $id ID of model not found.
	 * @param  string $redir View to redirect to for non-API request.
	 * @return \Illuminate\Http\Response
	 */
	private function notFound(Request $req, $id, $view=null) {
		$msg = __('app.not-found', [
			'model' => 'Employee',
			'id' => $id,
		]);

		if ($req->wantsJson()) {
			return response()->json([
				'error' => $msg,
			])->setStatusCode(404);
		}
		else {
			if ($view == '')
				$view = 'employees.index';
			return redirect()->route($view)->withErrors($msg);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $req
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $req)
	{
		$employees = $this->getPaginated($req, $params);

		if ($req->wantsJson())
			return response()->json($employees);

		$params['employees'] = $employees;
		return view('employees.index', $params);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('employees.create', [
			'employee' => new Employee,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $req
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $req)
	{
		$attrs = $this->getValidatedAttrs($req, $this->getStoreValidation());
		if (is_object($attrs))
			return $attrs;

		$employee = new Employee;
		$employee->fill($attrs);
		$employee->save();

		if (!$req->wantsJson())
			Session::flash('employee-status', __('Employee created.'));
		return $this->adminShow($req, $employee->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @param  \Illuminate\Http\Request  $req
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $req, int $id)
	{
		return $this->doShow($req, $id, 'employees.show', 'employees.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @param  \Illuminate\Http\Request  $req
	 * @param  string $view View to render for successful web request.
	 * @param  string $redir Route to redirect to for failure.
	 * @return \Illuminate\Http\Response
	 */
	private function doShow(Request $req, int $id, $view, $redir)
	{
		$employee = Employee::find($id);
		if (!$employee)
			return $this->notFound($req, $id, $redir);

		if ($req->wantsJson()) {
			return response()->json([
				'data' => $employee,
			]);
		}
		else {
			return view($view, [
				'employee' => $employee,
			]);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$employee = Employee::find($id);
		if (!$employee)
			return redirect()->route('employees.admin');

		return view('employees.edit', [
			'employee' => $employee,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $req
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $req, int $id)
	{
		$employee = Employee::find($id);
		if (!$employee)
			return $this->notFound($req, $id, 'employees.admin');

		$attrs = $this->getValidatedAttrs($req,$this->getUpdateValidation($id));
		if (is_object($attrs))
			return $attrs;

		$employee->fill($attrs);
		$employee->save();
		if (!$req->wantsJson())
			Session::flash('employee-status', __('Employee updated.'));
		return $this->adminShow($req, $id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request $req
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $req, int $id)
	{
		if (Employee::destroy($id) <= 0) {
			// Assume failure is due to 'not found'.
			return $this->notFound($req, $id, 'employees.admin');
		}

		if ($req->wantsJson()) {
			return response()->json([
				'deleted' => $id,
			]);
		}
		else {
			Session::flash('employee-status', __('Employee deleted.'));
			return redirect()->route('employees.admin');
		}
	}

	/**
	 * Get paginated employee result.
	 *
	 * @param  \Illuminate\Http\Request $req
	 * @param  int $pgsz Page size.
	 * @param  array &$params Search parameters.
	 * @return \Illuminate\Pagination\Paginator
	 */
	protected function getPaginated($req, &$params=null, $pgsz=10)
	{
		// Search/filter parameters.
		$params = $req->validate([
			'first_name' => 'nullable|string',
			'last_name' => 'nullable|string',
		]);

		$employees = Employee::query();

		// Prefix match.
		foreach ([
			'first_name',
			'last_name',
		] as $col) {
			if ($params[$col] ?? null) {
				$pattern = str_replace('%','\%', $params[$col]).'%';
				$employees = $employees->where($col, 'like', $pattern);
			}
		}

		$employees = $employees->orderBy('last_name')->orderBy('first_name');
		$paginator = $employees->simplePaginate($pgsz);
		if ($params)
			$paginator->appends($params);
		return $paginator;
	}

	/**
	 * Employee administration.
	 *
	 * @param  \Illuminate\Http\Request $req
	 * @return \Illuminate\Http\Response
	 */
	public function admin(Request $req)
	{
		$employees = $this->getPaginated($req, $params);

		$params['employees'] = $employees;
		return view('employees.admin.index', $params);
	}

	/**
	 * Show employee during administration.
	 *
	 * @param  \Illuminate\Http\Request $req
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function adminShow(Request $req, int $id)
	{
		return $this->doShow($req,$id,'employees.admin.show','employees.admin');
	}
}

// vim: set ts=4 noexpandtab syntax=php:
