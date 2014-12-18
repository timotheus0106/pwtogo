<li<?php
	echo $this->hasChildren() || $this->isActive() || $this->isCurrent() || $this->isFirst() || $this->isLast() ? ' class="' : '';
		echo $this->hasChildren() ? 'menu-item-has-children' : '';
		echo $this->isActive() ? ' active' : '';
		echo $this->isCurrent() ? ' current' : '';
		echo $this->isFirst() ? ' first' : '';
		echo $this->isLast() ? ' last' : '';
	echo $this->hasChildren() || $this->isActive() || $this->isCurrent() || $this->isFirst() || $this->isLast() ? '"' : '';
?>>
	<a href="<?php echo $this->getElement()['url']; ?>">
		<?php echo $this->getElement()['title'] . "\n"; ?>
	</a>
	<?php $this->renderSubElements(); ?>
</li>
