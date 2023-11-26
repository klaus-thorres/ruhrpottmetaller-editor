<legend>Concert lineup</legend>

<?php

$alphabet = range('A', 'Z');
array_splice($alphabet, 0, 0, '');
$alphabet[] = '%';
$lineupIndex = 1;

?>

<?php while ($this->get('gigs')->hasCurrent()): ?>
    <?php $gig = $this->get('gigs')->getCurrent() ?>
    <fieldset class="fieldset_band"
              id="band_<?=$lineupIndex?>"
              data-band-first-char="<?=$gig->getBandFirstChar()?>"
              data-band-id="<?=$gig->getBandId()?>">
        <legend>Band <?=$lineupIndex?></legend>
        <label for="first_sign_<?=$lineupIndex?>" class="screen_reader_only">First letter the of the band name</label>
        <select  id="first_sign_<?=$lineupIndex?>"
                 autocomplete="off">
            <?php foreach ($alphabet as $firstSign): ?>
                <?php if ($gig->getBandFirstChar()->get() == $firstSign) : ?>
                    <option value="<?=$firstSign?>" selected><?=$firstSign?></option>
                <?php else : ?>
                    <option value="<?=$firstSign?>"><?=$firstSign?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <label for="band_id_<?=$lineupIndex?>" class="screen_reader_only">Band</label>
        <select name="band_id[]" id="band_id_<?=$lineupIndex?>" autocomplete="off" class="edit_band_id"></select>
        <label for="band_new_name_<?=$lineupIndex?>" class="screen_reader_only"></label>
        <input type="text"
               value="<?=$gig->getBandName()?>"
               id="band_new_name_<?=$lineupIndex?>"
               class="edit_field"
               placeholder="Name of the new band">
        <label for="addition_<?=$lineupIndex?>" class="screen_reader_only">Addition</label>
        <input type="text" 
            value="<?=$gig->getAdditionalInformation()?>"
            id="addition_<?=$lineupIndex?>"
            class="edit_field"
            placeholder="Extra information">
        <button type="button" onclick="add_band_lineup(\'%2$u\')">
            <img src="<?=$this->get('imagePath')?>plus_small.png"
                 alt="Add band to lineup"
                 width="15"
                 height="15">
        </button>
        <button type="button" onclick="del_band_lineup(\'%1$u\')">
            <img src="<?=$this->get('imagePath')?>minus_small.png"
                 alt="Remove band <?=$lineupIndex?> from lineup"
                 width="15"
                 height="15">
        </button>
        <button type="button" onclick="shift_band_lineup(\'%1$u\', \'up\')">
            <img src="<?=$this->get('imagePath')?>arrow_up_small.png"
                 alt="Shift <?=$lineupIndex?>. band one line up"
                 width="15"
                 height="15">
        </button>
        <button type="button" onclick="shift_band_lineup(\'%1$u\', \'down\')">
            <img src="<?=$this->get('imagePath')?>arrow_down_small.png"
                 alt="Shift <?=$lineupIndex?>. Band one line down"
                 width="15"
                 height="15">
        </button>
    </fieldset>
    <?php $this->get('gigs')->pointAtNext(); ?>
    <?php $lineupIndex++; ?>
<?php endwhile; ?>