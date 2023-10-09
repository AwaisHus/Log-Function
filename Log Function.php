// ============================================ Log Function ==================================================

/**
 * Functions connects to database, grabs user IP, MAC address, and Email if session set.
 * It also displays a logging message.
 * 
 * @param string $log Message to be displayed in logs.
 * @param mysqli $connect The connection we execute querries over.
 * 
 * @param bool $return 1 if query succeeded, 0 if error occured.
 */
function logger($log, $connect)
{

  //Make file if it does not exist--------------------------------------------
  if (!file_exists('../log.txt'))  //Minimises chance of WGET data breach
    file_put_contents('../log.txt', ''); //Write data to the file

  //Grabbing Tracking Information---------------------------------------------
  $ip = $_SERVER['REMOTE_ADDR']; //Retrieve client ip address
  date_default_timezone_set('Etc/GMT0'); //Setting UK Timezone
  $date = date('Y-m-d'); //Date
  $time = date('H:i:s'); //Time

  if (isset($_SESSION['userID']))  //Checks User ID 
    $userID = $_SESSION['userID'];
  else
    $userID = "Null/Guest";


  if (isset($_SESSION['userEmail']))  //Checks UserEmail 
    $userEmail = $_SESSION['userEmail'];
  else
    $userEmail = "Null/Guest";


  if (isset($_SESSION['userType']))  //Checks User Type
    $userType = $_SESSION['userType'];
  else
    $userType = "Null";



  //Retrieving MAC Address----------------------------------------------------
  ob_start(); //Turn on output buffering
  system('ipconfig /all'); //Execute external program to display output
  $mycom = ob_get_contents(); //Capture the output into a variable
  ob_clean(); //Clean/erase the output buffer
  $findme = "Physical";
  $pmac = strpos($mycom, $findme); // Find the position of Physical text
  $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address


  //Reads file to a string----------------------------------------------------
  $contents = file_get_contents('../log.txt');
  //Arranging Tracking Information to our log file
  $contents .= "User ID: $userID\nMAC Address: $mac\nIP Address: $ip\nLog: $log\nDate: $date\nTime: $time\nEmail: $userEmail\r\n\n";
  //Appending the contents to the file
  file_put_contents('../log.txt', $contents);