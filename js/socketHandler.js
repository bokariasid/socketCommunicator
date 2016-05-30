$(document).ready(function () {
	$('td').hover(
		function(){
				var $this = $(this);
				if($this.data("flag") != "1"){
					$this.data('bgcolor', $this.css('background-color')).css('background-color', playerColor);
				}
			},
			function(){
				var $this = $(this);
				if($this.data("flag") != "1"){
					$this.css('background-color', $this.data('bgcolor'));
				}
			}			
	);
	$('td').click(function(){
		var $this = $(this);
		if($this.data("flag") != '1'){
			$this.data('flag',"1");
			$this.data('bgcolor', $this.css('background-color')).css('background-color', playerColor);
			var json = JSON.stringify({gameId:gameId,name:playerName,cellId:$(this).attr('id'),color:playerColor});
			$("#overlay").show();
    		setTimeout(function(){ $("#overlay").hide(); conn.send(json);}, timeoutDelay);	
		}
	});
});
var conn = new WebSocket('ws://localhost:8089');
conn.onopen = function(e) {
    // console.log("Connection established!");
    var json = JSON.stringify({gameId:1,name:playerName,color:playerColor,newConnection:1});
    conn.send(json);
};

conn.onmessage = function(e) {
    var parameters = $.parseJSON(e.data);
    console.log(parameters);
for (var key in parameters.currentGrid	) {
    // skip loop if the property is from prototype
    if (!parameters.currentGrid.hasOwnProperty(key)) continue;

    var obj = parameters.currentGrid[key];
    for (var prop in obj) {
        // skip loop if the property is from prototype
        if(!obj.hasOwnProperty(prop)) continue;

        // your code
        console.log(prop + " = " + obj[prop]);
    }
}
    if(parameters.gameBlock == 1){
    	$("#overlay").show();
    } else {
    	$("#overlay").hide();
    	// alert("Please start!!");
    }
    if(parameters.gameOver == 1){
    	alert(parameters.winner + " won!!");
    	window.location = "index.php";
    }
    if(parameters.cellId){
    	var $this = $('#'+parameters.cellId);
    	if($this.data("flag") != "1"){
    		$this.data('bgcolor', $this.css('background-color')).css('background-color', parameters.color);
    		$this.data('flag',"1");
    		$("#overlay").show();
    		setTimeout(function(){ $("#overlay").hide(); }, timeoutDelay);
		}		
    }
    
};
