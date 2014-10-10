<?php 
	foreach ($list_category as $alias => $name) {
		echo $this->Html->link($name, 
			array('controller' => 'pages', 'action' => $this->action, $alias));
	}
?>