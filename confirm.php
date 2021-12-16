<?php
 require('function.php');

 if(empty($_SESSION)) {
     debug('お問い合わせフォームに遷移します.');
     header("Location:form.php");
     exit;
 }

 if(!empty($_POST['btn-confirm'])) {
     debug('セッションがあります。');
     debug('セッションの中身'.print_r($_SESSION,true));

     $header = "MIME-Version: 1.0\n";
     $header = "Content-Type: multipart/mixed;boundary=\"_BOUNDARY_\"\n";
     $header .= "From: GRAYCODE<noreply@gray-code.com>\n";
     $header .= "Reply-To: GRAYCODE<noreply@gray-code.com>\n";
     $to = $_SESSION['email'];
     $subject = 'お問い合わせありがとうございます';
     $text = <<< EOT
この度は、お問い合わせ頂き誠にありがとうございます。
下記の内容でお問い合わせを受け付けました。

お問い合わせ日時: {date("Y-m-d H:i")}
氏名: {$_SESSION['name']}
メールアドレス: {$_SESSION['email']}
GRAYCODE事務局

EOT;

     sendEmail($to, $subject, $text,$header);

     debug('送信ページへ遷移します');
     $_SESSION = array();
     header("Location:mail.php");
     exit;
 }


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>内容確認</title>
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
            <h2 class="form-title">内容確認</h2>
            <form action="" method="POST" class="form">
                <div class="form-container">
                    <label for="name" class="label">氏名</label>
                    <p class="confirm-name"><?php echo $_SESSION['name']; ?></p>
                </div>
                <div class="form-container">
                    <label for="email" class="label">メールアドレス</label>
                    <p class="confirm-email"><?php echo $_SESSION['email']; ?></p>
                </div>
                <div class="form-container">
                    <label for="gender" class="label">性別</label>
                    <p class="confirm-gender">
                         <?php if($_SESSION['gender'] == 'male') {
                           echo '男性';
                        } elseif($_SESSION['gender'] == 'female') {
                            echo '女性';
                        } 
                        ?>
                    </p>
                </div>

                <div class="form-container">
                    <label for="age" class="label">年齢</label>
                    <p class="confirm-age">
                        <?php if($_SESSION['age'] == '1') {
                           echo '~19歳';
                        } elseif($_SESSION['age'] == '2') {
                            echo '２０歳〜３９歳';
                        } elseif($_SESSION['age'] == '3') {
                            echo '４０歳〜４９歳';
                        } elseif($_SESSION['age'] == '4') {
                            echo '５０歳〜５９歳';
                        } elseif($_SESSION['age'] == '5') {
                            echo '６０歳';
                        } 

                        ?>   
                    </p>
                </div>
                <div class="form-container">
                    <label for="text" class="label">お問い合わせ内容</label>
                    <p class="confirm-text"><?php echo nl2br($_SESSION['text']); ?></p>
                </div>
                <?php if(!empty($_SESSION['img']) ):?>
                <div class="form-container">
                    <label class="label">画像ファイルの添付</label>
                    <p><img src="<?php echo FILE_DIR.$_SESSION['img'] ?>" </p>
                </div>
                <?php endif ?>
                <div class="form-container">
                    <label for="agreement" class="label">プライバシーポリシーに同意する</label>
                    <p class="confirm-agreement"><?php if($_SESSION['agreement'] === "1") echo '同意する'; ?></p>
                </div>
                <div class="btn-list">
                  <p class="cancel-btn"><a href="form.php">キャンセル</a></p>
                  <input type="submit" name="btn-confirm" class="btn" value-"送信する" >
                </div>
            </form>
        </section>
    </main>
    <footer>&copy copy right</footer>
</body>
</html>