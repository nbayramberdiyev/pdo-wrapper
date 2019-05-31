# Simple PDO Wrapper
I don't see too much reasons to create a database wrapper (as PDO already being one), but there are still some issues to take care of. One of them is the verbosity of the code in database queries.

For example, to get a data from database, we need to call 3 methods (`prepare(), execute() and fetch()`) separately:

```
$stmt = $db->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetch();
```

In short, we need to run every single query in three steps:
1. prepare
2. execute
3. fetch

As a result, we end up repeating the same routine again and again. So, why not use neat method chaining like this and make it one line:

```
$data = $db->prepare($sql)->execute($params)->fetch();
```

Because the `execute()` method returns a *boolean*. If only it was returning statement itself instead, we were able to use neat method chaining. To fix this issue and make database queries more cleaner and simpler, I added a new method to PDO that runs both `prepare()` and `execute()` in one call.

Besides, this is **not a query builder**. Unlike many PHP programmers who have little experience with SQL, I believe that there is no need for separate methods like `select()`, `insert()`, `update()`, `delete()`, etc. to get different query results. All we need is just a simple method that accepts a query and an array of variables to be bound as parameters, and which returns a PDO statement, which makes this function extremely flexible and convenient. Because it can run *any kind of query* supported by PDO being more powerful, briefer and simpler than any number of specialized methods.

## Requirements
* PHP 7.0 or newer
* PDO extension

## Getting Started
Simply include `Database.php` to your project. Then instantiate the class with your credentials like this:

```
require 'src/Database.php';
use NB\Database;

$db = new Database('mysql:host=localhost;dbname=<database_name>;charset=utf8', '<username>', '<password>');
```

## Usage
Here are some common usage examples for data manipulation.

### Select
```
$id = 232;
$counrty = $db->run('SELECT * FROM `country` WHERE `id` = ?', [$id])->fetch();
$counrties = $db->run('SELECT * FROM `country`')->fetchAll();
```

### Insert
```
$name = 'Dummy Country';
$alpha2 = 'DC';
$alpha3 = 'DCT';
$numeric_code = 999;
$capital = 'Dummy Capital';
$db->run('INSERT INTO `country` (`name`, `alpha2`, `alpha3`, `numeric_code`, `capital`) VALUES (?, ?, ?, ?, ?)', [$name, $alpha2, $alpha3, $numeric_code, $capital]);
```

### Update
```
$name = 'Example Country';
$capital = 'Example Capital';
$id = 250;
$db->run('UPDATE `country` SET `name` = ?, `capital` = ? WHERE `id` = ?', [$name, $capital, $id]);
```

### Delete
```
$id = 250;
$db->run('DELETE FROM `country` WHERE `id` = ?', [$id]);
```