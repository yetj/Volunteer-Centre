<? if($info): ?>
	<div class="alert alert-success">
		<?=$info?>
	</div>
<? endif ?>
<p><?=_('Application made on:')?> <strong><?=date("d-m-Y H:i:s", $app->created)?></strong></p>
<p><?=_('Desired position:')?> <strong><?=$app->position?></strong></p>
<p><?=_('Current status:')?> <strong><?=$appsState[$app->state]?></strong></p>
<? if($app->state_comment): ?>
<p><?=_('Application feedback:')?> <div class="well"><i><?=$app->state_comment?></i></div></p>
<? endif ?>
<p><?=_('Last status change:')?> <strong><?=date("d-m-Y H:i:s", $app->modified)?></strong></p>
<p><?=_('Notifications upon status change:')?> <strong><?=$app->notifications ? _('Enabled') : _('Disabled') ?></strong><br />
	<? 
	if($app->notifications) {
		echo '<form action="'.publicURL($url, 'index', 'show', array('id' => $app->hash)).'" method="post">
		<input type="hidden" name="notifications" value="0" />
		<button type="submit" class="btn btn-mini btn-danger"><i class="icon-white icon-remove"></i> '._('Disable notifications').'</button>
		</form>';
	}
	else {
		echo '<form action="'.publicURL($url, 'index', 'show', array('id' => $app->hash)).'" method="post">
		<input type="hidden" name="notifications" value="1" />
		<button type="submit" class="btn btn-mini btn-success"><i class="icon-white icon-plus"></i> '._('Enable notifications').'</button>
		</form>';
	}
	
	if($app->state == 3 && $app->use_app == 0) {
		echo '<form action="'.publicURL($url, 'index', 'show', array('id' => $app->hash)).'" method="post">
		
			<div class="control-group">
				<div class="controls">
					<label class="checkbox">
						<input type="checkbox" value="1" name="use_app"> '._('I hereby allow InnoGames to use my data exclusively for the use of evaluating my character and abilities in regards to a team member position.').'
					</label>
				</div>
			</div>
			<div class="row">
				<div class="span10">
					<button type="submit" class="btn btn-success btn-mini"><i class="icon-white icon-ok"></i> '._('Accept').'</button>
				</div>
			</div>
		</form>';
	}
	else if($app->state == 3 && $app->use_app == 1) {
		echo '<div class="controls">
			<label class="checkbox">
				<input type="checkbox" value="1" name="use_app" checked="checked" disabled="disabled"> '._('I hereby allow InnoGames to use my data exclusively for the use of evaluating my character and abilities in regards to a team member position.').'
			</label>
		</div>';
	}
	?>
	
	
</p>