DROP TABLE person;
CREATE TABLE IF NOT EXISTS person (
	id        serial PRIMARY KEY, 
    name      varchar(255),
    born      date
);
DROP TABLE work;
CREATE TABLE IF NOT EXISTS work (
	id        serial PRIMARY KEY,
    office_id int, 	 
    person_id int, 
    salary    int
);
DROP TABLE edu;
CREATE TABLE IF NOT EXISTS edu (
	id        serial PRIMARY KEY, 
    vuz_id    int, 
    person_id int, 
    finished  date
);
DROP TABLE log;
CREATE TABLE IF NOT EXISTS log (
    id        serial PRIMARY KEY, 
    person_id int,
    action    text, 
    created   timestamp(6)
);

INSERT INTO person VALUES 
	(1,'Nick','1977-01-01'),(2,'Pit','1988-02-01'),(3,'Mick','1999-04-01'),(4,'Andy','1987-11-07'),(5,'John','1984-07-21'),(6,'Alex','1979-10-08'),(7,'Mary','1983-09-21'),(8,'Lizy','1995-04-21'),(9,'Kate','1977-01-31');
INSERT INTO work VALUES 
	(1,1,1,50000),(2,1,2,60000),(3,3,3,70000),(4,2,4,80000),(5,1,5,50000),(6,2,6,60000),(7,2,7,10000),(8,1,8,100000),(9,2,9,10000);
INSERT INTO edu VALUES 
	(1,1,1,'2017-01-01'),(2,2,2,'2013-05-01'),(3,1,3,'2014-03-01'),(4,3,4,'2015-08-01'),(5,1,5,'2016-07-01'),(6,1,6,'2018-07-01'),(7,4,7,'2019-07-01');
