# Hostmon

Hostmon is a latency monitoring web app designed for ISP Support Technicians. <img src="https://raw.githubusercontent.com/itravers/HostMon/readmeWork/images/hostmon1.png" align="left" height="400" > Hostmon enables the Support Technician to provide a more rounded and detailed oriented service to his/her customers. Hostmon gives the Technician the ability to constantly monitor the network latency to hundreds of customer devices simultaneously. The Technician now has available, not only up to the minute network latency graphs for each device, but they can also view the historic latency information for monitored devices up to a year in the past. Hostmons note system lets multiple Technicians share up to the minute diagnostic information deciphered about each customer device enabling a collaborative diagnostic environment that allows customer facing issues <img src="https://raw.githubusercontent.com/itravers/HostMon/readmeWork/images/hostmon2.png" align="right" height="400" > to be identified and solved, quickly. Hostmons alert system will audibly notify the Technician immediately of any network issues causing downtime for the monitored customer devices, enabling the Technician to more effectively multi-task. Hostmon will help the Technician give his customers the level of service they expect. It will impact the Network making it work better and respond more efficiently. Mostly it will take stress off the Support Technician while simultaneously making him/her more effective.

## Getting Started

These instructions will get you a copy of the project up and running on your server for both production and development purposes.

### Prerequisites

Hostmon is designed to run on a [LAMP Stack](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu) or a [WAMP Stack](https://www.apachefriends.org/index.html) 

The Backend is run with Java, which can be installed on either Linux or Windows.
On Ubuntu type the following in the command line to install Java:
```
sudo apt-get install openjdk-7-jre
```

On Windows you can install Java from the following website:
```
https://java.com/en/download/
```

Once both of these prerequisites are installed you can begin installing the application itself.


### Installing

Hostmon has a special written install script to make installation as painless as possible. Just follow these simple steps:

Type the following in your git terminal clone the repository into a folder on your web server.

```
git clone https://github.com/ChicoSystems/HostMon
```

Now Point your browser to the install/install.php file under HostMon.

```
http://localhost/hostmon/install/install.php
```

End with an example of getting some data out of the system or using it for a little demo

## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built with
Hostmon was built using the following technologies:

* **HTML5** - [W3C](https://www.w3.org/TR/html5/)
* **CSS3** - [W3schools](http://www.w3schools.com/css/css3_intro.asp)
* **Javascript** - [W3schools](http://www.w3schools.com/Js/)
* **JQuery** - [Official JQuery Site](https://jquery.com/)
* **Bootstrap** - [Official Bootstrap Site](http://getbootstrap.com/)
* **Gridster.js** - [Gridster.js Site](http://gridster.net/)
* **PHP** - [PHP Site](http://php.net/)
* **Java** - [Stanford Programming Class](https://www.youtube.com/watch?v=KkMDCCdjyW8)
* **MySQL** - [MySQL Site](https://www.mysql.com/)

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

#### Version 0.7
+ Added alarm system. User can upload new alarm .mp3's to play instead of the defaults.
+ Fixed Various Bugs

#### Version 0.6 (7/7/16)
+ Added tour system for new users.
+ Fixed login bug. Enter button now works.

#### Version 0.5
+ Added backend online display dot to grid.php
+ Added ability of admin to stop or start the backend via the front end.
+ Made sure everything works on windows xampp and linux lamp.

#### Version 0.4
+ Added Installation System
+ Got rid of menu access on device.php

#### Version 0.3
+ Fixed auto color updating bug in grid.php.
+ Fixed graph NaNing out bug in device.php.
+ Secured and finished login system.
+ Added Version Display.

#### Version 0.2
+ grid.php is now working.
+ Added config/menu section.
+ Backend successfully ran for 100 days, 16 million pings, no issues detected.

#### Version 0.1
+ Added ability to add new device. Not done yet.

## To-Do List
+ DONE - Add ability to upload sounds for alarm system in the menu.
+ DONE - Make a volume controller for sounds in the menu, Controlling each sound individually and letting us play the sound so we can hear how loud it is.
+ Change limits that decide when the colors change updateGridColor() in grid.php
+ DONE - Suddenly the hour and day graphs aren't showing anymore.
+ DONE - Restyle the menu to fit in better with the theme.
+ Put Add device dialog in menu
+ Remove the Plus Add device square,
+ Update the tour to do the add device part when we are in the menu.
+ Remove shrink arrow when grid is smallest.
+ Remove grow arrow when grid is largest.
+ During Install need to check for 777 permissions for alarms/
+ Setup Readme to be viewable on github.


## Authors

* **Isaac Assegai** - [ChicoSystems](https://github.com/ChicoSystems)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This projects licence is forthcoming.

## Acknowledgments

* Special Thanks to Micheal Earl who helped formulate the graphical design for Hostmon
* Inspiration
* etc



HostMon
=======
*This Project is in a pre-alpha state.*

Hostmon is a multi-user latency &amp; uptime analytical tool.

Manual Install Instructions
-Dependencies
--Web Server
---PHP

--DB Server
---MySQL

--Backend Server
---Java 6-8

-Backend
--needs java to run, or jdk to compile.
--needs mysql-connector in the classpath
--When compileing add to the classpath javac -cp .:mysql*.jar HelloWorld.java
*.
--Then run with javaa -cp .:mysql*.jar
.*

-MySQL
--create database ;
--import db from .sql dump ;
--create user ;
--give user permissions on db ;
--edit db.cfg with known parameters ; 

ToDo:
DONE - Add ability to upload sounds for alarm system in the menu.
DONE - Make a volume controller for sounds in the menu, Controlling each sound individually and letting us play
       the sound so we can hear how loud it is.
Change limits that decide when the colors change updateGridColor() in grid.php
DONE - Suddenly the hour and day graphs aren't showing anymore.
DONE - Restyle the menu to fit in better with the theme.
Put Add device dialog in menu
Remove the Plus Add device square,
Update the tour to do the add device part when we are in the menu.
Remove shrink arrow when grid is smallest.
Remove grow arrow when grid is largest.
During Install need to check for 777 permissions for alarms/
Setup Readme to be viewable on github.
