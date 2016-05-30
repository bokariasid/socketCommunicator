<?php
namespace FinomenaTest;

class Game {
	private $db = "";
	private $tableName = "games";
	function __construct(){
		$this->db = new DatabaseHandler();
	}
	public function getGames(){
		// return $_SESSION["games"];
		$sql = "SELECT * FROM games where is_complete = '0'";
		$result = $this->db->query($sql);
		$returnData = array();
		// echo $this->db->numRows($result);
		if($this->db->numRows($result) > 0){
			while($data = $this->db->fetchAssoc($result)){
				$returnData[] = $data;
			}
		}
		return $returnData;
	}

	public function createNewGame(){
		// $data = array();
		$sql = "INSERT INTO ".$this->tableName." SET
				num_players = '1',
				is_complete = '0',
				updated_at = now()";
		if($this->db->query($sql)){
			return $this->db->insertID();		
		}	
		return false;
	}

	public function closeGame($gameId){
		$sql = "UPDATE ".$this->tableName." SET
				is_complete = '1' 
				WHERE id = '".$gameId."'";
		if($this->db->query($sql)){
			return true;	
		}	
		return false;
	}

	public function isClosed($gameId){
		$sql = "SELECT * FROM ".$this->tableName." 
				WHERE id = '".$gameId."'
				AND is_complete = '1'";
		$result = $this->db->query($sql);
		if($this->db->numRows($result) > 0){
			return true;
		}
		return false;
	}
}