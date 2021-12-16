<?php
  ini_set('log_errors','on');
  ini_set('error_log','php.log');

  session_start();

  $debug_flg = true;

  function debug($str) {
      global $debug_flg;
      if(!empty($debug_flg)) {
          error_log('デバッグ:'.$str);
      }
  }

  define('MSG01', '未入力です');
  define('MSG02', 'Emailの形式で入力してください');
  define('MSG03', '255文字以内で入力してください');
  define('MSG04', '性別は必ず入力してください');
  define('MSG05', 'ファイルのアップロードに失敗しました');
  define('FILE_DIR', "images_test");

  $err_msg = array();

  function validRequired($str, $key) {
      global $err_msg;
      if(empty($str)) {
          $err_msg[$key] = MSG01;
      }
  }

  function validEmail($str, $key) {
      global $err_msg;
      $reg_str = "/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/";
      if(!preg_match($reg_str,$str)) {
          $err_msg[$key] = MSG02;
      }
  }

  function validMaxLen($str, $key, $max = 255) {
      if(mb_strlen($str) > $max) {
          global $err_msg;
          $err_msg[$key] = MSG03;
      }
  }
  function validGender($str, $key) {
      if($str !== 'male' && $str !== 'female') {
          global $err_msg;
          $err_msg[$key] = MSG04;
      }
  }

  function sanitize($str) {
       $clean = htmlspecialchars($str, ENT_QUOTES); 
       return $clean;
  }

  function sendEmail($to, $subject, $comment) {
      if(!empty($to) && !empty($subject) && !empty($comment)) {

        mb_language("japanese");
        mb_internal_encoding("UTF-8");

        $result = mb_send_mail($to, $subject,$comment);

        if($result) {
            debug('メールを送信しました');
        } else {
            debug('[エラー発生] メールの送信に失敗しました。');
        }
      }
  }

  function getImage($str, $key) {
      $upload_res = move_uploaded_file($_FILES[$str]['tmp_name'],FILE_DIR.$_FILES[$str]['name']);
      if($upload_res !== true) {
          $err_msg[$key] =MSG05;
      } else {
          $img = $_FILES[$str]['name'];
          return $img;
      }
  }
?>