<?php

namespace App;

use DateTime;

/**
 * Import employee records.
 */
class EmployeeImport
{
	/**
	 * Load employee records from CSV file.
	 * @param string $csvPath CSV file path.
	 * @param int $header Number of header lines to skip.
	 * @return int Number of employee records loaded.
	 */
	public static function loadCsv(string $csvPath, $header=1) {
		$csv = fopen($csvPath, 'r');
		if ($csv === false)
			return 0;

		// Skip header lines.
		while ($header > 0) {
			fgetcsv($csv);
			--$header;
		}

		// Columns by field numbers.
		// TODO: map CSV header to column
		$COLUMNS = [
			'id',
			'name_prefix',
			'first_name',
			'middle_initial',
			'last_name',
			'gender',
			'email',
			'fathers_name',
			'mothers_name',
			'mothers_maiden_name',
			'date_of_birth',
			'date_of_joining',
			'salary',
			'ssn',
			'phone_no',
			'city',
			'state',
			'zip',
		];

		// Load employee records.
		$count = 0;
		while (($rec = fgetcsv($csv)) !== false) {
			$emp = new Employee;
			foreach ($rec as $i => $value) {
				$col = $COLUMNS[$i];
				switch ($col) {
				case 'date_of_birth':
				case 'date_of_joining':
					$value = new DateTime($value);
					break;
				default:
					break;
				}
				$emp->$col = $value;
			}
			if ($emp->save())
				++$count;
		}

		fclose($csv);
		return $count;
	}
}

// vim: set ts=4 noexpandtab syntax=php:
