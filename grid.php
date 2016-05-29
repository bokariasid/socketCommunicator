<?php
require 'config.php';
$name = $_REQUEST["inputName"];
$color = $_REQUEST["inputColor"];
if(isset($_REQUEST["startGame"])) {
	$_SESSION["games"][1] = array();
	$_SESSION["games"][1]["players"] = array();
	$_SESSION["games"][1]["players"][$name] = 0;
} else {
	// echo 
}
$color = strtolower($_REQUEST["inputColor"]);
?>	
	<link rel="stylesheet" type="text/css" href="css/grid.css">
	</style>
</head>

<div id="container">
<div id="overlay"></div>
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