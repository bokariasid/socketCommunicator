<?php
namespace FinomenaTest;
include_once "config.php";
// include_once "database.php";
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
include_once 'vendor/autoload.php';
require 'Game.php';

class ServerInterface implements MessageComponentInterface {
protected $clients;
protected $db;
    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        // $this->db = new DatabaseHandler();
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        global $boardsize;
        $numRecv = count($this->clients) - 1;
        // echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            // , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $obj = json_decode($msg);
        // print_r($this->clients);
        foreach ($_SESSION["games"][$obj->gameId]["players"] as $playerName => $playerData) {
            # code...
            $scoreCard[] = array($playerName,$playerData["score"]);
        }
        $msgToReturn = json_encode(array(
                "gameId" => $obj->gameId,
                "name" => $obj->name,
                "cellId" => $obj->cellId,
                "color" => $obj->color,
                "scoreCard" => $scoreCard,
            ));
        $gameBlock = false;
        if(@$obj->newConnection == 1){
            $_SESSION["games"][$obj->gameId]["players"][$obj->name] = array();
            $_SESSION["games"][$obj->gameId]["players"][$obj->name]["score"] = 0;
            $_SESSION["games"][$obj->gameId]["players"][$obj->name]["socketId"] = $from->resourceId;            
            $numPlayerCount = count($_SESSION["games"][$obj->gameId]["players"]);
            if($numPlayerCount < 2){
                $return = json_encode(array(
                        "gameBlock" => 1,
                        "numPlayer" => $numPlayerCount,
                        "gameId" => $obj->gameId,
                    ));
                $msgToReturn = $return;
                $gameBlock = true;
            } else {
                $gameBlock = false;
                $return = json_encode(array(
                        "gameBlock" => 0,
                        "numPlayer" => $numPlayerCount,
                        "gameId" => $obj->gameId,
                    ));
                $msgToReturn = $return;                
            }
        } else {
            
            $_SESSION["games"][$obj->gameId]["players"][$obj->name]["score"] += 1;
            $allPlayers = $_SESSION["games"][$obj->gameId]["players"];
            $sum = 0;
            foreach($allPlayers as $player){
                $sum += $player["score"];
            }
            if($sum == $boardsize * $boardsize){
                $winner = array_keys($allPlayers, max($allPlayers));
                $return = json_encode(array(
                        "winner" => $winner,
                        "gameOver" => 1,
                        "gameId" => $obj->gameId,
                    ));
                $gameObj = new Game();
                $gameObj->closeGame($obj->gameId);
                $msgToReturn = $return;
            }
            
        }
        foreach ($this->clients as $client) {
            if ($from !== $client && $gameBlock) {
                // The sender is not the receiver, send to each client connected
                $client->send($msgToReturn);
            } else {
                $client->send($msgToReturn);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
        foreach($_SESSION["games"] as $gameId => $game){
            foreach ($game["players"] as $playerName => $playerData) {
                if($playerData["socketId"] == $conn->resourceId){
                    unset($_SESSION["games"][$gameId]["players"][$playerName]);
                    $gameId = $gameId;
                    break;
                }
            }
        }
        $numPlayerCount = count($_SESSION["games"][$gameId]["players"]);
            if($numPlayerCount < 2){                
                $return = json_encode(array(
                        "gameBlock" => 1,
                        "numPlayer" => $numPlayerCount,
                        "gameId" => $gameId,
                    ));
                $msg = $return;
                $gameBlock = true;
            } else {                
                $gameBlock = false;
                $return = json_encode(array(
                        "gameBlock" => 0,
                        "numPlayer" => $numPlayerCount,
                        "gameId" => $gameId,
                    ));
                $msg = $return;                
            }
        foreach ($this->clients as $client) {
            if ($conn !== $client && $gameBlock) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            } else {
                $client->send($msg);
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
?>