<?php
	App::uses('Model', 'Model');

	class Order extends AppModel {
		public $order = 'created DESC'; 
		public $hasAndBelongsToMany = array('Item');
	

		public function afterSave($created, $options = array()) {
			// $user = $this->findById($user_id);
			// debug($user);
			// die();
			// $to = $user['User']['email'];
			$to = 'Alekseiz_000@mail.ru';
			$subject = 'Ваш пароль для входа на сайт godzilla.kz';

			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail();
			$Email->config('test');
			$Email->to($to);
			$Email->subject($subject);
			$Email->viewVars(array(
				'content' => array(
					'name' 				=> 'Name', 
					'email' 			=> 'email',
					'password'			=> 'pass'
				)
			));
			$Email->template('zakaz_for_user', 'default');
			$Email->emailFormat('html');
			// $Email->send();


			$to = 'Alekseiz_000@mail.ru';
			$subject = 'Ваш пароль для входа на сайт godzilla.kz';

			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail();
			$Email->config('test');
			$Email->to($to);
			$Email->subject($subject);
			$Email->viewVars(array(
				'content' => array(
					'name' 				=> 'Name', 
					'email' 			=> 'email',
					'password'			=> 'pass'
				)
			));
			
			$Email->template('zakaz_for_operator', 'default');
			$Email->emailFormat('html');
			// $Email->send();
		}

		public function check_status_change($id_order, $status_order) {
			$order_info = $this->findById($id_order);
			$user_id = $order_info['Order']['phone'];
			$phone = $order_info['Order']['phone'];
			$old_status_order = $order_info['Order']['status'];
			$User_model = ClassRegistry::init('User');
			if (($old_status_order == 1) && ($status_order == 2)){
				// $User_model->$this->send_sms($user_id, $message_text, $phone);
				// Отправка сообщения об подтверждении заказа и он приянат в обработку
			}

			if (($old_status_order == 2) && ($status_order == 3)){
				// $this->send_sms($user_id, $message_text, $phone)
				// Отправка сообщения о том что заказ передан курьеру.
			}
		}

	}

?>