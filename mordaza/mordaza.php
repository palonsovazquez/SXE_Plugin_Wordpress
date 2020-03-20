<?php 
/**
 * @package plugin test
 * @version 0.01
 */
/*
Plugin Name: mordaza
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This is not just a plugin, it symbolizes the represion of people.
Author: Pablo Alonso
Version: 0.1
Author URI: 
*/

function pluginInitsql(){
global $wpdb;

$charset_collate = $wpdb->get_charset_collate();

// le añado el prefijo a la tabla
$table_name = $wpdb->prefix . 'censoredwords';

// creamos la sentencia sql
//CREATE TABLE `wordpress`.`wp_testttt` ( `AFDSAFD` VARCHAR(40) CHARACTER SET ucs2 COLLATE ucs2_spanish_ci NOT NULL AUTO_INCREMENT , UNIQUE `INDICE` (`AFDSAFD`)) ENGINE = InnoDB; 
$sql = "CREATE TABLE $table_name ( wordID int PRIMARY KEY NOT NULL AUTO_INCREMENT, `word` VARCHAR(40) NOT NULL UNIQUE   ) ";
//create table 'xxxx' (wordID int PRIMARY KEY NOT NULL,      word varchar(25) NOT NULL UNIQUE); 

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
$palabrasMalsonantes = ["capullo","damian","puto"];
foreach ($palabrasMalsonantes as $value)
   {

dbDelta("INSERT INTO $table_name (`word`) VALUES ('$value')" );
}
}

add_action('plugins_loaded', 'pluginInitsql');




function censor($text){
    global $wpdb;
    $wpdb->show_errors;
    $charset_collate = $wpdb->get_charset_collate();

// le añado el prefijo a la tabla
$table_name = $wpdb->prefix . 'censoredwords';

  $listaProhibidas = ["aaaa"];  
  $sqlpre = "SELECT word FROM wordpress.".$table_name;
//  echo "  ".$sqlpre."    ";
   $results = $wpdb->get_results( "SELECT wordID,word FROM ".$table_name." " );
   
   if($wpdb->last_error !== '') :
    echo $wpdb->print_error();
    endif;
   
 
   foreach ($results as $asss){
      array_push($listaProhibidas, $asss->word);
       
       
   }
  
   



        return   str_replace( $listaProhibidas, ' **** ', $text );
    
    
}
add_filter( 'the_content', 'censor' );







?>