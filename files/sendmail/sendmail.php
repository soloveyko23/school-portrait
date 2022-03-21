<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От кого письмо
	$mail->setFrom('fakdut.sl2017@gmail.com', 'SCHOOL PORTRAIT');
	//Кому отправить
	$mail->addAddress('milllko@mail.ru');
	//Тема письма
	// $mail->Subject = '"';

	//Тело письма
	$body = '<h1>Заявка с сайта!</h1>';

	if(trim(!empty($_POST['name']))){
		$body.='Имя: '.$_POST['name'];
	}	
	if(trim(!empty($_POST['phone']))){
		$body.='телефон: '.$_POST['phone'];
	}	
	if(trim(!empty($_POST['message']))){
		$body.='Сообщение: '.$_POST['message'];
	}	
	
	/*
	//Прикрепить файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//путь загрузки файла
		$filePath = __DIR__ . "/files/sendmail/attachments/" . $_FILES['image']['name']; 
		//грузим файл
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Фото в приложении</strong>';
			$mail->addAttachment($fileAttach);
		}
	}
	*/

	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Ошибка';
	} else {
		$message = 'Данные отправлены!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);

		// TELEGRAM
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$messages = $_POST['message'];
		$token = "5021993496:AAEm1IsdNn1y75l_lvCecBoPoVmvb_46Faw";
		$chat_id = "-613409229";
		
		$arr = array(
		  'Имя пользователя: ' => $name,
		  'Телефон: ' => $phone,
		  'Сообщение: ' => $messages,
		);
	
		foreach($arr as $key => $value) {
		$txt .= "<b>".$key."</b> ".$value."%0A";
		};
	
		$sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
		if ($sendToTelegram) {
			$message = 'Ошибка';
		} else {
			$message = 'Данные отправлены!';
		}
?>