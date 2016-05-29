<?php
session_start();
require 'config.php';
include_once 'Game.php';
$gameObj = new Game();
$games = $gameObj->getGames();
// print_r(($games));exit;
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
} 
?>
<script type="text/javascript">
  var delay = <?php echo $blockingTime;?>
</script>
</head>
   <div class="container">
   <div class="row">
   <div class="col-md-3"></div>
   <div class="col-md-3" style="
    margin-top: 250px;
    margin-left: 120px;
">
      <form class="form" method="get" action="grid.php">
        <label for="inputName" class="sr-only">Name</label>
        <input type="text" name = "inputName" id="inputName" class="form-control" placeholder="Name" required autofocus size="40" pattern="^[a-zA-Z\s]+$">
        <input type="hidden" name = "inputColor" id="inputColor" class="form-control" value="<?php echo random_color();?>">
        <?php 
        if(count($games) > 0){ 
            foreach ($games as $game) { ?>
        <input class="btn btn-lg btn-primary btn-block" type="submit" id="joinGame" name="joinGame" value="<?php echo $game['id']?>">            
        <?php }
    } ?>        
        <input class="btn btn-lg btn-primary btn-block" type="submit" id="startGame" name="startGame" value="startGame">
      </form>
      <div>
      <div class="col-md-3"></div>
	</div>
    </div> 
