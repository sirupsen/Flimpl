<?php

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
			// If the rule has an argument
			if (preg_match('/^([^\[]++)\[(.+)\]$/', $rule, $match)) {
				$rule = $match[1];
				// Get the argument
				$args = $args = preg_split('/(?<!\\\\),\s*/', $match[2]);

				// Replace escaped comma
				$args = str_replace('\,', ',', $args);
			}

            // Add the rule with it's arguments
			$this->rules[$field][] = array($rule, $args);
		}
	}

	public function validate() {
        // Foreach of the fields [I.e. Username]
		foreach ($this->rules as $key => $rules) {
            // For each of the rules for this field [Length]
			foreach ($rules as $rule) {
                // If the function returns false, 
				if(!call_user_func_array(array('Validators', $rule['0']), array($this->input[$key], $rule['1']))) {
                    // Add the error
					$this->errors[$rule['0']] = $rule['1'];
				}
			}
		}

        // Return true if there are no errors
		return $this->errors === array();
	}
}
