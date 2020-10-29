<?php

declare(strict_types=1);

/**
 * Include the database class.
 */
require 'src/Database.php';

use NB\Database;

/**
 * Instantiate it with your own credentials (dsn, username, password, and options).
 */
$db = new Database('mysql:host=localhost;dbname=pdo_wrapper;charset=utf8', 'root', '');

/**
 * SELECT
 * Select a row with an id of 232.
 */
$id = 232;
$counrty = $db->run('SELECT * FROM `country` WHERE `id` = ?', [$id])->fetch();
var_dump($counrty); // array(6) { ["id"]=> int(232) ["name"]=> string(12) "Turkmenistan" ["alpha2"]=> string(2) "TM" ["alpha3"]=> string(3) "TKM" ["numeric_code"]=> int(795) ["capital"]=> string(8) "Ashgabat" }

/**
 * INSERT
 * Insert a new row into the `country` table with dummy datas.
 */
$name = 'Dummy Country';
$alpha2 = 'DC';
$alpha3 = 'DCT';
$numeric_code = 999;
$capital = 'Dummy Capital';
$db->run('INSERT INTO `country` (`name`, `alpha2`, `alpha3`, `numeric_code`, `capital`) VALUES (?, ?, ?, ?, ?)', [$name, $alpha2, $alpha3, $numeric_code, $capital]);
$last_insert_id = $db->lastInsertId();
var_dump($last_insert_id); // string(3) "250"

/**
 * UPDATE
 * Update the last inserted item.
 */
$name = 'Example Country';
$capital = 'Example Capital';
$stmt = $db->run('UPDATE `country` SET `name` = ?, `capital` = ? WHERE `id` = ?', [$name, $capital, $last_insert_id]);
var_dump($stmt->rowCount()); // int(1)

/**
 * DELETE
 * Delete the last inserted row from `country` table.
 */
$stmt = $db->run('DELETE FROM `country` WHERE `id` = ?', [$last_insert_id]);
var_dump($stmt->rowCount()); // int(1)
