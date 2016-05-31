# socketCommunicator

This is a basic game made for learning the basics of Websocket. <br>
The frontend is pure jquery and the backend has been implemented using PHP.<br>

<h4>Basic Steps for deployment of the webapp</h4>
1.Deploy the code on an apache2/nginx+php5-fpm server.<br>
2.Get all the neccessary resources in place (bootstrap , jquery).<br>
3.Run composer update for server side dependencies.<br>
4.All the configurable variables are there in config.php.<br>
5.Change the port of the listener script according to requirement(requestHandler.php).<br>
6.Create the database and edit the DatabaseHandler class accordingly.<br>
7.Start the requestHandler script on the server.(requestHandler.php, in project root).<br>
8.Deploy the webapp.<br>
9.Enjoy!!<br>
<h4>Basic Gameflow</h4>
1. User lands on the index page.
2. If any existing game is there, then they are displayed.
3. The user can start a new game or join an existing one.
4. A game begins only when there are atleast 2 players in it.
5. As soon as an existing user disconnects, his/her progress is lost.
6. Each player can hover over the board and squares will light up with their assigned color
7. Player can select the square by clicking it
8. A player can acquire the square by clicking it
9. Once a square is acquired it gets filled with the player's color
10. An acquired square cannot be taken by any other player and its color will not change on hovering
11. Once a square is selected by a player, all players are blocked for x seconds to do anything
12. After x seconds(configurable in config.php), board becomes available again for all the players
13. Game ends when all squares are colored and players with maximum squared colored wins.
14. The end result is diplayed via an alert.
15. The scorecard is also maintained for all the users
