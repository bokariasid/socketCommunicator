var conn = new WebSocket('ws://localhost:8089');
conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
    console.log(e.data);
    var parameters = $.parseJSON(e.data);
    
};