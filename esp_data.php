<?php 

/*  
    LISTINING TO NODEMCU POST REQUEST 
    EVERY POST REQUEST MOST BE WITH THE
    KEY AND THE SCRIPT ADD ROW TO DATABASE
    CONTAIN TAP_NUMBER AND TIME .
*/


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Key = "";
    print_r($_POST);
    $Key = $_POST['key'];
    if ($Key == "Rox01nDxb") {
      $robinet = "robinet_01";
      $conn = mysqli_connect('localhost','root','','watercloud');
      $Query = "INSERT INTO esp_data(Robinet) VALUES('$robinet')";
      if (mysqli_query($conn,$Query)) {
        echo "<br><center><h1>SUCCESS</h1></center>";
      }
      else {
        echo "SQL ERROR !";
      }
      
    }
}else {
    echo "<br><center><h1>404</h1></center>";
}




?>