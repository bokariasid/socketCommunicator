<?php
require 'config.php';
$name = $_REQUEST["inputName"];
$color = strtolower($_REQUEST["inputColor"]);
?>	
	<script type="text/javascript">
		$(document).ready(function () {
			$('td').hover(
				function(){
					var $this = $(this);
					$this.data('bgcolor', $this.css('background-color')).css('background-color', '#<?php echo $color?>');
				},
				function(){
					var $this = $(this);
					$this.css('background-color', $this.data('bgcolor'));
				}
			);
			$('td').click(function(){
				var $this = $(this);
				$this.data('bgcolor', $this.css('background-color')).css('background-color', '#<?php echo $color?>');
				conn.send(JSON.stringify({gameId:1,playerId:2,blockRow:$(this).data('row'),blockColumn:$(this).data('column'),color:'#<?php echo $color?>'}));
			});
		});
	</script>
	<link rel="stylesheet" type="text/css" href="css/grid.css">
	</style>
</head>

<div id="container">
<table class="grid">
    <?php $numSquare = $boardsize;

    	for($i = 0;$i < $numSquare;$i++){ ?>
    		<tr>
	    	<?php for($j = 0;$j < $numSquare;$j++){ ?>
	    		<td data-row ="<?php echo $i; ?>" data-column="<?php echo $j;?>">
	    		</td>
	    	<?php } ?> 
	    	</tr>
    	<?php }
    ?>
    </table>
</div>

