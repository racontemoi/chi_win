<?php
/*
###############################################################################
# Name: move_servers.php
# Developed By: The Uniform Server Development Team
# Modified Last By: Mike Gleaves (Ric)
# Web: http://www.uniformserver.com
# V1.0 12-6-2009
# Comment: Alows multi-servers to run on same PC.
# Moves Server to different ports changes service names
###############################################################################
*/
#error_reporting(0); // Disable PHP errors and warnings
                      // Comment to Enable for testing

chdir(dirname(__FILE__)); // Change wd to this files location
include_once "../main/includes/config.inc.php";
include_once "../main/includes/functions.php";


run_location_tracker();   // Have servers moved if moved
                          // update configuration accordingly
print "\n";

//=== Both servers must be stopped and not installed as a service =============

if(get_apache_tracker() != "free" || get_mysql_tracker() != "free"){
  print " This script was terminated!\n\n";
  print " The servers are either running or installed as a service.\n";
  print " Please stop and uninstall the servers\n\n";
  print " Then run this script again.\n\n"; 
  exit;
}

print " ##############################################################################################\n";
print " #                                                                                            #\n";
print " # Uniform Server: Move Server to different ports change service name                         #\n";
print " #                                                                                            #\n";
print " #--------------------------------------------------------------------------------------------#\n";
print " # This script must be run on a clean server                                                  #\n";
print " #                                                                                            #\n";
print " # 1) To accept defaults [shown in square brackets] press enter                               #\n";
print " #                                                                                            #\n";
print " #--------------------------------------------------------------------------------------------#\n\n";

 //# == Var used
 $avoid1 ='135';                # Avoid this port
 $avoid2 ='445';                # Avoid this port

 // Old and proposed new

 $Apache_port_old = get_apache_port();                # Server port
 $Apache_port = $Apache_port_old + 1;                 # New Server port

   # Avoid these ports
   if($Apache_port == $avoid1 || $Apache_port == $avoid2){
     $Apache_port = $Apache_port+1;
   }

 $Apache_ssl_port_old = get_apache_ssl_port();        # SSL Server port
 $Apache_ssl_port = $Apache_ssl_port_old +1;          # New SSL Server port

   # Avoid these ports
   if($Apache_ssl_port == $avoid1 || $Apache_ssl_port == $avoid2){
     $Apache_ssl_port = $Apache_ssl_port+1;
   }

 $Apache_name_old = get_apache_exe();                 # Apache executable name
                                                      # New Apache executable name
 if(preg_match("/([a-zA-Z]+)(\d*)(\.exe)/", $Apache_name_old, $matches)){  
   $Apache_name =  $matches[1].($matches[2]+1).$matches[3];                                     
 }

 $Apache_service_name_old = $us_apache_service_name;  # Apache original service name
                                                      # Apache New service name
 if(preg_match("/([a-zA-Z]+)(\d*)/", $Apache_service_name_old, $matches)){  
   $Apache_service_name =  $matches[1].($matches[2]+1);                                     
 }

 $MySQL_port_old = get_mysql_port();                  # Server port
 $MySQL_port = $MySQL_port_old+1;                     # New Server port

   # Avoid these ports
   if($MySQL_port == $avoid1 || $MySQL_port == $avoid2){
     $MySQL_port = $MySQL_port+1;
   }

 $MySQL_name_old = get_mysql_exe();                   # MySQL executable name
                                                      # New MYSQL executable name
 if(preg_match("/([a-zA-Z\-]+)(\d*)(\.exe)/", $MySQL_name_old, $matches)){  
   $MySQL_name=  $matches[1].($matches[2]+1).$matches[3];                                     
 }

 $MySQL_service_name_old = $us_mysql_service_name;    # MySQL original service name
                                                      # MySQL service name
 if(preg_match("/([a-zA-Z]+)(\d*)/", $MySQL_service_name_old, $matches)){  
   $MySQL_service_name =  $matches[1].($matches[2]+1);                                     
 }

 // UniTray

 $UniTray_name_old = get_unitray_exe();               # UniTray executable name
                                                      # New UniTray executable name
 if(preg_match("/([a-zA-Z]+)(\d*)(\.exe)/", $UniTray_name_old, $matches)){  
   $UniTray_name =  $matches[1].($matches[2]+1).$matches[3];                                     
 }

 $old_id = $matches[2]; // General reference                     

#== Get user inputs ============================================================================================

#== Get user inputs

$Apache_port     = prompt_user(" Current Apache port = $Apache_port_old         Proposed port ", $Apache_port);

// Avoid these ports
if($Apache_port == $avoid1 || $Apache_port == $avoid2){
 print "\n == Note: You cannot use ports $avoid1 or $avoid2!\n Please enter a new value\n\n";
  while($Apache_port == $avoid1 || $Apache_port == $avoid2){
    $Apache_port     = prompt_user(" Current Apache port = $Apache_port_old         Proposed port ", $Apache_port+1);
    print "\n";
  }
}

$Apache_ssl_port = prompt_user(" Current SSL port    = $Apache_ssl_port_old        Proposed port ", $Apache_ssl_port);

// Avoid these ports
if($Apache_ssl_port == $avoid1 || $Apache_ssl_port == $avoid2){
 print "\n == Note: You cannot use ports $avoid1 or $avoid2!\n Please enter a new value\n\n";
  while($Apache_ssl_port == $avoid1 || $Apache_ssl_port == $avoid2){
    $Apache_ssl_port     = prompt_user(" Current SSL port = $Apache_ssl_port_old         Proposed port ", $Apache_ssl_port+1);
    print "\n";
  }
}

$MySQL_port      = prompt_user(" Current MySQL port  = $MySQL_port_old       Proposed port ", $MySQL_port);
# Avoid these ports
if($MySQL_port == $avoid1 || $MySQL_port == $avoid2){
 print "\n == Note: You cannot use ports $avoid1 or $avoid2!\n Please enter a new value\n\n";
  while($MySQL_port == $avoid1 || $MySQL_port == $avoid2){
    $MySQL_port     = prompt_user(" Current MySQL port = $MySQL_port_old         Proposed port ", $MySQL_port+1);
    print "\n";
  }
}

// All three ports must be unique abort if not
if($Apache_port == $Apache_ssl_port or $MySQL_port == $Apache_port or $MySQL_port == $Apache_ssl_port){
 print "\n NOTE: All ports must be unique rerun this script again\n\n";
 exit;
}

$Apache_name     = prompt_user(" Current Apache name = $Apache_name_old Proposed name ", $Apache_name);

$MySQL_name      = prompt_user(" Current MySQL name  = $MySQL_name_old  Proposed name ", $MySQL_name);

print "\n ===== SERVICES Service names ==== \n\n";                                            

$Apache_service_name = prompt_user(" Current Apache name = $Apache_service_name_old Proposed name = ", "$Apache_service_name");
$MySQL_service_name  = prompt_user(" Current MySQL  name = $MySQL_service_name_old  Proposed name = ", "$MySQL_service_name");


print "\n\n ===== UniTray Controller  ==== \n"; 

$UniTray_name     = prompt_user(" Current UniTray name = $UniTray_name_old Proposed name ", $UniTray_name);

print "\n\n ===== eAccelerator  ==== \n"; 
print "\n If running a single server do not disable eAccelerator.\n For multi-servers enter Y \n\n"; 
$Disable_eAccelerator = prompt_user(" Disable_eAccelerator type Y or N ", "Y");

print "\n";

$commit  = prompt_user(" Commit type Y or N ", "Y");

if($commit != "Y"){
  print "\n No action taken\n\n";
  exit;
}

//=============== UPDATE UniTray ==========================
if (unitray_running()){        // Is Unitray running
  stop_unitray();              // yes: kill it
  $unitray_was_running =true;  // set tacker
}
else{                          // no: 
  $unitray_was_running =false; // reset tacker
}

 //Extract new id
 if(preg_match("/([a-zA-Z]+)(\d*)(\.exe)/", $UniTray_name, $matches)){  
   $new_id =  $matches[2];                                     
 }

 // Rename UniTray exe
 copy($us_con_tray_menu."/".$UniTray_name_old, $us_con_tray_menu."/".$UniTray_name); // New file
 unlink($us_con_tray_menu."/".$UniTray_name_old);                                    // Delete old

 // Rename UniTray ini
 $old_ini = $us_con_tray_menu."/UniTray".$old_id.".ini";
 $new_ini = $us_con_tray_menu."/UniTray".$new_id.".ini";

 // Copy new file and delete old one
 copy($old_ini,$new_ini);                          // New file
 unlink($old_ini); 

 //=== Update ini file

 // New ID
 $s_str = "ID=UniTrayController".$old_id;     // Unitray ID
 $s_str = preg_quote($s_str,'/');             // Convert to regex format
 $s_str = '/'.$s_str.'/';                     // Create regex pattern
 $r_str = "ID=UniTrayController".$new_id;
 file_search_replace($new_ini,$s_str,$r_str); // Update file

 // SET new tray icon
 $s_str = "tray_image_".$old_id.".dat";       // Unitray ID
 $s_str = preg_quote($s_str,'/');             // Convert to regex format
 $s_str = '/'.$s_str.'/';                     // Create regex pattern
 $r_str = "tray_image_".$new_id.".dat";
 file_search_replace($new_ini,$s_str,$r_str); // Update file

if ($unitray_was_running){  // It was running
  start_unitray();          // Restart with new values
}

//=============== UPDATE SERVER ============================

// Note: Assumes there will be a version for PHP 5.3?
if($Disable_eAccelerator == "Y"){
  file_search_replace($usf_php_ini,"/extension\=eaccelerator\.dll/",";extension=eaccelerator.dll");
  file_search_replace($usf_php_ini,"/eaccelerator\.allowed/",";eaccelerator.allowed");
  file_search_replace($usf_php_ini,"/eaccelerator\.debug/",";eaccelerator.debug");

  file_search_replace($usf_php_ini_prod,"/extension\=eaccelerator\.dll/",";extension=eaccelerator.dll");
  file_search_replace($usf_php_ini_prod,"/eaccelerator\.allowed/",";eaccelerator.allowed");
  file_search_replace($usf_php_ini_prod,"/eaccelerator\.debug/",";eaccelerator.debug");

  file_search_replace($usf_php_ini_dev,"/extension\=eaccelerator\.dll/",";extension=eaccelerator.dll");
  file_search_replace($usf_php_ini_dev,"/eaccelerator\.allowed/",";eaccelerator.allowed");
  file_search_replace($usf_php_ini_dev,"/eaccelerator\.debug/",";eaccelerator.debug");
}

// Update main control file config.inc.php with new service names
// Update Apanel control file config.inc.php with new service names

  $s_str = $MySQL_service_name_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($us_con_main."/includes/config.inc.php",$s_str,$MySQL_service_name);
  file_search_replace($us_apanel."/includes/config.inc.php",$s_str,$MySQL_service_name);

  $s_str = $Apache_service_name_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($us_con_main."/includes/config.inc.php",$s_str,$Apache_service_name);
  file_search_replace($us_apanel."/includes/config.inc.php",$s_str,$Apache_service_name);


// Rename Apache and MySQL executable files

  copy($us_apache_bin."/$Apache_name_old",$us_apache_bin."/$Apache_name"); // New 
  unlink($us_apache_bin."/$Apache_name_old");                              // Delete old

  copy($us_mysql_bin."/$MySQL_name_old",$us_mysql_bin."/$MySQL_name"); // New 
  unlink($us_mysql_bin."/$MySQL_name_old");      

// Update Apache config with new ports
  $r_str = "Listen ".$Apache_port;
  $s_str = "Listen ".$Apache_port_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($usf_apache_cnf,$s_str,$r_str);

  $r_str = "Listen ".$Apache_ssl_port;
  $s_str = "Listen ".$Apache_ssl_port_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($usf_apache_ssl_cnf,$s_str,$r_str);

  $r_str = ":".$Apache_port;
  $s_str = ":".$Apache_port_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($usf_apache_cnf,$s_str,$r_str);

  $r_str = ":".$Apache_ssl_port;
  $s_str = ":".$Apache_ssl_port_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($usf_apache_ssl_cnf,$s_str,$r_str);


// Update MySQL config with new port
  $r_str = "port=".$MySQL_port;
  $s_str = "port=".$MySQL_port_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($usf_my_ini,$s_str,$r_str);

// Update MySQL small config with new port
  $r_str = "port=".$MySQL_port;
  $s_str = "port=".$MySQL_port_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($usf_small_my_ini,$s_str,$r_str);

// Update MySQL medium config with new port
  $r_str = "port=".$MySQL_port;
  $s_str = "port=".$MySQL_port_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($usf_medium_my_ini,$s_str,$r_str);

// Update Apanel redirect.html to new port 
  $r_str = ":".$Apache_port;
  $s_str = ":".$Apache_port_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($usf_redirect,$s_str,$r_str);

// Update Apanel redirect2.html to new port 
  $r_str = ":".$Apache_port;
  $s_str = ":".$Apache_port_old;
  $s_str = preg_quote($s_str,'/');        // Convert to regex format
  $s_str = '/'.$s_str.'/';                // Create regex pattern
  file_search_replace($usf_redirect2,$s_str,$r_str);

//=============== END UPDATE SERVER ========================

print " Server ports have been changed and services renamed \n\n";


exit;
?>