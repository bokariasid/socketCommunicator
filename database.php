<?php
namespace FinomenaTest;
date_default_timezone_set('Asia/Calcutta');
class DatabaseHandler{
	///Declaration of variables

	var $host = "localhost";
	var $user = "root";
	var $pwd = "baratheon&1";
	var $persist = false;
	var $database = "finomena";
	var $conn = NULL;
	var $result = false;
	var $fields;
	var $check_fields;
	var $tbname;
	var $addNewFlag = false;

	///End

	function __construct($host = "", $user = "", $pwd = "", $dbname = "", $open = true) {
		if ($host != "") {
			$this->host = $host;
		}

		if ($user != "") {
			$this->user = $user;
		}

		if ($pwd != "") {
			$this->pwd = $pwd;
		}

		if ($dbname != "") {
			$this->database = $dbname;
		}

		if ($open) {
			$this->open();
		}

	}
	function open($host = "", $user = "", $pwd = "", $dbname = "") {
		if ($host != "") {
			$this->host = $host;
		}

		if ($user != "") {
			$this->user = $user;
		}

		if ($pwd != "") {
			$this->pwd = $pwd;
		}

		if ($dbname != "") {
			$this->database = $dbname;
		}

		$this->connect();
		$this->select_db();
		mysqli_query($this->conn, "set time_zone = '+5:30';");
	}
	function set_host($host, $user, $pwd, $dbname) {
		$this->host = $host;
		$this->user = $user;
		$this->pwd = $pwd;
		$this->database = $dbname;
	}
	function affectedRows() //-- Get number of affected rows in previous operation
	{
		return @mysqli_affected_rows($this->conn);
	}
	function close() //Close a connection to a  Server
	{
		return @mysqli_close($this->conn);
	}
	function connect() //Open a connection to a Server
	{
		// Choose the appropriate connect function
		if ($this->persist) {
			$func = 'mysqli_pconnect';
		} else {
			$func = 'mysqli_connect';
		}

		// Connect to the database server
		$this->conn = $func($this->host, $this->user, $this->pwd, $this->database);
		if (!$this->conn) {
			// error log
			$this->dberror_log(mysqli_error());
			return false;
		}

	}
	function dberror_log($err_str) {
		/* First create an error log file manually to write errors */
		$thefile = "dberror_log.txt";
		$openedfile = fopen($thefile, "a");
		fwrite($openedfile, date('d-m-Y h:i') . " -Path:" . $_SERVER['REQUEST_URI'] . " -Error: " . $err_str . "\r\n");
		fclose($openedfile);
		// $mailSender = new MailSender();
		// $mailSender->SendMail(array("sanjayjss26@gmail.com", "bokariasiddhartha@gmail.com", "ankit.mehlawat@gmail.com"), "Down time alert - mysql connection failure", $err_str . " at :" . date('Y-m-d H:i:s'),
		// 	"nishant.s.mathur@gmail.com");
	}

	function select_db($dbname = "") //Select a databse
	{
		if ($dbname == "") {
			$dbname = $this->database;
		}

		mysqli_select_db($this->conn,$dbname);
	}
	function create_db($dbname) //Create a database
	{
		return @mysqli_create_db($dbname, $this->conn);
	}
	function drop_db($dbname) //Drop a database
	{
		return @mysqli_drop_db($dbname, $this->conn);
	}
	function data_seek($row) ///Move internal result pointer
	{
		return mysqli_data_seek($this->result, $row);
	}
	function error() //Get last error
	{
		return (mysqli_error());
	}
	function errorno() //Get error number
	{
		return mysqli_errno();
	}
	function query($sql = '') //Execute the sql query
	{
		$this->result = @mysqli_query($this->conn, $sql) or $this->dberror_log(mysqli_error());
		return ($this->result != false);
	}
	function numRows() //Return number of rows in selected table
	{
		return (@mysqli_num_rows($this->result));
	}
	function fieldName($field) {
		return (@mysqli_field_name($this->result, $field));
	}
	function fieldColumns() {
		return (@mysqli_num_fields($this->result));
	}
	function insertID() {
		return (@mysqli_insert_id($this->conn));
	}
	function fetchObject() {
		return (@mysqli_fetch_object($this->result, MYSQL_BOTH));
	}
	function fetchArray() {
		return (@mysqli_fetch_array($this->result));
	}
	function fetchRow() {
		return (@mysqli_fetch_row($this->result));
	}
	function fetchAssoc() {
		return (@mysqli_fetch_assoc($this->result));
	}
	function freeResult() {
		return (@mysqli_free_result($this->result));
	}

}
