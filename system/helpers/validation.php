<?php

class Validation {
	public $errors = array();
	public $rules;

	public $input;

	public function __construct($input) {
		$this->input = $input;
	}

	public function addRule($field, $rules) {
		// Get all rules
		$rules = func_get_args();
		// Slice them up
		$rules = array_slice($rules, 1);

		// For each of our rules, add it to our rule variable
		foreach ($rules as $rule) {
			// If the rule has an argument
			if (preg_match('/^([^\[]++)\[(.+)\]$/', $rule, $match)) {
				$rule = $match[1];
				// Get the argument
				$args = $args = preg_split('/(?<!\\\\),\s*/', $match[2]);

				// Replace escaped comma
				$args = str_replace('\,', ',', $args);
			}

			$this->rules[$field][] = array($rule, $args);
		}
	}

	public function validate() {
		foreach ($this->rules as $key => $rules) {
			foreach ($rules as $rule) {
				if(!call_user_func_array(array('Validators', $rule['0']), array($this->input[$key], $rule['1']))) {

					$this->errors[$rule['0']] = $rule['1'];
				}
			}
		}

		return $this->errors === array();
	}
}
