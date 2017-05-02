<?php
defined('C5_EXECUTE') or die("Access Denied.");

if (!Config::get('fyrebox.settings.api_key')) {
    echo t('<a href="%s">Please add an API key first.</a>', URL::to('dashboard/fyrebox/settings/'));
    return;
}

if (count($qOptions) == 0) {
    echo t('<a target="_blank" href="%s">Please create a Fyrebox quiz first.</a>', 'https://www.fyrebox.com/dashboard/');
    return;
}
?>

<div class="form-group">
	 <?php
      echo $form->label('quizId', t('Please select a Quiz') .' *');
    ?>
	<div class="input">
		<?php
      echo $form->select('quizId', $qOptions, $listId);
    ?>
	</div>
</div>
