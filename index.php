<?php
//include('func.php');
//echo "String memory usage test.\n\n";
//$base_memory_usage = memory_get_usage();
//$base_memory_usage = memory_get_usage();
// 
//echo "Start\n";
//memoryUsage(memory_get_usage(), $base_memory_usage);
// 
//$a = someBigValue();
// 
//echo "String value setted\n";
//memoryUsage(memory_get_usage(), $base_memory_usage);
// 
//$a = 10000;
// 
//echo "String value unsetted\n";
//memoryUsage(memory_get_usage(), $base_memory_usage);


//$a = 19;
//
//
//$b = &$a;
//
////echo 'a - ' . $a . PHP_EOL; 
////echo 'b - ' . $b . PHP_EOL;
//
//
//
//$b++;
//
//echo 'a - ' . $a . PHP_EOL; 
//echo 'b - ' . $b . PHP_EOL;


//var_dump( $var1 );


//ini_set('display_errors', 1);
//error_reporting(-1);
//
//
//$a = array( 1 , 2 , 3 ); 
//$b =& $a ; 
//$c =& $a [ 2 ]; 
//
//xdebug_debug_zval ('refs' );

// reqursion
//function buildTree( $maxlevel, $parentid = null, $level = 0 ){
//    $level++;
//    
//    if( $level > $maxlevel )
//        return  array();
//    
//    $children = array();
//    
//    
//    for( $i = 0; $i < 4; $i++ ){
//        $children[$i] = array( 'parentid' => $parentid, 'level' => $level,  'children' => array(), );
//        $children[$i]['children'] = buildTree( $maxlevel, $i, $level );
//    }
//        
//    return $children;
//}
//
//print_r('<pre>');
//print_r( buildTree( 2 ) );

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

$sql1 = 'select * from menutest';



$result = pg_query( $dbconn, $sql );

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





  








