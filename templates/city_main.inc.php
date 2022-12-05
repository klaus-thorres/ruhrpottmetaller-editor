<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>
<div class="rm_table">
    <div class="rm_table_header">
        <?=RmString::new('Name')->asTableCell()?>
        <?=RmString::new('Visible')->asTableCell()?>
    </div>
    <?php while ($this->get('cities')->hasCurrent()) : ?>
        <?php $event = $this->get('cities')->getCurrent(); ?>
        <div class="rm_table_row">
            <?=$event->getName()->asTableCell() ?>
            <?=$event->getIsVisible()->asTableCell() ?>
        </div>
        <?php $this->get('cities')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>