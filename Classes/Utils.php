<?php

/**
 * general function class
 */

class Utils
{
	public static function renderPayForm($sid)
	{
	?>
	<form class="form-inline" method="POST" action="AddFee.php">
		<div class="form-group">
			<input type="hidden" class="form-control" name="sid" value="<?=$sid?>">
			<select name="month" class="form-control">
	<?php
	$abbrMonths = ['Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar'];
	foreach ($abbrMonths as $m) {
		echo "<option value='$m'>$m</option>";
	}
	?>
			</select>
			<input type="submit" class="btn btn-default">
		</div>
	</form>
	<?php	
	}
}