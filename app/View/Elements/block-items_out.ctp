<div class="shop-menu">
	<div class="container">
		<div class='items-selector'>
			<?php 
				echo $this->element('items-selector-out'); 
			?>
		</div>

		<div class="items">
		<?php
			$items_html = null;
			foreach ($items['Item'] as $item) {	
					$add_link = null;
					$add_link_2 = null;

					$image_html = $this->Html->div('image', $this->Html->image(unserialize($item['Image']['medium']), array('class' => 'Image', 'alt' => $item['name'])));

					$description = $this->Html->div('name', $item['name']);
					$description .= $this->Html->div('description', $item['description']);
					if ($item['parent_id'] == $id_rolls){
						if ($item['price'] != null){
							$price = $this->Html->div('pcs', '4 штуки');
							$price .= $this->Html->div('pcs-price', $item['price'] . ' тг');
							$description .= $this->Html->div('price-1 btn btn-primary', $price);

							$add_link = $this->Html->link('Добавить 4', 
							array('controller' => 'pages', 'action' => 'change_basket' , 
								$item['id'], '4'),
							array('class' => 'btn btn-success'));
						}

						if ($item['price_2'] != null){
							$price = $this->Html->div('pcs', '8 штук');
							$price .= $this->Html->div('pcs-price', $item['price_2'] . ' тг');
							$description .= $this->Html->div('price-2 btn btn-primary', $price);

							$add_link_2 = $this->Html->link('Добавить 8', 
							array('controller' => 'pages', 'action' => 'change_basket' , 
								$item['id'], '8'),
							array('class' => 'btn btn-success'));
						}
					} else {
						$add_link = $this->Html->link('Добавить', 
							array('controller' => 'pages', 'action' => 'change_basket' , 
								$item['id'], '1'),
							array('class' => 'btn btn-success'));
					}
					// Форма для добавления в корзину
					$description .= $this->Html->div('add-to-basket-button', $add_link.$add_link_2);
					$description = $this->Html->div('description', $description);


				$items_html .= $this->Html->div('item', $image_html . $description);
			}

			echo $items_html;
		?>
		</div>

		<div class='items-selector down'>
			<?php 
				echo $this->element('items-selector-out'); 
			?>
		</div>
	</div>
</div>