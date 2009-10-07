<?php

/*
 * 
 * OOPS: This is FAR from done
 *
 */

class User {
    protected $registry;

    public function __construct() {
        $this->registry = Registry::getInstance();
	}

	public function register($user) {
		if (!isset($user)) throw new Exception("No information send");
		
		// Check if username length is 3 or more
		if (!isset($user['username'][2])) $errors['username'] = 'Username is required to be greater than two characters';

		if (isset($user['confirm_password'])) {
			if($user['password'] != $user['confirm_password'])
				$errors['passwords'] = 'Passwords doesn\'t match';
		}

		// Check if username only contains numbers and alphabetical characters
		if (!ctype_alnum($user['username'])) $errors['username_characters'] = 'Username must only contain numbers and alphabetical characters';

		// Requires the user to use a relatively strong password
		if (!isset($user['password'][4])) $errors['password'] = 'Your password is required to be more than 5 characters';

		// Checks if the email is valid with the validation function
		if (!Validate::email($user['email'])) $errors['email'] = 'Unvalid email';

		// No errors, register the user
		if (count($errors) == 0) {
			// To avoid any issues with more fields posted, we create
			// a new array for the new user
			$new_user = array(
				'username' => $user['username'],
				'password' => md5($user['password']),
				'email' => $user['email'],
				'time' => time()
			);

			if(!$this->registry->db->insert('users', $new_user))
				throw new Exception("Error creating user");

			return true;
		} else { ?>
			<ul id="errors"> 
			<?php foreach($errors as $key => $error) { ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
			</ul>
			<?php
		}
	}

	public function activate($hash) {
		$query = $this->registry->db->select('users', array('hash' => $hash));	
		if (!$hash)
			throw new Exception("No hash provided");

		if ($query->num_rows == 1) {
			$user = $query->fetch_assoc();

			if ($user['activated'] == 1) {
				throw new Exception("User already activated");
			}

			if (!$this->registry->db->update('users', array('activated' => 1), array('hash' => $hash)))
				throw new Exception("Not able to activate user, please try again");
			return $user['username'];
		} else {
			throw new Exception("No user with that activation code exists");
		}
	}
}
