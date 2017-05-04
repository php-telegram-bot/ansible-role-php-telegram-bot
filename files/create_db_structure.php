<?php
/**
 * Connect to a MySQL server and execute all queries in the passed file.
 * note: This script has no error handling, make sure the parameters are complete.
 *
 * Example call:
 * $ php create_db_structure.php \
 *   host='localhost' \
 *   user='root' \
 *   password='root' \
 *   database='my_db' \
 *   encoding='utf8mb4' \
 *   file='/path/to/queries.sql'
 */

(isset($argc) && $argc > 1) || exit(1);

// We don't need the first arg, which is the filename.
$args = array_slice($argv, 1);
$vars = [];

foreach ($args as $arg) {
    @list($key, $val) = explode('=', $arg);
    isset($key, $val) && $vars[$key] = $val;
}

try {
    $dsn     = 'mysql:host=' . $vars['host'] . ';dbname=' . $vars['database'];
    $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $vars['encoding']];

    $pdo = new PDO($dsn, $vars['user'], $vars['password'], $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $tables_before = $pdo->query('SHOW tables')->fetchAll();

    $pdo->beginTransaction();
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');
    $queries = explode(';', file_get_contents($vars['file']));
    $changes = 0;
    foreach ($queries as $query) {
        trim($query) && $pdo->exec($query);
    }
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1;');
    $pdo->commit();

    $tables_after = $pdo->query('SHOW tables')->fetchAll();

    echo $tables_before !== $tables_after ? 'Tables updated' : 'No changes';
    exit(0);
} catch (Exception $e) {
    exit(1);
} catch (Throwable $e) {
    exit(1);
}
