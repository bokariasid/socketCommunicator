<?php
require 'config.php';
// echo "helo";exit;
?>
</head>
   <div class="container">
   <div class="row">
   <div class="col-md-3"></div>
   <div class="col-md-3" style="
    margin-top: 250px;
    margin-left: 120px;
">
      <form class="form-signin" method="post" action="">
        <label for="inputName" class="sr-only">Email address</label>
        <input type="text" id="inputName" class="form-control" placeholder="Name" required autofocus size="40" pattern="^[a-zA-Z\s]+$">
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="joinGame">Join</button>
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="startGame">Start Game</button>
      </form>
      <div>
      <div class="col-md-3"></div>
	</div>
    </div> 


<script type="text/javascript">
	$("#joinGame").on('click',function(event){
		event.preventDefault();
		// alert("You pressed join!!");
	});

	$("#startGame").on('click',function(event){
		event.preventDefault();
		// alert("You pressed start!!");
		window.location.href = 'grid.php?inputName='+$("#inputName").val()+'&inputColor=<?php echo random_color();?>';		
	});
<?php
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}
?>
</script>