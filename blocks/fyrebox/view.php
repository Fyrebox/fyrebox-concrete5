<?php
defined('C5_EXECUTE') or die("Access Denied.");

$token = Core::make('token');
?>

<div class="fyrebox-quiz fyb-<?php  echo $bID ?>" id="b<?php  echo $bID ?>">
	<?php
	if (!$quizId) {
		echo '<p class="message">'.t('None of your quiz was selected').'</p>';
		$quizId="noquiz/selected";
	}
	?>
	<iframe src="https://www.fyrebox.com/webgame/<?php echo $quizId; ?>" allowfullscreen="true" frameborder="0" width="100%" height="400px"  allowTransparency="true" scrolling="no"></iframe>
</div>
