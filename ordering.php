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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">
  <script type="text/javascript" src="js/index.js"></script>
</head>

<body>

      <?php

       if(isset($_POST['order'])){

       include 'connec.php';

       $dbHost="localhost";
       $dbUser="root";
       $dbPass="";
       $dbName="madeen";
       $conn = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);

       $type=$_POST['checked'];
       $whole=$_POST['whole'];
       $rest = $whole;
       $finaldate= date('Y-m-d', strtotime($_POST['data']));
       $paymentway=$_POST['checkedt'];
       $reason=$_POST['textview'];
       $status="waiting";
       $message;

       $debitor = $_SESSION['id2'];

       if(!$conn){
         die('there is problem connection.. ' .mysqli_connect_error());
        }

        include 'connec.php';
        $stmt = $conn->prepare("SELECT orderID FROM madeen.order");
        $stmt->execute();
        $id1 = $stmt->fetchAll();
        $id = count($id1)+1;

        if($type == "" || $whole == "" || $finaldate == "" || $paymentway == "" || $reason == ""){

          $message= "يجب تعبيئة جميع الحقول";

        }
        else if($whole>3000)
        $message="الرجاء التأكد من المبلغ";

        else{
        $select = $conn->prepare("SELECT debitor FROM madeen.order WHERE debitor = '$debitor' and (status = 'accept' or status = 'waiting')");
        $select->execute();
        $data =$select->fetch();
        if($data){
              $message="لديك طلب سابق لم يتم سداد";
          }
        else{
          $insert= $conn->prepare("INSERT INTO madeen.order (orderID,type, whole,rest ,finaldate, reason, paymentway,debitor,status)
          VALUES ('$id','$type' , '$whole' ,'$rest','$finaldate', '$reason','$paymentway','$debitor' ,'$status')");
          $insert->execute();
          $message="تم أستلام طلبك بنجاح";
        }

     }
    }
      ?>



  <a id="logo" href="index.php"><img src="images/logo.png" alt="logo" width="150" height="100"></a>
  <nav>
    <a href="index.php">الصفحة الرئيسية</a>
    <a href="about.php">عن مدين</a>
    <a href="orderProc.php">طريقة الطلب</a>
    <a href="faq.php">الاسئلة الشائعة</a>
    <a href="dpp.php"><i class="fa fa-fw fa-user"></i> حسابي</a>
  </nav>


  <legend class="heading"><strong>تقديم الطلب</strong></legend>
  <form id="order" method="POST" action="ordering.php">
    <div class="row-2">
      <div class="colFaq1">
        <div class="forms-row">

          <h3> :السبب</h3>
          <label class="count"><input type="radio" checked="checked" name="checked" value="other" />
            أخرى
          </label>
          <label class="count"><input type="radio" checked="checked" name="checked" value="project" />
            مشروع
          </label>
          <label class="count"><input type="radio" checked="checked" name="checked" value="study" />
            دراسة
          </label>
          <label class="count"><input type="radio" checked="checked" name="checked" value="hospital" />
            علاج
          </label>
        </div>
      </div>

      <div class="colFaq2">
        <div class="forms-row">
          <div class="col-1">
            <h3>:المبلغ</h3>
          </div>
          <div class="col-2">
            <input class="count" id="whole" type="text" name="whole" onkeyup="checkWhole()"><br><br><br>
            <span id="massege1" style="color:red;"></span>
          </div>
        </div>
        <div class="forms-row">
          <div class="col-1">
            <h3>نوع السداد</h3>
          </div>
          <div class="col-2">
            <label class="count"><input type="radio" checked name="checkedt" value="أقساط" />
              أقساط
            </label>
            <label class="count"><input type="radio" name="checkedt" value="دفعة كاملة"  />
              دفعة كاملة
            </label>
          </div>
        </div>
        <div class="forms-row">
          <div class="col-1">
            <h3>تاريخ السداد</h3>
          </div>
          <div class="col-2">
            <input class="count" type="date" id="date" name="data" value="data">
          </div>
        </div>
      </div>
      <div class="forms-row">
        <h3><strong>تفاصيل السبب</strong></h3>
        <textarea id="textview" name="textview" value="textview" rows="10" cols="80"></textarea>
      </div>
    </div>

    <div class="forms-row col-3">
    <b id="cardmsg">  <?php
          if(isset($message)){
            if(!empty($message)) {
                    echo $message ;
                }
          }
           ?> </b>
      <input class=" button" type="submit" name="order" value="تقديم الطلب" onclick="window.location.href = 'dpp.php';">
    </div>
  </form>


  <footer>
    <small>جميع الحقوق محفوظة 2021</small><br>
    <a href="contactUs.php">تواصل معنا</a>
    <a href="faq.php">الاسئلة الشائعة</a>
  </footer>
  <script type="text/javascript" src="js/index.js"></script>
</body>
