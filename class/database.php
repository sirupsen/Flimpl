<?php
/*
 *
 * The database class, it's used to connect to the database and perform
 * different actions on it.
 *
 * @date 	10. August, 2009
 *
 * @author 	Sirupsen
 *  
 */

class Database {

	public $mysqli;
	public $last_query;
	
	/*
	 *
	 * Constructer for the class which connects to the database, due to
	 * that the database would be usefull without having a connection.
	 *
	 * @param 	string 	$host 	The host (f.e. localhost)
	 * @param 	string 	$user 	The username (f.e. root)
	 * @param 	string 	$password 	The password (f.e. password)
	 * @param 	string 	$db 	The database used (f.e. database)
	 *
	 */

	public function __construct($host='localhost', $user='root', $password='', $db='db') {
		if (!$this->mysqli = new Mysqli($host, $user, $password, $db))
			throw new Exception("<b>Database:</b> Unable to connect");
	}

	/*
	 *
	 * Selects something from the database, and returns the query.
	 *
	 * @param 	mixed 	$table 	The table(s)
	 * @param 	array 	$conditions 	The conditions for the query
	 * @param 	string 	$columns 	The column(s), default is all
	 * @param 	string 	$extra 	Stuff to append to the query (f.e. limit, order by)
	 * @return 	string 	$query 	The query
	 *
	 */

	public function select($table, $conditions='', $columns='*', $extra='') {
		if(empty($table))
			throw new Exception('<b>Database:</b> Required parameter $table was passed, but was empty');

		// If the user made $table parm an array, escape it and make it into
		// a string we can use in the query.
		if(is_array($table)) {
			foreach ($table as $table) {
				$tables[] = addslashes($table);
			}
			$table = implode(', ', $tables);
		}

		// The conditions SHOULD be an array, parse them so their ready for the
		// query. If it's not an array, throw an exception
		if($conditions) {
			if(is_array($conditions))
				$conditions = 'WHERE ' . $this->prepare($conditions, ' AND '); 
			else
				throw new Exception('<b>Database:</b> Parameter $conditions <b>must</b> be an array');
		}

		// If $columns is an array, prepare it for the query
		if(is_array($columns)) {
			foreach ($columns as $column) {
				$cols[] = addslashes($column);
			}
			$columns = implode(', ', $cols);
		}

		// If somebody passed the columns argument empty
		if (!$columns) {
			$columns = '*';
		}

		// Create the query
		$query = "SELECT {$columns} FROM {$table} {$conditions} {$extra}";

		// Set the query as last query for the database, then perform it
		$this->last_query = '<b>Select Query:</b> ' . $query;
		$query = $this->mysqli->query($query);

		// Oops, error.
		if (!$query || !is_object($query))
			throw new Exception('<b>Database:</b> Not able to select (' . $this->mysqli->error . ')');

		return $query;
	}

	/*
	 *
	 * Selects something from the database, and returns the raw
	 * array. This is usefull for just dumping a query to the
	 * database without needing to modify the values.
	 *
	 * @param 	mixed 	$table 	The table(s)
	 * @param 	array 	$conditions 	The conditions for the query
	 * @param 	string 	$columns 	The column(s), default is all
	 * @param 	string 	$extra 	Stuff to append to the query (f.e. limit, order by)
	 * @return 	array 	$return 	An array of all entries
	 *
	 */

	public function select_tpl($table, $conditions='', $columns='*', $extra='') {
		// Throws the query to the select function
		$query = $this->select($table, $conditions, $columns, $extra);

		// Make an array with the content
		while ($row = $this->row($query)) {
			$return[] = $row;
		}

		// return it!
		return $return;
	}

	/*
	 *
	 * Inserts something into the database, and escapes the input
	 * by adding slashes.
	 *
	 * @param 	string 	$table 	The table to perform the insert on (f.e. blog_posts)
	 * @param 	array 	$data 	The actual data to insert as an array (column => value)
	 * @return 	integer $id 	The id of the newly inserted item (f.e. 8)
	 * 
	 */

	public function insert($table, $data) {
		if(empty($table))
			throw new Exception('<b>Database:</b> Required parameter $table was passed, but was empty');

		// Data is not an array, throw exception
		if(!is_array($data))
			throw new Exception('<b>Database:</b> Argument $data for insert() is <b>not</b> an array');

		// Should table happen to be an array, escape it and make it into a string
		// ready for the query.
		if(is_array($table)) {
			foreach ($table as $table) {
				$tables[] = addslashes($table);
			}
			$table = implode(', ', $tables);
		}

		$sets = $this->prepare($data);

		// Make the query
		$query = "INSERT INTO {$table} SET {$sets}";

		// Send it to insertQuery
		return $this->insertQuery($query);
	}

	/*
	 *
	 * Updates a database defined with the data provided in an array, at
	 * some given conditions.
	 *
	 * @param 	string 	$table 	The table to perform the action on (f.e. articles)
	 * @param 	array 	$data 	The columns in the row(s) to update (column => value)
	 * @param 	array 	$conditions 	The conditions at which to update (column => value):w
	 * @param 	string 	$extra 	Stuff to append to the query (f.e. limit, order by)
	 * @return 	integer $affected_rows 	The amount of rows affected by the update
	 *
	 */

	public function update($table, $data, $conditions, $extra='') {
		if(empty($table))
			throw new Exception('<b>Database:</b> Required parameter $table was passed, but was empty');

		// Oops, $data or $conditions were not an array!
		if(!is_array($data) || !is_array($conditions))
			throw new Exception('<b>Database</b> Argument $data or $condition for update() is/are <b>not</b> (an) array(s)');

		// Should table happen to be an array, escape it and make it into a string
		// ready for the query.
		if(is_array($table)) {
			foreach ($table as $table) {
				$tables[] = addslashes($table);
			}
			$table = implode(', ', $tables);
		}

		$sets = $this->prepare($data);
		$conditions = $this->prepare($conditions, ' AND ');

		$query = "UPDATE {$table} SET {$sets} WHERE {$conditions} {$extra}";

		return $this->updateQuery($query);
	}


	/*
	 *
	 * Deletes rows from a given table which matches the conditions.
	 *
	 * @param 	string 	$table 	The table to perform updates (i.e. names)
	 * @param 	array 	$conditions 	The conditions to perform the query on
	 * @param 	string 	$extra 	Stuff to append to the query (f.e. limit, order by)
	 * @param 	array 	$conditions 	The conditions at which to delete (column => value)
	 *
	 */

	public function delete($table, $conditions='', $extra='') {	
		if(empty($table))
			throw new Exception('<b>Database:</b> Required parameter $table was passed, but was empty');

		// Hello dear $table, are you an array you'll not be able to break anything!
		if(is_array($table)) {
			foreach ($table as $table) {
				$tables[] = addslashes($table);
			}
			$table = implode(', ', $tables);
		}

		// Prepare $conditions for the query
		if (is_array($conditions))
			$conditions = ' WHERE ' . $this->prepare($conditions, ' AND '); 
		else
			throw new Exception('<b>Database:</b> Parameter $conditions in delete() were not an array');

		$sql = "DELETE FROM {$table} {$conditions} {$extra}";

		return $this->deleteQuery($sql);
	}

	/*
	 * Executes a file at the given path.
	 *
	 * @param 	string 	$file 	The path to the file (f.e. http://example.com/file.sql)
	 * @return 	bool 	true
	 *
	 */

	public function execute($file) {
		// If the parameter passed is not an array, make it!
		if (!is_array($files)) {
			$files[] = $files;
		}

		// For each file in the array, run it
		foreach ($files as $file) {
			// Uuooh, the file doesn't exist!
			if (!file_exists($file))
				throw new Exception('<b>Database:</b> File ' . $file . ' passed to execute() does not exist');

			// So, what is the contents of this file?
			$content = file_get_contents($file);

			if(!$content)
				throw new Exception('<b>Database:</b> Not able to read ' . $file . ' passed to execute()');

			// Split it!
			$sql = explode(';', $content);

			// So it's easier to check the errors..
			foreach($sql as $query) {
				$this->executeQuery($query, $file);
			}
		}

		return true;
	}

	/*
	 *
	 * Performs a query, and then returns the ID of the newly inserted
	 * row.
	 *
	 * @param 	string 	$query 	The query to perform
	 * @return 	integer $insert_id 	The id of the newly inserted item
	 *
	 */

	public function insertQuery($query) {
		$this->last_query = '<b>Insert Query:</b> ' . $query;

		if (!$this->mysqli->query($query))
			throw new Exception('<b>Database:</b> Unable to perform the insert query (' . $this->mysqli->error . ')');

		return $this->mysqli->insert_id;	
	}

	/*
	 *
	 * Performs a query, and then returns the amount of rows affected
	 * by the action. (f.e. 6)
	 *
	 * @param 	sting 	$query 	The query to perform
	 * @return 	integer $affected_rows 	The amount of affected rows
	 *
	 */

	public function updateQuery($query) {
		$this->last_query = '<b>Update Query:</b> ' . $query;

		if (!$this->mysqli->query($query))
			throw new Exception('<b>Database:</b> Unable to perform the update query (' . $this->mysqli->error . ')');

		return $this->mysqli->affected_rows;
	}

	/*
	 *
	 * Performs a query, and then returns the amount of rows affected
	 * by the action. (f.e. 6), the reason for not using the updateQuery
	 * is that this throws a more relevant exception, and the name is
	 * better.
	 *
	 * @param 	string 	$query 	The query to perform
	 * @return 	integer $affected_rows 	The amount of affected rows
	 *
	 */

	public function deleteQuery($query) {
		$this->last_query = '<b>Delete Query:</b> ' . $query;

		if (!$this->mysqli->query($query))
			throw new Exception('<b>Database:</b> Unable to perform the delete query (' . $this->mysqli->error . ')');

		return $this->mysqli->affected_rows;
	}

	/*
	 * Executes a query for the execute function 
	 * 
	 * @param 	string 	$query 	The query to execute 
	 * @return 	bool 	true 	
	 */

	public function executeQuery($query, $file) {
		$this->last_query = '<b>Execute Query:</b> ' . $query;

		if(!$this->mysqli->query($query))
					throw new Exception('<b>Database:</b> A query failed while executing ' . $query . ' in ' . $file . ' in execute() (' . $this->mysqli->error . ')');

		return true;
	}
	
	/*
	 * Prepares something for the SQL query 
	 * 
	 * @param 	array 	$data 	The data to prepare 
	 * @param 	string 	$splitter 	How to split it (f.e. conditions is AND)
	 * @return 	string 	..... 	Prepared string
	 */

	private function prepare($data, $splitter=', ') {
		if(!is_array($data))
			throw new Exception('<b>Database:</b> Param passed to prepare was not an array');

		foreach ($data as $key => $value) {
			$sets .= $key . ' = ';

			if (is_null($value)) {
				$value = 'NULL, ';
			}
			
			$value = addslashes($value);
			$sets .= "'" . $value . "'$splitter";
		}
		
		return rtrim($sets, $splitter);
	}

	/*
	 *
	 * By default the class adds slashes to everything, if you use
	 * this function when looping the query, it automaticly strips
	 * the slashes.
	 *
	 * @param 	object 	$obj 	The query
	 * @return 	array 	$row 	The escaped row(s)
	 *
	 */

	public function row($obj) {
		foreach ((array) $obj->fetch_assoc() as $key => $value) {
			$row[$key] = stripslashes($value);
		}

		return (array) $row;
	}

	/*
	 *
	 * This method is mainly used for debugging the entire class at once,
	 * by taking everything in the database, show it - then make a new
	 * entry, view it, update it, view it again to see the changes,
	 * and then delete it.
	 *
	 */

	public function test() {
		echo 'Selecting all..</br>';
		echo '<pre>';
		if($articles = $this->select_tpl('articles'))
			print_r($articles);
		echo '</pre>';

		echo 'Inserting.. ';
		$new_article = array('title' => 'New Title', 'text' => 'New Content');
		if($insert = $this->insert('articles', $new_article))
			echo '<b>success!</b> (' . $insert . ')<br/><br/>';

		echo 'Select..';
		echo '<pre>';
		if ($select = $this->select('articles', array('id' => $insert), '')) {
			while($row = $this->row($select)) {
				print_r($row);	
			}
		}
		echo '</pre>';

		echo 'Updating.. ';
		$update = array('title' => 'Updated Text', 'text' => 'Updated Content');
		$conditions = array('id' => $insert);
		if ($update = $this->update('articles', $update, $conditions))
			echo '<b>success!</b> (' . $update . ')<br/><br/>';

		echo 'Select again..';
		echo '<pre>';
		if ($select = $this->select('articles', array('id' => $insert), '')) {
			while($row = $this->row($select)) {
				print_r($row);	
			}
		}
		echo '</pre>';

		echo 'Deleting.. ';
		$conditions = array('id' => $insert);
		if($delete = $this->delete('articles', $conditions))
			echo '<b>success!</b> (' . $delete . ')<br/><br/>';

		echo 'Check if it is deleted..';
		if ($select = $this->select('articles', array('id' => $insert))) {
			$num = $selected->num_rows;
			if($num == 0) {
				echo '<b>success!</b>';
			}
		}
	}
}
