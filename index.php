<?php

error_reporting(-1);
ini_set('display_errors', 1);



$time_start = microtime(true);

$dbconn = pg_connect("host=localhost port=5432 dbname=serverdb user=admin");

if( !$dbconn ){
    echo 'Error, couldn\'t connect db!' ;
}


$sql = "
SELECT t1.name AS lvl1, t2.name as lvl2, t3.name as lvl3,  t4.name as lvl4,  t5.name as lvl5,  t6.name as lvl6, t7.name as lvl7, t8.name as lvl8
FROM menutest AS t1
LEFT JOIN menutest AS t2 ON t2.parentid = t1.id
LEFT JOIN menutest AS t3 ON t3.parentid = t2.id
LEFT JOIN menutest AS t4 ON t4.parentid = t3.id
LEFT JOIN menutest AS t5 ON t5.parentid = t5.id
LEFT JOIN menutest AS t6 ON t6.parentid = t6.id
LEFT JOIN menutest AS t7 ON t7.parentid = t7.id
LEFT JOIN menutest AS t8 ON t8.parentid = t8.id

WHERE t1.id = 1 ;";

$sql1 = 'select * from menutest where parentid = 4';

$result = pg_query( $dbconn, $sql1 );

$arr = array();

pg_close( $dbconn );



while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC ) ){
    $arr[] = $row;
}

function getTree( $items  ) {
    $menuTree = array();
    $refs = array();

    foreach ($items as $data) {
        $thisref = &$refs[$data['id']];

        $thisref['parentid'] = $data['parentid'];
        $thisref['name'] = $data['name'];

        if ($data['parentid'] == null) {
            $menuTree[$data['id']] = &$thisref;
        } else {
            $refs[$data['parentid']]['children'][$data['id']] = &$thisref;
        }
    }

    return $menuTree;
} 



//$tree = getTree( $arr );

$time_end = microtime( true );
$time = $time_end - $time_start;

echo 'script execution time ' . $time;

//print('<pre>');
//print_r($tree);
//die();




$sql3 =  "select t1.* from menutest as t 
    left join menutest as t1 on t1.parentid = t.id 
    left join menutest as t2 on t2.parentid = t1.id
    left join menutest as t3 on t3.parentid = t2.id
    left join menutest as t4 on t4.parentid = t3.id
    left join menutest as t5 on t5.parentid = t4.id

    left join menutest as t6 on t6.parentid = t5.id 
    left join menutest as t7 on t7.parentid = t6.id
    left join menutest as t8 on t8.parentid = t7.id
    left join menutest as t9 on t9.parentid = t8.id
    left join menutest as t10 on t10.parentid = t9.id

    left join menutest as t11 on t11.parentid = t10.id 
    left join menutest as t12 on t12.parentid = t11.id
    left join menutest as t13 on t13.parentid = t12.id
    left join menutest as t14 on t14.parentid = t13.id
    left join menutest as t15 on t15.parentid = t14.id
where t.parentid = 3";
  








