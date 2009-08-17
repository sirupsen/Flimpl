<?php

/*
 *
 * The database class, it's used to connect to the database and perform
 * different actions on it.
 *
 * @date 	10. August, 2009
 *
 * @authors Macha, Sirupsen, Cwii
 *  
 */

class Database {

	public $mysqli;
	
	/*
	 *
	 * Constructer for the class which connects to the database, due to
	 * that the database would be usefull without having a connection.
	 *
	 * @parm 	string 	$host 	The host (f.e. localhost)
	 * @parm 	string 	$user 	The username (f.e. root)
	 * @parm 	string 	$password 	The password (f.e. password)
	 * @parm 	string 	$db 	The database used (f.e. database)
	 *
	 */

	public function __construct($host='localhost', $user='root', $password='', $db='db') {
		$this->mysqli = new Mysqli($host, $user, $password, $db);
	}

	/*
	 *
	 * Selects something from the database, and returns the query.
	 *
	 * @parm 	string 	$query 	The query to perform
	 * @return 	string 	$query 	The query
	 *
	 * @todo Make this class escape a condition array (key => value)
	 *
	 */

	public function select($query) {
		$query = $this->mysqli->query($query);

		if (!$query || !is_object($query))
			throw new Exception("Unable to select");

		return $query;
	}

	/*
	 *
	 * Selects something from the database, and returns the raw
	 * array. This is usefull for just dumping a query to the
	 * database without needing to modify the values.
	 *
	 * @parm 	string 	$query 	The query to perform
	 * @parm 	array 	$return The result array
	 *
	 * @todo 	Print a warning if there's no entries (by default
	 * it'll give a warning that foreach got a wrong condition)
	 *
	 */

	public function select_tpl($query) {
		$query = $this->mysqli->query($query);

		if (!$query || !is_object($query))
			throw new Exception("Unable to select_tpl");

		while ($row = $query->fetch_assoc()) {
			$return[] = $row;
		}

		return $return;
	}

	/*
	 *
	 * Inserts something into the database, and escapes the input
	 * by adding slashes.
	 *
	 * @parm 	string 	$table 	The table to perform the insert on (f.e. blog_posts)
	 * @parm 	array 	$data 	The actual data to insert as an array (column => value)
	 * @return 	integer $id 	The id of the newly inserted item (f.e. 8)
	 * 
	 */

	public function insert($table, $data) {
		if(empty($table))
			throw new Exception("No table defined for insert() @ Database");

		if(empty($data))
			throw new Exception("No data defined for insert() @ Database");

		foreach ($data as $key => $value) {
			$sets .= $key . " = ";

			if (is_null($value)) {
				$values .= 'NULL, ';
			}

			$value = addslashes($value);
			$sets .= "'" . $value . "', ";
		}
		$sets = rtrim($sets, ', ');

		$query = "INSERT INTO {$table} SET {$sets}";

		return $this->insertQuery($query);
	}

	/*
	 *
	 * Updates a database defined with the data provided in an array, at
	 * some given conditions.
	 *
	 * @parm 	string 	$table 	The table to perform the action on (f.e. articles)
	 * @parm 	array 	$data 	The columns in the row(s) to update (column => value)
	 * @parm 	array 	$conditions 	The conditions at which to update (column => value):w
	 * @return 	integer $affected_rows 	The amount of rows affected by the update
	 *
	 */

	public function update($table, $data, $conditions) {
		if(empty($table))
			throw new Exception("No table defined for insert() @ Database");

		if(empty($data))
			throw new Exception("Must data array to update function");

		if(empty($conditions))
			throw new Exception("Must pass conditions array to update function");

		// Builds a "key = value," string for each pair. 
		$sets = "";
		foreach ($data as $key => $value) {
			$sets .= $key . ' = ';

			if (is_null($value)) {
				$value = 'NULL, ';
			}

			$value = addslashes($value);
			$sets .= "'" . $value . "',";
		}

		foreach ($conditions as $key => $value) {
			$conditions_sql .= $key . ' = ';

			if (is_null($value)) {
				$value = 'NULL, ';
			}

			$value = addslashes($value);
			$conditions_sql .= "'" . $value . "' AND ";
		}

		// Remove trailing comma from the sets
		$sets = rtrim($sets, ',');
		// Remove trailing AND from the conditions
		$conditions = rtrim($conditions_sql, ' AND '); 

		$query = "UPDATE {$table} SET {$sets} WHERE {$conditions}";

		return $this->updateQuery($query);
	}

	/*
	 *
	 * Deletes rows from a given table which matches the conditions.
	 *
	 * @parm 	string 	$table 	The table to perform updates (i.e. names)
	 * @parm 	array 	$conditions 	The conditions at which to delete (column => value)
	 *
	 */

	public function delete($table, $conditions) {	
		if(empty($table))
			throw new Exception("No table defined for delete() @ Database");

		if(empty($conditions))
			throw new Exception("Must pass conditions array to delete() @ Database");

		foreach ($conditions as $key => $value) {
			$sets .= $key . ' = ';

			if (is_null($value))
				throw new Exception("Must pass values to all conditions");

			$value = addslashes($value);
			$sets .= "'" . $value . "' AND ";
		}
		$conditions = rtrim($sets, ' AND ');

		$sql = "DELETE FROM {$table} WHERE {$conditions}";

		return $this->deleteQuery($sql);
	}

	/*
	 * Executes a file at the given path.
	 *
	 * @parm 	string 	$file 	The path to the file (f.e. http://example.com/file.sql)
	 * @return 	bool 	true
	 *
	 */

	public function executeFile($file) {
		if(empty($file))
			throw new Exception("No file passed to executeFile() @ Database");

		if (!file_exists($file))
			throw new Exception("The passed to executeFile() doesn't exist");

		$content = file_get_contents($file);

		if(!$content)
			throw new Exception("Unable to read file passed to executeFile()");

		$sql = explode(';', $content);

		foreach($sql as $query) {
			$this->mysqli->query($query);
		}

		return true;
	}

	/*
	 *
	 * Performs a query, and then returns the ID of the newly inserted
	 * row.
	 *
	 * @parm 	string 	$query 	The query to perform
	 * @return 	integer $insert_id 	The id of the newly inserted item
	 *
	 */

	public function insertQuery($query) {
		$query = $this->mysqli->query($query);	

		if (!$query)
			throw new Exception("Couldn't insert @ Databse: " . mysql_error());

		return $this->mysqli->insert_id;	
	}

	/*
	 *
	 * Performs a query, and then returns the amount of rows affected
	 * by the action. (f.e. 6)
	 *
	 * @parm 	sting 	$query 	The query to perform
	 * @return 	integer $affected_rows 	The amount of affected rows
	 *
	 */

	public function updateQuery($query) {
		$query = $this->mysqli->query($query);

		if (!$query)
			throw new Exception("Couldn't update @ Database: " . mysql_error());

		return $this->mysqli->affected_rows;
	}

	/*
	 *
	 * Performs a query, and then returns the amount of rows affected
	 * by the action. (f.e. 6), the reason for not using the updateQuery
	 * is that this throws a more relevant exception, and the name is
	 * better.
	 *
	 * @parm 	string 	$query 	The query to perform
	 * @return 	integer $affected_rows 	The amount of affected rows
	 *
	 */

	public function deleteQuery($query) {
		$query = $this->mysqli->query($query);

		if (!$query)
			throw new Exception("Couldn't delete @ Database: " . mysql_error());

		return $this->mysqli->affected_rows;
	}
}
