<?php

require './vendor/autoload.php';
//require_once('src/Connection.php');
//require_once('src/PostgresDemo.php');
//require_once('src/OutputTable.php');

use LearnPSQL\Connection as Connection;
use LearnPSQL\PostgresDemo as PostgresDemo;
 
try {
    // connect to the PostgreSQL database
    Connection::init('./ini/database.ini');
    $pdo = Connection::get()->connect();

} catch (\PDOException $e) {
    echo $e->getMessage();
    exit;
}

set_exception_handler(function ($e) {
        // Processing only PDOExceptions
        if ($e instanceof PDOException) {
            echo "<h3>Database error:</h3>".$e->getMessage();
        } else {
            throw $e;//do not process other exceptions
        }
});
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Learn PostgreSQL. Demo</title>
        <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
    </head>
    <body>
    	<div class="container">
    	<h1>Learn PostgreSQL. Demo</h1>
<?php

$Sql = new PostgresDemo($pdo);

$Sql->loadSql('./ini/schemas.sql');

$Sql->go(
	'Персонал',"
	SELECT p.*,w.office_id,w.salary,e.vuz_id,e.finished 
	FROM work w, person p 
	LEFT JOIN edu e ON e.person_id = p.id 
	WHERE p.id = w.person_id;
	"); 

$Sql->go(
	'Все кто еще не закончил ВУЗ',"
	SELECT p.name,e.finished 
	FROM person p, edu e 
	WHERE e.person_id = p.id AND e.finished > NOW();
	");

$Sql->go(
	'Средняя ЗП по цехам персонала младше 30 лет',"
	SELECT w.office_id,ROUND(AVG(w.salary)) as avg_zp , count(p.id) as cntr
	FROM work w 
	RIGHT JOIN (
		SELECT id 
		FROM person 
		GROUP BY id 
		HAVING (DATE_PART('year',NOW())-DATE_PART('year',born))<31
	) p ON p.id=w.person_id 
 	GROUP BY w.office_id;
 	");

$Sql->go(
	'Создадим процедуру для логирования изменения зарплаты',"
	CREATE OR REPLACE FUNCTION add_to_log() RETURNS TRIGGER AS \$up_person\$
    BEGIN
    	IF NEW.salary <> OLD.salary THEN
    	INSERT INTO log(person_id,action,created)
 		VALUES(OLD.person_id,CONCAT_WS(' ','User salary changed from',OLD.salary,'to',NEW.salary),now());
 		END IF;
 		RETURN NEW;
 	END;
 	\$up_person\$ LANGUAGE plpgsql;
	");

$Sql->go(
	'Создадим триггер для фиксации изменения зарплаты',"
	CREATE TRIGGER up_person
	AFTER UPDATE ON work FOR EACH ROW EXECUTE PROCEDURE add_to_log();
	");


$Sql->go(
	'Повысить ЗП на 10% персоналу моложе 31 года',"
	UPDATE work SET 
	  salary = salary * 1.1
	FROM (
		SELECT id 
		FROM person 
		GROUP BY id 
		HAVING ( DATE_PART('year', NOW() ) - DATE_PART('year', born ) ) < 31
	) as young
	WHERE person_id = young.id
	");

$Sql->go(
	'И снова выведем персонал',"
	SELECT p.*,w.office_id,w.salary,e.vuz_id,e.finished 
	FROM work w, person p 
	LEFT JOIN edu e ON e.person_id = p.id 
	WHERE p.id = w.person_id;
	"); 

$Sql->go(
	'И выведем лог',"
	SELECT * FROM log;
	"); 

$Sql->go(
	'Найти Фибоначи рекурсией',"
	WITH recursive f as (
	    SELECT 0 as a, 1 as b
	    UNION ALL
	    SELECT b as a, a+b FROM f WHERE a < 1000
	) SELECT a FROM f
	");

$Sql->go('EXTRACT(CENTURY FROM NOW())',"SELECT EXTRACT(CENTURY FROM NOW())");



$Sql->go('Coming soon...',"SELECT",false);

?>
	</div>
</body>
</html>