<?php
/*
 *
 * Validation class, simplifying the process of making
 * server-side validation
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

  public function addRules($field) {
    $this->rules = $field;
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
    return empty($this->errors);
  }
}
