##VIDEO 54

ako buildit query lepsie v CORE bez klasickeho pisania SQL

// SELECT * FROM users WHERE `name` = 'Jim' AND `year` = 1978
$result = $database->query('SELECT * FROM users WHERE', [
	'name' => $name,
	'year' => $year,
]);


// SELECT * FROM users WHERE `name` = 'Jim' OR `year` = 1978
$result = $database->query('SELECT * FROM users WHERE ?or', [
	'name' => $name,
	'year' => $year,
]);


// SELECT * FROM users WHERE `name` <> 'Jim' AND `year` > 1978
$result = $database->query('SELECT * FROM users WHERE', [
	'name <>' => $name,
	'year >' => $year,
]);


// SELECT * FROM users WHERE
//   `name` IN ('Jim', 'Jack') AND `role` NOT IN ('admin', 'owner')
$result = $database->query('SELECT * FROM users WHERE', [
	'name' => ['Jim', 'Jack'],
	'role NOT IN' => ['admin', 'owner'], // výčet + operátor NOT IN
]);


// SELECT * FROM users WHERE (`name` = 'Jim') AND (`year` > YEAR())
$result = $database->query('SELECT * FROM users WHERE', [
	'name' => $name,
	'year >' => $database::literal('YEAR()'),
]);