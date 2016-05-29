<?php
namespace FinomenaTest;
include_once "config.php";
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
include_once 'vendor/autoload.php';

class ServerInterface implements MessageComponentInterface {
protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        global $boardsize;
        $numRecv = count($this->clients) - 1;
        // echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            // , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $obj = json_decode($msg);
        // print_R($obj);
        $gameBlock = false;
        // $_SESSION["games"][$obj->gameId][]
        if(@$obj->newConnection == 1){
            $_SESSION["games"][$obj->gameId]["players"][$obj->name] = 0;
            $numPlayerCount = count($_SESSION["games"][$obj->gameId]["players"]);
            // print_r($numPlayerCount);/
            if($numPlayerCount < 2){
                $return = json_encode(array(
                        "gameBlock" => 1,
                        "numPlayer" => $numPlayerCount
                    ));
                $msg = $return;
                $gameBlock = true;
                // print_r($return);
                // $client->send($return);
                // return;
            } else {
                $gameBlock = false;
                $return = json_encode(array(
                        "gameBlock" => 0,
                        "numPlayer" => $numPlayerCount
                    ));
                // $client->send($return);
                // return;
                $msg = $return;                
            }

        } else {
            $_SESSION["games"][$obj->gameId]["players"][$obj->name] += 1;
            $allPlayers = $_SESSION["games"][$obj->gameId]["players"];
            // print_r(array_sum($allPlayers));
            if(array_sum($allPlayers) == $boardsize * $boardsize){
                $winner = array_keys($allPlayers, max($allPlayers));
                $return = json_encode(array(
                        "winner" => $winner,
                        "gameOver" => 1
                    ));
                // $client->send($return);
                // return;
                $msg = $return;
            }
        }
        foreach ($this->clients as $client) {
            if ($from !== $client && $gameBlock) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            } else {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
?>