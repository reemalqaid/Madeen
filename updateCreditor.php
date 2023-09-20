<?php
  session_start();
  include 'connec.php';

  if(isset($_POST['save'])){

         $id = $_SESSION['id1']; //Get the id from cpp.php file
         $phone = $_POST['usermobile'];
         $email = $_POST['email'];
         $bankAcc = $_POST['card'];

         $query = "UPDATE madeen.creditior SET phone='$phone', email='$email' ,
                    bankcard='$bankAcc' WHERE nationalID='$id'";

        $result = $conn->prepare($query);
        $result->execute();
        $info =  $result->fetchAll();
         header('location: cpp.php');
        }

?>
