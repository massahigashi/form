<?php
 require('function.php');
 if(!empty($_SESSION)) {
     debug('セッションがあります');
     debug('セッションの中身：'.print_r($_SESSION,true));
     $name = $_SESSION['name'];
     $email = $_SESSION['email'];
     $text = $_SESSION['text'];
 }
  

  if(!empty($_POST)) {
     debug('ポスト送信があります');
     debug('ポストの中身'.print_r($_POST,true));

     $name = sanitize($_POST['name']);
     $email = sanitize($_POST['email']);
     $gender = sanitize($_POST['gender']);
     $age = sanitize($_POST['age']);
     $text = sanitize($_POST['text']);
     $agreement = sanitize($_POST['agreement']);
     
     debug('サニタイズ後：'.print_r($name,true));

     validRequired($name, 'name');
     validRequired($email, 'email');
     validRequired($gender, 'gender');
     validRequired($age, 'age');
     validRequired($text, 'text');
     validRequired($agreement, 'agreement');

     if(empty($err_msg)){
         debug('未入力なし');
         validEmail($email, 'email');
     }
     if(empty($err_msg)) {
         debug('email形式OK');
         validMaxLen($name, 'name');
         validMaxLen($email, 'email');
         validMaxLen($text, 'text');
     }

    if(!empty($_FILES['attachment_file']['tmp_name'])) {
        debug('画像データがあります');
        debug('画像データ：'.print_r($_FILES,true));

        getImage('attachment_file', 'img');
        $img = sanitize($_FILES['attachment_file']['name']);
    }

     if(empty($err_msg)) {
         debug('バリデーションOK');
         $_SESSION['name'] = $name;
         $_SESSION['email'] =$email;
         $_SESSION['gender'] =$gender;
         $_SESSION['age'] =$age;
         $_SESSION['text'] =$text;
         $_SESSION['agreement'] = $agreement;
         if(!empty($img)) {
             $_SESSION['img'] = $img;
         }
         debug('確認ページへ遷移します');
         header("Location:confirm.php");
         exit;
     }
 }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>お問い合わせ</title>
</head>
<body>
    <header id="header">
        <h1 class="title">Form</h1>
        <nav id="top-nav">
            <ul>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </nav>
    </header>
    <main id ="main">
        <section class="form-section site-width">
            <h2 class="form-title">お問い合わせフォーム</h2>
            <form action="" method="POST" class="form" enctype="multipart/form-data">

                <div class="form-container">
                    <label for="name" class="label <?php if(!empty($err_msg['name'])) echo 'err' ?>">氏名</label>
                    <div class="err-msg">
                        <?php if(!empty($err_msg['name'])) echo $err_msg['name']; ?>
                    </div>
                    <input type="text" name="name" class="name <?php if(!empty($err_msg['name'])) echo 'back-err'; ?>" value="<?php if(!empty($name)) echo $name; ?>">
                </div>

                <div class="form-container">
                    <label for="email" class="label <?php if(!empty($err_msg['email'])) echo 'err' ?>">メールアドレス</label>
                       <div class="err-msg">
                        <?php if(!empty($err_msg['email'])) echo $err_msg['email']; ?>
                    </div>
                    <input type="text" name="email" class="email <?php if(!empty($err_msg['email'])) echo 'back-err'; ?>" value="<?php if(!empty($email)) echo $email; ?>">
                </div>

                <div class="form-container">
                    <label for="gender_male" class="<?php if(!empty($err_msg['gender'])) echo 'err' ?>">性別</label>
                       <div class="err-msg">
                        <?php if(!empty($err_msg['gender'])) echo $err_msg['gender']; ?>
                    </div>
                    <label>男性
                     <input type="radio" name="gender" class="gender <?php if(!empty($err_msg['gender'])) echo 'back-err'; ?>" value="male">
                    </label>
                    <label>女性
                     <input type="radio" name="gender" class="gender <?php if(!empty($err_msg['gender'])) echo 'back-err'; ?>" value="female">
                    </label>
                </div>

                <div class="form-container">
                    <label for="age" class="age <?php if(!empty($err_msg['age'])) echo 'err' ?>">年齢</label>
                       <div class="err-msg">
                        <?php if(!empty($err_msg['age'])) echo $err_msg['age']; ?>
                    </div>
                    <select name="age" id="">
                        <option value="">選択してください</option>
                        <option value="1">~１９歳</option>
                        <option value="2">２０歳〜３９歳</option>
                        <option value="3">４０歳〜４９歳</option>
                        <option value="4">５０歳〜５９歳</option>
                        <option value="5">６０歳</option>
                    </select>
                </div>

                <div class="form-container">
                    <label for="text" class="text <?php if(!empty($err_msg['text'])) echo 'err' ?>">お問い合わせ内容</label>
                       <div class="err-msg">
                        <?php if(!empty($err_msg['text'])) echo $err_msg['text']; ?>
                    </div>
                    <textarea name="text" cols="50" rows="3" class="textarea <?php if(!empty($err_msg['text'])) echo 'back-err'; ?>" value="<?php if(!empty($text)) echo $text; ?>"> </textarea>
                </div>

                <div class="form-container">
                    <label> 画像ファイルの添付</label>
                       <div class="err-msg">
                        <?php if(!empty($err_msg['img'])) echo $err_msg['img']; ?>
                    </div>
                    <input type="file" name="attachment_file">
                </div>

                <div class="form-container">
                    <label for="agreement" class="agreement <?php if(!empty($err_msg['agreement'])) echo 'err' ?>">プライバシーポリシーに同意する</label>
                       <div class="err-msg">
                        <?php if(!empty($err_msg['agreement'])) echo $err_msg['agreement']; ?>
                    </div>
                    <input id="agreement" type="checkbox" name="agreement" class="agreement <?php if(!empty($err_msg['agreement'])) echo 'back-err'; ?>" value="1">
                </div>

                <input type="submit" name="btn-confirm" class="btn" value-"入力内容を確認する" >
            </form>
        </section>
    </main>
    <footer>&copy copy right</footer>
</body>
</html>