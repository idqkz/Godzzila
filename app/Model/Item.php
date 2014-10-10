<?php
	App::uses('Model', 'Model');

	class Item extends AppModel {
		public $hasOne = array(
			'Image' => array(
				'foreignKey'	=> 'item_id',
				'dependent'		=> true,
				'conditions' 	=> array('Image.type' => 'items'),
				)
			);

		public function beforeSave($options = array()) {

	    	return true;
		}
		public function afterSave($created, $options = array()) {
    	if (!empty($this->data['Item']['image'])) {
    			$image_type = 'items';
				//	pass to images with text type and text id....
				$Image_model = ClassRegistry::init('Image');
				$Image_model->new_image($this->data['Item']['image'], $image_type, $this->data['Item']['id']);
			} else {
				unset($this->data['Item']['image']);
			}
	    	return true;
	    }

	    public function basket_item_data($basket){
	    	$data = null;
	    	if ($basket != null)
		    	foreach ($basket as $id_item => $item_value) {
		    		$data[$id_item] = $this->find('first', array(
							'fields' => array('Item.id', 'Image.medium', 'Item.name', 'Item.price', 'Item.price_2',
								'Item.parent_id'),
							'conditions' => array('Item.id' => $id_item),
						));
		    	}
	    	return $data;
	    }
		 // public function keyfind() {
		 // 	$sort = $this->Item->find('all');
			// foreach ($sort as $key => $item) {
			// 	$newsort[$item['Item']['id']] = $sort[$key];
			// }
			// return $newsort;
		 // }
	}
?>