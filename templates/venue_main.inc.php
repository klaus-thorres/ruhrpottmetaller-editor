<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>
<div class="rm_table">
    <div class="rm_table_header">
        <?=RmString::new('Name')->asTableCell()?>
        <?=RmString::new('City')->asTableCell()?>
        <?=RmString::new('Visible')->asTableCell()?>
    </div>
    <?php while ($this->get('venues')->hasCurrent()) : ?>
        <?php $event = $this->get('venues')->getCurrent(); ?>
        <div class="rm_table_row">
            <?=$event->getName()->asTableCell() ?>
            <?=$event->getCity()->getName()->asTableCell() ?>
            <?=$event->getIsVisible()->asTableCell() ?>
        </div>
        <?php $this->get('venues')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>