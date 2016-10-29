<?php

/**
 * general function class
 */

class Utils
{
	public static function renderPayForm($sid, $month=True)
	{
	?>
	<form class="form-inline" method="POST" action="AddFee.php">
		<div class="form-group">
			<input type="hidden" class="form-control" name="sid" value="<?=$sid?>">
			<input type="hidden" class="form-control" name="action" value="regular">
			<select name="<?=($month)?"month":"transport"?>" class="form-control">
	<?php
	$abbrMonths = ['Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar'];
	$currentMonth = date("M");
	foreach ($abbrMonths as $m) {
		if($m == $currentMonth)
			$val = "<option value='$m' selected='selected'>$m</option>";
		else
			$val = "<option value='$m'>$m</option>";
		echo $val;
	}
	?>
			</select>
			<input type="submit" value="Pay <?=($month)?"This Month":"Transport" ?> Fee" class="btn btn-default">
		</div>
	</form>
	<?php	
	}
}