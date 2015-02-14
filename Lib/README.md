MicroMVC
=========
This is just a small (micro) mvc framework written in PHP 5.
You can use it for small websites with small complexity. Beside the mvc concept there are not many additional function included.

Feel free to extend it.

System requirements
-------------------
+ Apache 2
+ PHP >=5.3
+ Some database (optional): MySQL or SQLite or other with PDO

Installation
--------------
Via git:
```git clone https://github.com/dknx01/micromvc.git```

Or downwload the latest version at https://github.com/dknx01/micromvc/archive/master.zip

The Apache DocumentRoot must link to the public folder.
All other folders must be readable for the web server user.

Usage
-----
Your controllers are inside Application/Controllers folder.
Your views inside Application/View/CONTROLLERNAME/.
The view uses the same name like the action in the controller.
Your database models, mappers and table classes should be under Application/Db.
The configuration file is under Application/Config.
If you use a bootstrapping file it must be under Application/Config/Bootstrap.php and will be included in the startUp-Process.
If you use 3rd party apps, put it under Lib/Libs.
Further information visit https://github.com/dknx01/micromvc/wiki/Usage

License
-------
BSD

ToDo
----
[x] Documentation

[x] Actions

[X] extend standard database function

[X] automatic doctype

[] context switch

[] Dependency injection container

Any sugestions or comments just let me know.

dknx01
