#Learn PostgreSQL. Demo

## Overview

Study PostgreSQL via demonstration queries.
You can add your own queries to the bottom of executable file index.php and analyze their results in browser view.
Add queries should be using the following syntax:

```
$Sql->go('This is a current century',"SELECT EXTRACT(CENTURY FROM NOW())");
```

See a demo http://selikoff.ru/demo/learn-postgres-demo/

## Start

```
$ cd /var/www/html
$ git clone https://github.com/selff/learn-postgres-demo.git
$ cd learn-postgres-demo
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

Change database connection data in file ./learn-postgres-demo/ini/database.ini

Open in browser http://localhost/learn-postgres-demo/

If you use this project in the external network, be sure to restrict the right to read a file database.ini
