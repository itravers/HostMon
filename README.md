# Hostmon

Hostmon is a latency monitoring web app designed for ISP Support Technicians. A Technician can monitor the latency to a practically unlimited amount of devices on the internet. Hostmon can notify the Technician immediately if a devices latency becomes to high. In addition the Technician can leave Hostmon running in the background and then come back and view the latency history at a later time. Hostmon allows the Technician to leave notes for each device to help him diagnose problems over a larger length of time.

## Getting Started

These instructions will get you a copy of the project up and running on your server for both production and development purposes.

### Prerequisities

What things you need to install the software and how to install them

```
Give examples
```

### Installing

A step by step series of examples that tell you have to get a development env running

Stay what the step will be

```
Give the example
```

And repeat

```
until finished
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

## Built With

* Dropwizard - Bla bla bla
* Maven - Maybe
* Atom - ergaerga

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

## Authors

* **Isaac Assegail** - [ChicoSystems](https://github.com/ChicoSystems)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone who's code was used
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

Version 0.7
-Added alarm system. User can upload new alarm .mp3's to play instead of the defaults.
-Fixed Various Bugs

Version 0.6 (7/7/16)
-Added tour system for new users.
-Fixed login bug. Enter button now works.

Version 0.5
-Added backend online display dot to grid.php
-Added ability of admin to stop or start the backend via the front end.
-Made sure everything works on windows xampp and linux lamp.

Version 0.4
-Added Installation System
-Got rid of menu access on device.php

Version 0.3
-Fixed auto color updating bug in grid.php.
-Fixed graph NaNing out bug in device.php.
-Secured and finished login system.
-Added Version Display.

Version 0.2
-grid.php is now working.
-Added config/menu section.
-Backend successfully ran for 100 days, 16 million pings, no issues detected.

Version 0.1
-Added ability to add new device. Not done yet.



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
