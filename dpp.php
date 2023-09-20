<?php
    session_start();
    include 'connec.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>حسابي</title>
  <link rel="icon" href="images/logo.png">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">
</head>

<body>

<?php

     //Get the id value from login page
     $nat2 = $_SESSION['id2'];

     //Fetching information from database by ID
     $query = "SELECT * FROM madeen.debitor WHERE nationalID =$nat2 ";
     $result = $conn->prepare($query);
     $result->execute();
     $info =  $result->fetchAll();
    ?>

  <a id="logo" href="index.php"><img src="images/logo.png" alt="logo" width="150" height="100"></a>
  <nav>
    <a href="index.php">الصفحة الرئيسية</a>
    <a href="about.php">عن مدين</a>
    <a href="orderProc.php">طريقة الطلب</a>
    <a href="faq.php">الاسئلة الشائعة</a>
    <a href="dpp.php"><i class="fa fa-fw fa-user"></i>حسابي</a>
  </nav>

  <!-- Start -->
  <h1 class="heading"><strong>الملف الشخصي</strong></h1>

 <form id="profile" action="updateDebtor.php" method="post">
    <fieldset>
      <div class="forms-row">
        <div class="col-1">
          <label for="nationalId">الهوية الوطنية</label>
        </div>

        <div class="col-2">
          <input type="text" name="nationalId" id="nationalId" value="<?php echo $nat2 ?>" disabled>
        </div>
      </div>
      <div class="forms-row">
        <div class="col-1">
          <label for="username"> اسم المستخدم</label>
        </div>
        <div class="col-2">
          <input type="text" name="usernamr" id="username" value="<?php echo $info[0]['username'] ?>" disabled>
        </div>

      </div>
      <div class="forms-row">
        <div class="col-1">
          <label for="usermobile"> رقم الهاتف</label>
        </div>
        <div class="col-2">
          <input type="tel" name="usermobile" id="usermobile" value="<?php echo $info[0]['phone'] ?>" disabled maxlength="12" onkeypress="return isNumberKey(event);" onkeyup='checkPhone();'>
          <span id="phonemsg"></span>
        </div>
      </div>
      <div class="forms-row">
        <div class="col-1">
          <label for="email"> البريد الالكتروني</label>
        </div>
        <div class="col-2">
          <input type="email" name="email" id="email"  value="<?php echo $info[0]['email'] ?>" disabled onkeyup='checkemail();'>
          <span id="emailmsg"></span>
        </div>
      </div>
      <div class="forms-row">
        <div class="col-1">
          <label for="card"> رقم البطاقة البنكية</label>
        </div>
        <div class="col-2">
          <input type="text" name="card" id="card" value="<?php echo $info[0]['bankcard'] ?>" disabled onkeypress="return isNumberKey(event);" onkeyup='checkCard();'>
        </div>
      </div>
      <div class="forms-row col-3">
        <input class="button" type="submit" name="save" value="حفظ" disabled> <button class="button" type="button" name="edit" onclick="edit_func()">تعديل</button>
      </div>
    </fieldset>
  </form>

  <?php
  include 'connec.php';
  $stmt = $conn->prepare("SELECT * FROM madeen.order WHERE debitor = $nat2 ");
  $stmt->execute();
  $result1 = $stmt->fetchAll();

  echo '<div class="forms-row">
    <div class="col-1 order-col">';

  if (empty($result1)) {
    echo '<h2 id="check" style="color: #91CEC3;">لا توجد طلبات</h2>
    </div>
  </div>';

  } else {
    echo '<h3>حالة الطلب</h3>
    </div>
  </div>
  <div class="forms-row">
  <div class="col-1 order-col">';
  foreach ($result1 as $i) {
    $id=$i['orderID'];
  echo '
      <div class="order-card order">
        <p>'.$i['orderID'].' :رقم الطلب</p>
        <p>'.$i['whole'].' :المبلغ</p>
        <p>'.$i['rest'].' :المبلغ المتبقي</p>
        <p>'.$i['status'].' :حالة الطلب</p>
        <progress value="'.$i['percentage'].'" max="100">'.$i['percentage'].'%</progress>

      </div>
    ';
    if($i['percentage']==100){
      $query = "UPDATE madeen.order SET status='complete' WHERE orderID= '$id'";
      $result = $conn->prepare($query);
      $result->execute();
      $info =  $result->fetchAll();
    }
  }
  echo '</div>
  </div>';
  }
   ?>
  <div class="forms-row order-button">
    <a href="logout.php"><button class="button ordaring" type="button" name="logout"> تسجيل الخروج </button></a>
    <a href="ordering.php"><button class="button ordaring" type="button" name="ordering">تقدم الآن</button></a>
  </div>

  <footer>
    <small>جميع الحقوق محفوظة 2021</small><br>
    <a href="contactUs.php">تواصل معنا</a>
    <a href="faq.php">الاسئلة الشائعة</a>
  </footer>
  <script src="js/index.js"></script>
</body>

</html>
