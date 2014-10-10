<div class="wrapper">
	<div class="conteiner">
		<div class="order">
			<?php
				
				// $basket = $this->Session->read('basket');
				if ($basket == null) :
					echo $this->Html->div('empty','Ваша корзина пуста');
				else:
					$table_head = null;
					$table_head .= $this->Html->div('name col-3', 'Название блюда');
					$table_head .= $this->Html->div('kol col-3', 'Количество порций');
					$table_head .= $this->Html->div('price col-2', 'Стоимость');

					$table_head = $this->Html->div('col-10', $table_head);

					$table_cols = null;
					$pay_price = null;
					foreach ($basket as $item_id => $basket_item) {
						$item_data = $items_data[$item_id];

						$item_name =	$this->Html->div('name', $item_data['Item']['name']);
						$count =		$this->Html->div('count', $basket_item['count']);
						$item_image = 	$this->Html->image(unserialize($item_data['Image']['medium']));
						$item_image = 	$this->Html->div('image', $item_image);

						// Вывод цены, и кол-во шт для изменения корзины
						if ($item_data['Item']['parent_id'] == $id_rolls) {
							$item_price = 'Цена: 8шт-'.$item_data['Item']['price_2'].'тг, 4шт-'.$item_data['Item']['price'].'тг';
							$change_count = '4';
							if ($basket_item['count'] % 8 == 0){
								$fin_price = $basket_item['count']/8*$item_data['Item']['price_2'];
							} else {
								$fin_price = floor($basket_item['count']/8)*$item_data['Item']['price_2']+$item_data['Item']['price'];
							}
						} else {
							$item_price = 'Цена: '.$item_data['Item']['price'].'тг';
							$change_count = '1';
							$fin_price = $basket_item['count']*$item_data['Item']['price'];
						}

						$item_price = $this->Html->div('price', $item_price);

						// Кнопки + - Х
						$kol_plus = $this->Html->link('+', 
							array('controller' => 'pages', 'action' => 'change_basket', 
								$item_id, $change_count),
							array('class' => 'btn btn-success'));
						$kol_minus = $this->Html->link('-', 
							array('controller' => 'pages', 'action' => 'change_basket', 
								$item_id, $change_count * -1),
							array('class' => 'btn btn-success'));
						$del_link = $this->Html->link('X', 
							array('controller' => 'pages', 'action' => 'remove_basket', 
								$item_id),
							array('class' => 'btn btn-danger'));

						$pay_price += $fin_price; // подчёт всей суммы за заказ

						$name = 		$this->Html->div('col-3',	$item_image.$item_name.$item_price);
						$kol = 			$this->Html->div('col-3',	$kol_minus.$count.$kol_plus);
						$fin_price = 	$this->Html->div('col-3',	$fin_price);
						$del_link = 	$this->Html->div('col',		$del_link);

						$table_cols .= $this->Html->div('col-10', $name.$kol.$fin_price.$del_link);
					}

					$last_col = $this->Html->div('col', 'Итого:');
					$table_cols .= $this->Html->div('col-10', $last_col.' '.$pay_price);

					echo $this->Html->div('table', $table_head.$table_cols);
				
			?>
		</div>
		<div class="form-to-send-order">
			<?php
				echo $this->Form->create('Order', array('url' => array('controller' => 'pages', 'action' => 'add_order')));
				echo $this->Form->hidden('status', array('value' => '1'));
				echo $this->Form->input('name', array('label' => 'ФИО', 'required' => true));
				echo $this->Form->input('phone', array('label' => 'Контактный телефон', 'type' => 'tel', 'pattern' => '8[0-9]{10}', 'required' => true, 'placeholder' => '8123456789'));
				echo $this->Form->input('email', array('label' => 'Е-mail (не обезательно)'));
				echo $this->Form->input('adress', array('label' => 'Адресс доставки', 'required' => true));
				
				echo $this->Form->input('message', array('label' => 'Коментарии', 'type' => 'textarea'));
				echo $this->Form->hidden('stiker');
				echo $this->Html->div('submit', $this->Form->submit('Сделать заказ', array('class' => 'btn btn-success', 'div' => false)));

				echo $this->Form->end();
				endif;
			?>
		</div>
	</div>
</div>