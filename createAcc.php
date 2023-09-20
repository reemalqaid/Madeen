<!DOCTYPE html>
<html>
<?php
    session_start();

    ?>
<head>
  <meta charset="utf-8" />
  <title>إنشاء حساب</title>
  <script type="text/javascript" src="js/index.js"></script>
  <link rel="icon" href="images/logo.png">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">
</head>

<body>

      <?php

      //تسجيل الدخول
       if(isset($_POST['login'])){
          include 'connec.php'; //يتصل بقاعدة البيانات
          $nat2 =$_POST['nationalId1']; //يخزن البيانات اللي دخلها اليوزر
          $pass2=$_POST['password'];
          $error ;
          $_SESSION['id']=$nat2;
          //يبحث في جدول الدائن
          $stm1 = $conn->prepare("SELECT * FROM creditior WHERE nationalID = '$nat2'");
          $stm1->execute();
          $data1 =$stm1->fetch();
          //يبحث في جدول المدين
          $stm2 = $conn->prepare("SELECT * FROM debitor WHERE nationalID = '$nat2'");
          $stm2->execute();
          $data2 =$stm2->fetch();
           if(!$data1 && !$data2){  //إذا مالقاه في الجدولين
               $error = "رقم الهوية الوطنية غير صحيح";
           }
           else if($data1) { // الهوية للدائن
              $password_hash1=$data1['password'];
               if($pass2==$password_hash1){
                    $_SESSION['id1']= $nat2 ;
               }
               else
                   $error =  "كلمة المرور غير صحيحة" ;
           }
           else if($data2){ //رقم الهوية للمدين
             $password_hash2=$data2['password'];
             if($pass2==$password_hash2){
               $_SESSION['id2']= $nat2 ;
             }
           }
           else
           $error =  "كلمة المرور غير صحيحة" ;
         }

         if(isset($_POST['change'])){
           include 'connec.php';
           $nat2 =$_POST['nationalId2'];
           $pass2=$_POST['password2'];
           $error1;
           //يبحث في جدول الدائن
           $stm1 = $conn->prepare("SELECT * FROM creditior WHERE nationalID = '$nat2'");
           $stm1->execute();
           $data1 =$stm1->fetch();
           //يبحث في جدول المدين
           $stm2 = $conn->prepare("SELECT * FROM debitor WHERE nationalID = '$nat2'");
           $stm2->execute();
           $data2 =$stm2->fetch();
           if(!$data1 && !$data2){
             $error1 = "رقم الهوية الوطنية غير صحيح";
            }
            else if($data1) { // الهوية للدائن
                $stm2 = $conn->prepare("UPDATE creditior SET password = $pass2  WHERE nationalID = '$nat2'");
                $stm2->execute();
             }
             else{//رقم الهوية للمدين
               $stm2 = $conn->prepare("UPDATE debitor SET password = $pass2  WHERE nationalID = '$nat2'");
               $stm2->execute();
           }
         }
        //إنشاء حساب كدائن
          if(isset($_POST['save1'])){
            include 'connec.php';
            $user=$_POST['username'];
            $pass=$_POST['password'];
            $pass2=$_POST['confirm_password'];
            $phone=$_POST['phone-number'];
            $mail =$_POST['email'];
            $nat =$_POST['nationalId'];
            $ban =$_POST['card-number'];
            $_SESSION['id1']=$nat;
            $errors=[];

            if($pass!=$pass2){
               $errors[]="كلمة المرور غير متطابقة";
            }

            $stm1 = $conn->prepare("SELECT nationalID FROM madeen.creditior WHERE nationalID = '$nat'");
            $stm1->execute();
            $data1 =$stm1->fetch();
            if($data1){
                $errors[]= "بيانات الهوية الوطنية موجودة بالفعل كدائن";
            }

            $stm2 = $conn->prepare("SELECT nationalID FROM madeen.debitor WHERE nationalID = '$nat'");
            $stm2->execute();
            $data2 =$stm2->fetch();
            if($data2){
                $errors[]= "بيانات الهوية الوطنية موجودة بالفعل كمدين";
            }

            if(empty($errors)) {
              $stm= $conn->prepare("INSERT INTO creditior (username , password,nationalID,phone,email,bankcard) VALUES ('$user' , '$pass' ,'$nat', '$phone','$mail','$ban')");
            $stm->execute();
            header('location:index.php');
            }

          }
            //إنشاء حساب كمدين
          if(isset($_POST['save2'])){
            include 'connec.php';
            $user1=$_POST['username'];
            $pass1=$_POST['password'];
            $pass2=$_POST['confirm_password'];
            $phone1=$_POST['phone-number'];
            $mail1 =$_POST['email'];
            $nat1 =$_POST['nationalId'];
            $ban1 =$_POST['card-number'];
            //tharaa
            $_SESSION['id2']=$nat1;

               if($pass1!=$pass2){
               $errors[]="كلمة المرور غير متطابقة";
            }

            $stm1 = $conn->prepare("SELECT nationalID FROM creditior WHERE nationalID = '$nat1'");
            $stm1->execute();
            $data1 =$stm1->fetch();
            if($data1){
                $errors[]= "بيانات الهوية الوطنية موجودة بالفعل كدائن";
            }

            $stm2 = $conn->prepare("SELECT nationalID FROM debitor WHERE nationalID = '$nat1'");
            $stm2->execute();
            $data2 =$stm2->fetch();
            if($data2){
                $errors[]= "بيانات الهوية الوطنية موجودة بالفعل كمدين";
            }

            if(empty($errors)) {
             $stm1= $conn->prepare("INSERT INTO debitor (username , password,nationalID,phone, email ,bankcard) VALUES ('$user1' , '$pass1' ,'$nat1', '$phone1','$mail1','$ban1')");
            $stm1->execute();
            header('location:index.php');
            }


          }
           ?>



  <a id="logo" href="index.php"><img src="images\logo.png" alt="logo" width="150" height="100"></a>
  <nav>
    <a href="index.php">الصفحة الرئيسية</a>
    <a href="about.html">عن مدين</a>
    <a href="orderProc.php">طريقة الطلب</a>
    <a href="faq.html">الاسئلة الشائعة</a>
    <a href="#" onclick="document.getElementById('id01').style.display='block'"><i class="fa fa-fw fa-user"></i> تسجيل الدخول</a>

  </nav>

  <div id="id01" class="modal">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>

    <div id="id1" class="modal-content animate">
      <form id="signin" action="" method="post">
        <img src="images/login.png" width="100" height="100">
        <div class="row">
          <div class="col-1">
            <label for="nationalId1"> الهوية الوطنية</label>
            <span id="massege" style="color:red; font-size:0.8em;"></span>
          </div>
          <div class="col-2">
            <input type="text" id="user_name" name="nationalId1" placeholder="أدخل رقم الهوية الوطنية " min="3" size="10" autofocus required>
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <label for="pasword1"> كلمة المرور</label>
          </div>
          <div class="col-2">
            <input type="password" id="password1" name="password1" placeholder="أدخل كلمة المرور" min="8" required>
          </div>
        </div>
        <div class="row">
          <div class="col-1">
            <label for="remember">تذكرني لاحقًا</label>
            <input type="checkbox" name="remember" value="true" checked>

          </div>
        </div>
        <div class="row">
          <div class="col-1">
            <a href="#" onclick="document.getElementById('id02').style.display='block';document.getElementById('id01').style.display='none'">نسيت كلمة المرور؟</a>
          </div>
          <b id="cardmsg">  <?php
            if(isset($error)){
              if(!empty($error)) {
                      echo '<script>checkvalid("id01","id1");</script>';
                      echo $error ;
                  }
            }
             ?> </b>
        </div>
        <div class="row">
          <div class="col-3">
            <a href="createAcc.php"><button class="button" type="button" name="button">إنشاء حساب</button></a>
            <input class="button"  type="submit" name="login" value="دخول" >
          </div>
        </div>

      </form>
    </div>
  </div>

  <div id="id02" class="modal">
    <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>

    <div id="id2" class="modal-content animate">
      <form id="forgetPass" action="" method="post">
        <img src="images/login.png" width="100" height="100">
        <div class="row">
          <div class="col-1">
            <label for="nationalId2"> الهوية الوطنية</label>
            <span id="massege1" style="color:red; font-size:0.8em;"></span>
          </div>
          <div class="col-2">
            <input type="text" id="user_name2" name="nationalId2" placeholder="أدخل رقم الهوية الوطنية " min="3" size="10" autofocus required>
          </div>
        </div>

        <div class="row">
          <div class="col-1">
            <label for="pasword2"> كلمة المرور الجديدة</label>
          </div>
          <div class="col-2">
            <input type="password" id="password2" name="password2" placeholder="أدخل كلمة المرور" min="8" required>
          </div>
          <b id="cardmsg1">  <?php
            if(isset($error1)){
              if(!empty($error1)) {
                      echo '<script>checkvalid("id02","id2");</script>';
                      echo $error1 ;
                  }
            }?>
            </b>
        </div>
        <div class="row">
          <div class="col-3">
            <input class="button" type="submit" name="change" value="تغيير" >
          </div>
        </div>

      </form>
    </div>
  </div>

  <!--start-->
  <h1 class="heading"><strong>إنشاء حساب</strong></h1>
  <form id="creatAcc" method="post" action="">
    <fieldset>
      <!--User name-->
      <div class="forms-row">
        <div class="col-1">
          <label for="username">: إسم المستخدم </label>
        </div>
        <div class="col-2">
          <input type="text" name="username" id="username" value="<?php if(isset($_POST['username'])) {echo $_POST['username'];}?>" placeholder="أدخل إسم المستخدم الرباعي" required onkeyup='checkname();' />
          <span id="usermsg">*</span>
        </div>
      </div>
      <!--National ID -->
      <div class="forms-row">
        <div class="col-1">
          <label for="nationalId">: الهوية الوطنية </label>
        </div>
        <div class="col-2">
          <input type="text" name="nationalId" id="nationalId" value="<?php if(isset($_POST['nationalId'])) {echo $_POST['nationalId'];}?>" required onkeypress="return isNumberKey(event);" onkeyup='checkId();' />
          <span id="idmsg">*</span>
        </div>
      </div>
      <!-- Password -->
      <div class="forms-row">
        <div class="col-1">
          <label for="password">: كلمة المرور </label>
        </div>
        <div class="col-2">
          <input type="password" name="password" id="password"  required onkeyup='checkpass();' />
          <span id='passmessage'></span>
          <span id='passmsg'>*</span>
        </div>
      </div>
      <!-- Confirm password -->
      <div class="forms-row">
        <div class="col-1">
          <label for="password">: تأكيد كلمة المرور </label>
        </div>
        <div class="col-2">
          <input type="password" name="confirm_password" id="confirm_password" required onkeyup='checkpass();' />
          <span id='confmessage'>*</span>
        </div>
      </div>
      <!-- Phone number -->
      <div class="forms-row">
        <div class="col-1">
          <label for="phone-number">: رقم الهاتف </label>
        </div>
        <div class="col-2">
          <input type="tel" name="phone-number" id="phone-number" value="<?php if(isset($_POST['phone-number'])) {echo $_POST['phone-number'];}?>"  required maxlength="12" placeholder="966-5000-0000" onkeypress="return isNumberKey(event);" onkeyup='checkPhone();' />
          <span id="phonemsg">*</span>
        </div>
      </div>

      <div class="forms-row">
      <div class="col-1">
        <label for="email">: البريد الالكتروني </label>
      </div>
      <div class="col-2">
        <input type="tel" name="email" id="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];}?>"  required placeholder="yourName@example.com" onkeyup='checkemail();'/>
        <span id="emailmsg">*</span>
      </div>
    </fieldset>

    <fieldset>
      <!-- Card info -->
      <div id="card-info">
        <h2 class="heading card-heading"><strong> : معلومات البطاقة البنكية </strong></h2>
      </div>

      <div class="forms-row">

        <!--Card Exp Date -->
        <input type="text" class="card-col2" name="card-exp" id="card-exp" value="<?php if(isset($_POST['card-exp'])) {echo $_POST['card-exp'];}?>" maxlength="4" placeholder="تاريخ صلاحية البطاقة" required onkeypress="return isNumberKey(event);" onkeyup='checkCard();' />
        <!--Card Name-->
        <input type="text" class="card-col1" name="card-name" id="card-name" value="<?php if(isset($_POST['card-name'])) {echo $_POST['card-name'];}?>" placeholder="الأسم المسجل على البطاقة" required onkeyup='checkCard();' />
      </div>

      <div class="forms-row">
        <!--Card CVC -->
        <input type="text" class="card-col2" name="cvc" id="cvc" value="<?php if(isset($_POST['cvc'])) {echo $_POST['cvc'];}?>" placeholder="رمز الامان" maxlength="3" required onkeypress="return isNumberKey(event);" onkeyup='checkCard();' />
        <!--Card Number -->
        <input type="text" class="card-col1" name="card-number" id="card-number" value="<?php if(isset($_POST['card-number'])) {echo $_POST['card-number'];}?>" placeholder="رقم البطاقة"maxlength="16" required onkeypress="return isNumberKey(event);" onkeyup='checkCard();' />
        <span id="cardmsg" >لن يتم استخدام البطاقة حتى تطلب مساندة أو تساند *  </span> <br>

        <b id="cardmsg">  <?php
          if(isset($errors)){
            if(!empty($errors))
                {foreach($errors as $msg){
                    echo $msg ."<br>";
                }
                }
          } ?>
            </b>

      </div>
    </fieldset>
    <div class="forms-row col-3">
      <input class="button" id="submitc" type="submit" name="save2" value="تسجيل كمدين">
      <input class="button" id="submitd" type="submit" name="save1" value="تسجيل كدائن">
    </div>
  </form>

  <footer>
    <small>جميع الحقوق محفوظة 2021</small><br>
    <a href="contactUs.html">تواصل معنا</a>
    <a href="faq.html">الاسئلة الشائعة</a>
  </footer>
  <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
