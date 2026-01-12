<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Lista zgłoszeń do akcji "<?= $action->name ?>"</h1>
</div>

<em><a href="<?= adminURL('applications') ?>">&laquo; wróć do listy wyboru akcji</a></em><br><br>

<div class="table-responsive">
	<table class="table table-striped table-sm">
	  <thead>
		<tr class="text-center">
		  <th>#</th>
		  <th>Data</th>
		  <th>Status</th>
		  <th></th>
		</tr>
	  </thead>
	  <tbody>
	  <? if($apps): ?>
		  <? foreach($apps as $app): ?>
			<tr class="text-center">
			  <td><?= $app->id ?></td>
			  <td class="center"><?= date("Y-m-d H:i:s", $app->date) ?></td>
			  <td class="center">
			  	<? if ($app->status == 1): ?>
			  		<span class="badge badge-success">Przyjęte</span>
			  	<? elseif ($app->status == 2): ?>
			  		<span class="badge badge-danger">Odrzucone</span>
			  	<? else: ?>
			  		<span class="badge badge-warning">Oczekuje</span>
			  	<? endif ?>
			  </td>
			  <td>
				<a href="<?= adminURL('applications', 'show', ['id' => $app->id, 'action' => $action->id,]) ?>" class="badge badge-pill badge-primary"><span data-feather="tag"></span> Pokaż zgłoszenie</a>
			  </td>
			</tr>
			<? endforeach ?>
		<? else: ?>
			<tr>
				<td colspan="6" align="center"><i>Brak akcji w bazie</i></td>
			</tr>
		<? endif ?>
	  </tbody>
	</table>
</div>