# whitbreadtest

Built with JQuery and Twitter Bootstrap on the front end, PHP on the backend

Structure:
1. Submit user input place name to backend.php over AJAX (using JQuery).
2. Backend calls the FourSquare API to get recommended places nearby the place name
3. Backend parses the results returned from FourSquare API, retaining just the info we want to return to the user, to save network
bandwidth and frontend processing
4. Filtered results are reformatted as JSON and returned to the frontend as a JSON response
5. JS on the client parses the venue results from JSON and generates HTML to display in a grid

Build process:
1. Research into Foursquare API to determine simplest and best method to interface with it. Decided against the recomended PHP API as overkill and opted for simpler CURL based approach
2. Decided to use a backend (using PHP which I am most familiar with on the backend) to save divulging API keys and to allow results filtering to reduce data sent to the client
3. Designed UI, and implemented
4. Outlined front end in code, then built backend
5. Built frontend code in JS to parse data from backend
