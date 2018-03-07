Quiztool is a project aimed at developing a tool for making and playing custom Quiz-Games possible for Nokia employees.
----------------------------


Functional information of the current version ( 2017.11.29. ):

The tool is accessible through the Nokia network by going to the following address: http://10.183.21.84/

The header includes the following clickable buttons that are present at all times during the usage of the tool: 

- Quiz Game button: Directs to the welcome page 
( home.blade.php )

- Create button: Directs to the create page 
( create.blade.php , addquestion.blade.php, editquestion.blade.php )
	- While on the Create page, you can add custom questions by clicking the Add a custom question button below the available questions	
	- On the Add a custom question form the user must define the question group and give 1 right and 3 wrong answers
	- And filter questions by clicking the filter button around the right upper corner of the questions table
	- Upon game creation the user must give a name and at least one question
	

- Join button: Directs to the lobby page 
( gamelobby.blade.php )

- User icon: Opens up a dropdown list with the username and the following clickable list-element buttons:

	- Profile: Directs to the profile page where the ID, Name, Email and Admin status of the user are displayed 
	( profile.blade.php )
	
	- MyGames: Directs to the MyGames page 
	( mygames.blade.php )
	
	- Members: Directs to the members page 
	( members.blade.php )
	
	- Add new question: Directs to the questionCreate page
	( questionCreate.blade.php )
	
	- Logout: Logs the user out and directs to the welcome page
	( home.blade.php )
	
	
	

Notes:

The token-authentication has been disabled due to unresolved issues related to it by commenting out the 
following line in Http/Kernel.php:  //\App\Http\Middleware\VerifyCsrfToken::class,

In the current version, while playing a game , when the timer runs out the game doesn't automatically stop, 
the user only get thrown into the lobby when the next button is pressed.

On the Lobby page new games and deleted games don't get updated automatically, only when the user refreshes the page, 
this can lead to errors if someone lingers on the Lobby page while these events occur.




Knowledge about tools, packages, modules, resources that have been used for quiztool:

(  Note: A JavaScript library is a library of pre-written JavaScript which allows for easier development of JavaScript-based applications. )

----------------------------
Redis
----------------------------
- quiztool uses it , since socket.io needs it as a message broker


Redis is an open source (BSD licensed), in-memory data structure store, used as a database, 
cache and message broker. It supports data structures such as strings, hashes, lists, sets, 
sorted sets with range queries, bitmaps, hyperloglogs and geospatial indexes with radius queries. 
Redis has built-in replication, Lua scripting, LRU eviction, transactions and different levels of on-disk persistence, 
and provides high availability via Redis Sentinel and automatic partitioning with Redis Cluster.
You can run atomic operations on these types, like appending to a string; incrementing the value in a hash; pushing an element to a list; 
computing set intersection, union and difference; or getting the member with highest ranking in a sorted set.

https://redis.io/documentation
https://redis.io/commands


----------------------------
Socket.io 
----------------------------
 - the quiztool uses it for autorefreshing parts of the page by AJAX requests, the socket.io acts as an event-listener in this process
 - players who join a game are visible in the game lobby automatically without manually refreshing the page
 - when the creator of a game presses start, players automatically get directed to the quizgame page without refreshing

Socket.IO is a JavaScript library for realtime web applications. 
It enables realtime, bi-directional communication between web clients and servers. 
It has two parts: a client-side library that runs in the browser, and a server-side library for Node.js ( Make sure Node.JS is installed ) 
Both components have a nearly identical API. Like Node.js, it is event-driven.

Socket.IO primarily uses the WebSocket protocol with polling as a fallback option, while providing the same interface. 
Although it can be used as simply a wrapper for WebSocket, it provides many more features, including broadcasting to 
multiple sockets, storing data associated with each client, and asynchronous I/O. 
Socket.IO provides the ability to implement real-time analytics, binary streaming, instant messaging, and document collaboration.

It can be installed with the npm tool

https://socket.io/get-started/chat/


----------------------------
Node.js ( NPM )
----------------------------
- quiztool uses node.js modules in it's codes


Node.js is an open source server framework, a runtime built on Chrome's V8 JavaScript engine. It uses an event-driven, non-blocking I/O model. 
As an asynchronous event driven JavaScript runtime, Node is designed to build scalable network applications. 
Node.js uses JavaScript on the server.


Here is how PHP or ASP handles a file request:

Sends the task to the computer's file system.
Waits while the file system opens and reads the file.
Returns the content to the client.
Ready to handle the next request.

Here is how Node.js handles a file request:

Sends the task to the computer's file system.
Ready to handle the next request.
When the file system has opened and read the file, the server returns the content to the client.

Node.js eliminates the waiting, and simply continues with the next request.
Node.js runs single-threaded, non-blocking, asynchronously programming, which is very memory efficient.

Node.js can generate dynamic page content
Node.js can create, open, read, write, delete, and close files on the server
Node.js can collect form data
Node.js can add, delete, modify data in your database

Node.js' package ecosystem ( NodeJs Package Manager .. probably.. ), NPM, is the largest ecosystem of open source libraries in the world.

https://nodejs.org/en/
https://www.w3schools.com/nodejs/nodejs_intro.asp


----------------------------
Bootstrap-Sass
----------------------------

Bootstrap-sass is a Sass-powered version of Bootstrap 3. 

Bootstrap is a front-end component library. 
An open source toolkit for developing with HTML, CSS, and JS Quickly. 
Includes Sass variables, mixins, responsive grid sysem, extensive prebuilt 
components and powerful plugins built on JQuery.

http://getbootstrap.com/docs/4.0/getting-started/introduction/

Sass is a CSS extension language. Allows the use of variables, nested rules, 
mixins, inline imports, color manipulation etc...
Before using Sass Ruby has to be installed.
http://sass-lang.com/documentation/file.SASS_REFERENCE.html
https://www.ruby-lang.org/en/

Usable through CDN:
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css</script>

----------------------------
Gulp
----------------------------

Gulp solves the problem of repetition.
Gulp is a javascript TASK RUNNER that lets you automate tasks such as:
-Bundling and minifying libraries and stylesheets.
-Refreshing your browser when you save a file.
-Quickly running unit tests
-Running code analysis
-Less/Sass to CSS compilation
-Copying modified files to an output directory

API	       	-	Purpose
gulp.task	-	Define a task
gulp.src	-	Read files in
gulp.dest	-	Write files out
gulp.watch	-	Watch files for changes

http://brandonclapp.com/what-is-gulp-js-and-why-use-it/
https://scotch.io/tutorials/automate-your-tasks-easily-with-gulp-js

----------------------------
Laravel Elixir
----------------------------

A TASK RUNNER built as a wrapper around Gulp / built on top of Gulp.
Laravel Elixir provides a clean, fluent API for defining basic Gulp tasks for your Laravel application.
Elixir supports common CSS and JavaScript pre-processors like Sass and Webpack. 
Using method chaining, Elixir allows you to fluently define your asset pipeline.
One could define their own gulp tasks and add it to elixir.

https://laravel.com/docs/5.3/elixir

----------------------------
jQuery
----------------------------

jQuery is a fast, small, and feature-rich JavaScript library. 
It makes things like HTML document traversal and manipulation, event handling, 
animation, and Ajax much simpler with an easy-to-use API 
that works across a multitude of browsers.

https://jquery.com/     ( A Brief Look after the middle of the page should contain useful examples about it's usage )

----------------------------
Lodash 
- the quiztool includes Lodash but doesn't actually use it
----------------------------

A modern JavaScript utility library delivering modularity, performance & extras. 
Lodash makes JavaScript easier by taking the hassle out of working with arrays, numbers, objects, strings, etc.

Lodash’s modular methods are great for:
-Iterating arrays, objects, & strings
-Manipulating & testing values
-Creating composite functions

In other words Lodash is a JavaScript library which   provides utility functions / has a group of general purpose utilities 
for common programming tasks.

https://lodash.com/
https://en.wikipedia.org/wiki/Lodash

----------------------------
Vue
- the quiztool includes Lodash but doesn't actually use it
----------------------------

Vue is a progressive framework for building user interfaces. 
Unlike other monolithic frameworks, Vue is designed from the ground up to be incrementally adoptable. 
The core library is focused on the view layer only, and is easy to pick up and integrate with other libraries or existing projects. 
Also perfectly capable of powering sophisticated Single-Page Applications 
when used in combination with modern tooling and supporting libraries.

https://vuejs.org/v2/guide/index.html

Usable through CDN:
<script src="https://cdn.jsdelivr.net/npm/vue</script>

Vue-Resource is a plugin for Vue.js that provides service for making web requests
and handle responses using an XMLHttpRequest or JSONP.
Usable through CDN:
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.3.4"></script>






