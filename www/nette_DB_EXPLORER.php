<?php
##VIDEO 55/56/57/58/59/60/61

// nepouzivat fetchAll posielat selection z modelu...Preco ?
// lebo foreach si uz spravi dany dotaz do db ale v pripade ako mame v lunyse (basepresenter) robi dotaz stale pri kazdom ajaxe...ale selection pocka az sa s tym nieco bude robit a ak nie tak dotaz nespravi zbytocne

$email = 'test1';
$email2 = 'test2';
//SELECT * FROM `user` WHERE(`email` IN ('test1','test2'));
$this->db->table('user')
	->where([
		'email' => [
			$email,
			$email2,
		]
	]);


// TOTO ma dostalo

// select 1

//Spravi sa 1 dotaz z jednej tabulky bez joinu
$this->template->data = $this->db->table('testnode')
	->select('testroot_id, count(id) count')
	->group('testroot_id')
	->order('count')
	->limit(20);
//SELECT `testroot_id` count(`id`) ` count
//FROM `testnode`
// GROUP BY `testroot_id`
// ORDER BY `count`
// LIMIT(20);

//nasledne sa posle do templatu kde sa robi dalsi dotaz :
$html = '<tr n:foreach="$data as $row">
				<td>{$row->testroot->name}</td> 
				<td>{$row->count}</td>
			</tr>';
// tu sa robi te dotaz automaticky ALE ! kedze je tam limit 20 nespravi sa 20 dotazov...ale len 1 a to :
// SELECT `id`,`name`
// FROM `testroot`
// WHERE (`id` IN (IDCKA Z TEMPLATU VSETKYCH 20); a samo si to uz vyrenderuje a potriedi
// v test root mal 2 mil zaznamov a v testnode 10mil zaznamov a prvy dotaz tva 5s a druhy 0.4s = 5.5s zaokruhlene


// select 2
$this->db->table('testroot')
	->select('testroot.name,count(:testnode.id) count') //tu sa joinuje :testnode.id kde si nette tiez hlada parik samozrejme musi byt nastaveny constraint v db s tym sa pocita
	->order('count') //popripade ak je viac testnode klucov v tabulke tak (:testnode(user).id)
	->group('testroot.id') //dvojbodka je ak je viacero hodnot na jednu v druhej tabulke (one to many)
	->limit(20); //a .bodka  uz je klasika(one to one)
// SELECT `testroot`.`name`, count(`testnonde`.`id`) `count`
// FROM `testroot`
// LEFT JOIN `testnode` ON `testroot`.`id` = `testnode`.`testroot_id`
// GROUP BY `testroot_id`
// ORDER BY `count`
// LIMIT(20);

//pri rovnakych podmienkach ako hore :
$html = '<tr n:foreach="$data as $row">
<td>{$row->testroot->name}</td> 
<td>{$row->count}</td>
</tr>';
//tu sa len delia vytiahnute zaznamy nerobi sa dalsi dotaz
// tento dotaz na db trval cez 7.5 sekundy na prvykrat a potom nieco malo cez 7
// CIZE JE RYCHLEJSIE NECHAT ROBIT NETTE DOTAZY SAMO

//ako robit joiny
$this->db->table('user')
	->alias(':user_x_role.role', 'r') //tento alias je jak keby dole bolo popisane :user_x_role.role.name / :user_x_role.role.id 
	->where('r.name', 'guest')
	->where('r.id', 1);
//select spravi alias ale len na tabulku v ktorej ho je realne treba
// SELECT * FROM `user`
// LEFT JOIN `user_x_role` on `user`.`id` = `user_x_id`.`user_id`
// LEFT JOIN `role` `r` ON `user_x_role`.`role_id` = `r`.`id`
// WHERE (`r`.`name` = `guest`) AND (`r`.`id` = 1);

//DELETE
$this->db->table('role')
	->get(9) //tento get spravi najprv select a vytiahne ActiveRow a potom na nom spravi delete preto ak ten active row nepotrebujeme treba pouzit variantu nizsie
	->delete();

$this->db->table('role')
	->where('id', 9) //toto spravi len delete samotny
	->delete();

// TRANSAKCIE 
try {
	$inserted = $this->db->transaction([$this, 'transaction']); // tento callback v db metode transaction v pripade ze odchyti chybu
} catch (Exception $e) { //urobi $this->db->rollback();
	echo $e; //co vrati stav db do povodnej pred zacatim transakcie, ak chyba nenastane tak sa vsetko pospravnosti spravi
}

function transaction()
{
	$inserted = $this->db->table('role')
		->insert([
			'name' => 'abc',
		]);
	// throw new Exception(); vyhodenie chyby

	return $inserted;
}

//MULTIINSERT
$roles = [
	[
		'name' => 'abc',
	],
	[
		'name' => 'def',
	],
	[
		'name' => 'ghi',
	]
];

$this->db->table('role')->insert($roles);

