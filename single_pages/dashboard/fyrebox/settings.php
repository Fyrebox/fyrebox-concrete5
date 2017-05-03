<?php
defined('C5_EXECUTE') or die('Access Denied.');

$token = Core::make('token');
?>

<form method="post" action="<?php  echo $controller->action('save') ?>">
	<?php  $token->output('fyrebox.settings.save'); ?>

	<div class="form-group">
		<?php
        echo $form->label('api_key', t('Fyrebox API key').' *');
        echo $form->text('api_key', Config::get('fyrebox.settings.api_key'), ['style' => 'max-width: 700px',]);
				echo t('You can find your Fyrebox API key on your <a href="https://www.fyrebox.com/account" target="_blank">Fyrebox account page</a>');
				?>
	</div>

	<div class="ccm-dashboard-form-actions-wrapper">
		<div class="ccm-dashboard-form-actions">
			<button class="pull-right btn btn-primary" type="submit"><?php  echo t('Save') ?></button>
		</div>
	</div>
</form>
