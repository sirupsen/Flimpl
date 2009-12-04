<?php
/*
 *
 * Validation class, here in order to make server-side
 * validation easier.
 *
 */

class Validation {
    // Wielding all errors
	public $errors = array();
    // Wielding all rules as well as their arguments
	public $rules;

    // Wielding the input
	public $input;

	public function __construct($input) {
        // Set input
		$this->input = $input;
	}

	public function addRule($field, $rules) {
		// Get all rules
		$rules = func_get_args();
		// Slice them up
		$rules = array_slice($rules, 1);

		// For each of our rules, add it to our rule variable
		foreach ($rules as $rule) {
            // Add the rule with it's arguments
			$this->rules[$field][] = $rule;
		}
	}

	public function validate() {
        // Foreach of the fields [Username]
		foreach ($this->rules as $key => $rules) {
            // For each of the rules for this field [Length]
			foreach ($rules as $rule) {
                // If the function returns false, 
				if(!call_user_func(array('Valid', $rule), $this->input[$key])) {
                    // Add the error with key as name of rule value are arguments
					$this->errors[$key][] = $rule;
				}
			}
		}

        // Return true if there are no errors
		return $this->errors === array();
	}
}
