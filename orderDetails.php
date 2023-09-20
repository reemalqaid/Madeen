<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
session_start();
?>

<head>
  <meta charset="utf-8">
  <title>الطلبات</title>
  <link rel="icon" href="images/logo.png">
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script type="text/javascript">
    function reg(idp) {
      $.ajax({
        url: 'orderDetails.php',
        type: 'POST',
        data: {idp: idp},
        success: function(data) {
          console.log(data);
        }
      });
    };
  </script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">
</head>

<body>

  <a id="logo" href="index.php"><img src="images/logo.png" alt="logo" width="150" height="100"></a>
  <nav>
    <a href="index.php">الصفحة الرئيسية</a>
    <a href="about.php">عن مدين</a>
    <a href="orderProc.php">طريقة الطلب</a>
    <a href="faq.php">الاسئلة الشائعة</a>
    <a href="cpp.php"><i class="fa fa-fw fa-user"></i> حسابي</a>
  </nav>

  <!-- Start -->
  <h1 class="heading centeral-heading"> الطلبات </h1>

  <!-- button for filtering -->
  <div id="myBtnContainer" style="text-align:center;">
    <button class="btn active" onclick="filterSelection('all')"> الكل</button>
    <button class="btn" onclick="filterSelection('study')"> دراسة</button>
    <button class="btn" onclick="filterSelection('hospital')"> علاج</button>
    <button class="btn" onclick="filterSelection('project')"> مشاريع</button>
    <button class="btn" onclick="filterSelection('other')"> آخرى</button>
  </div>

  <!-- list of card orders-->
  <?php

  include 'connec.php';
  $stmt = $conn->prepare("SELECT * FROM madeen.order WHERE status= 'waiting'");
  $stmt->execute();
  $result = $stmt->fetchAll();

  if (empty($result)) {
    echo '<h1 class="heading centeral-heading">لاتوجد طلبات</h1>';
  } else {
    echo '<div class="row">';

    foreach ($result as $i) {
      // code...
      $type = $i["type"];
      $link = "images/$type.png";
      $id = $i["orderID"];
      echo '
        <div class="col">
          <div class="order-card ' . $type . '">
            <img src="' . $link . '" alt="' . $type . '">
            <label><strong> <input class="input" value="' . $i["orderID"] . '" />:رقم الطلب</strong></label><br>
            <label><input class="input" value="' . $i["whole"] . '" /> :المبلغ</label><br>
            <label><input class="input" value="' . $i["paymentway"] . '" /> :نوع الدفع</label><br>
            <a href="#order-' . $type . '" onclick="document.getElementById(&quot;id0' . $id . '&quot;).style.display=&quot;block&quot;">مساندة الحالة</a>
          </div>
        </div>

        <div id= "id0' . $id . '" class="modal">
          <span onclick="document.getElementById(&quot;id0' . $id . '&quot;).style.display=&quot;none&quot;" class="close" title="Close Modal">&times;</span>
          <form action="orderDetails.php" method="post">
            <div class="modal-content order-card ' . $type . ' animate">
              <img src="' . $link . '" alt="' . $type . '">
              <label><strong> <input on class="input" value="' . $id . '" />:رقم الطلب</strong></label><br>
              <label><input class="input" name="whole" value="' . $i["whole"] . '" /> :المبلغ</label><br>
              <label><input class="input" value="' . $i["paymentway"] . '" /> :نوع الدفع</label><br>
              <label><input class="input" value="' . $i["reason"] . '" />:السبب</label><br>
              <button class="button" onclick="reg(' . $id . ');"/>مساندة الحالة</button>
              </div>
          </form>
      </div>';
    }
  }
  ?>
  <?php

  if (isset($_POST['idp'])) {

    $r = (int)$_POST['idp'];
    $per1= $_SESSION['id1'];
    $stmt1 = $conn->prepare("UPDATE madeen.order SET status = 'accept' , creditior = $per1 WHERE orderID = $r");
    $stmt1->execute();
    $stmt2 = $conn->prepare("SELECT debitor FROM madeen.order WHERE orderID = $r");
    $stmt2->execute();
    $result1 = $stmt2->fetchAll();
    //send an email
    $per2= $result1[0]["debitor"];
    $stmt3 = $conn->prepare("SELECT email FROM madeen.creditior WHERE nationalID = $per1");
    $stmt4 = $conn->prepare("SELECT email FROM madeen.debitor WHERE nationalID = $per2");
    $stmt3->execute();
    $stmt4->execute();
    $mail1=$stmt3->fetchAll();
    $mail2=$stmt4->fetchAll();
    $msg1 = "تمت المساندة شكرا لكم";
    $msg2 = "مبارك تمت مساندتكم وتحويل المبلغ";
    mail($mail1[0],"مدين",$msg1);
    mail($mail2[0],"مدين",$msg2);
  }
  ?>

  <footer>
    <small>جميع الحقوق محفوظة 2021</small><br>
    <a href="contactUs.php">تواصل معنا</a>
    <a href="faq.php">الاسئلة الشائعة</a>
  </footer>
  <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
