<?php

$b_debugmode = 1; // 0 || 1
$system_operator_mail = 'corycubbage@gmail.com';
$system_from_mail = 'SHADOWORLDPBP@shadoworld.org';
            
function db_query( $query ){
  global $b_debugmode;
  
  // Perform Query
  $result = mysql_query($query);

  // Check result
  // This shows the actual query sent to MySQL, and the error. Useful for debugging.
  if (!$result) {
    if($b_debugmode){
      $message  = '<b>Invalid query:</b><br>' . mysql_error() . '<br><br>';
      $message .= '<b>Whole query:</b><br>' . $query . '<br><br>';
      die($message);
    }

    raise_error('db_query_error: ' . $message);
  }
  return $result;
}

function raise_error( $message ){
    global $system_operator_mail, $system_from_mail;

    $serror=
    "Env:       " . $_SERVER['SERVER_NAME'] . "\r\n" .
    "timestamp: " . Date('m/d/Y H:i:s') . "\r\n" .
    "script:    " . $_SERVER['PHP_SELF'] . "\r\n" .
    "error:     " . $message ."\r\n\r\n";

    // open a log file and write error
    $fhandle = fopen( '/logs/errors'.date('Ymd').'.txt', 'a' );
    if($fhandle){
      fwrite( $fhandle, $serror );
      fclose(( $fhandle ));
     }
  
    // e-mail error to system operator
    if(!$b_debugmode)
      mail($system_operator_mail, 'error: '.$message, $serror, 'From: ' . $system_from_mail );
    
    header('HTTP/1.0 400 Bad Request', true, 400);
    echo     "SQL ERROR: " . $sql;
  }

    sleep(1);   //delay (for debug only)
    
    $uid = $_POST['pk'];                    // You will get 'pk', 'name' and 'value' in $_POST array.
    $name = $_POST['name'];
    $value = $_POST['value'];
    
    /*
     Check submitted value
    */
    if(!is_null($value) && (!empty($name)) && (!empty($uid))) {
        
        if ($name == "buffs_debuffs") {
            $final_value = json_encode($value, JSON_FORCE_OBJECT);            
        }
        else {
            $final_value = $value;           
        }
        
        include('config.php');
        define('USER_VARIABLE_TABLE', $table_prefix . 'user_variable');
        $con = mysql_connect($dbhost, $dbuser, $dbpasswd, $dbname);
        mysql_select_db($dbname);
        
        $sql = 'UPDATE ' . USER_VARIABLE_TABLE . ' SET ' . $name . ' = \'' . $final_value . '\' WHERE user_id = ' . $uid;
        db_query($sql);
        
        print_r($_POST);
    } else {

        if ($name == "buffs_debuffs") {
            $final_value = json_encode($value, JSON_FORCE_OBJECT);
        }
        else {
            $final_value = $value;
        }
                
        $sql = 'UPDATE ' . USER_VARIABLE_TABLE . ' SET ' . $name . ' = ' . $final_value . ' WHERE user_id = ' . $uid;
                
        header('HTTP/1.0 400 Bad Request', true, 400);
        echo "A required fileld was not present! $sql";
        
    }
?>