<?php
namespace FinomenaTest;
require 'config.php';
require 'Game.php';
$name = $_REQUEST["inputName"];
$color = $_REQUEST["inputColor"];
if(isset($_REQUEST["startGame"])) {
	$gameObj = new Game();
	$gameId = $gameObj->createNewGame();
	if($gameId){
	 	$_SESSION["games"][$gameId] = array();
		$_SESSION["games"][$gameId]["players"] = array();
		$_SESSION["games"][$gameId]["players"][$name] = 0;
	}

} elseif(isset($_REQUEST["joinGame"])) {
	// echo 
	$gameId = str_replace("Game","",$_REQUEST["joinGame"]);
	$_SESSION["games"][$gameId]["players"][$name] = 0;
}
$color = strtolower($_REQUEST["inputColor"]);
?>	
	<link rel="stylesheet" type="text/css" href="css/grid.css">
	</style>
</head>

<div id="container">
<div id="overlay"></div>
<h4> Please do not refresh or you will lose your progress!!</h4>
<table class="grid">
    <?php $numSquare = $boardsize;

    	for($i = 0;$i < $numSquare;$i++){ ?>
    		<tr>
	    	<?php for($j = 0;$j < $numSquare;$j++){ ?>
	    		<td id="<?php echo $i,$j;?>" data-flag='0'>
	    		</td>
	    	<?php } ?> 
	    	</tr>
    	<?php }
    ?>
    </table>
</div>

<script type="text/javascript">
var gameId = 1;
var playerName = '<?php echo $name; ?>';
var playerColor = '#<?php echo $color; ?>';
var timeoutDelay = <?php echo $blockingTime;?>;
	</script>
<script type="text/javascript" src="js/socketHandler.js"></script>