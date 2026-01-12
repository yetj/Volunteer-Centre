<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Akcje wolontariackie</h1>
	<a href="<?= adminURL('actions', 'add'); ?>" class="btn btn-success float-right"><span data-feather="plus"></span> Stwórz nową akcję</a>
</div>


<div class="table-responsive">
	<table class="table table-striped table-sm">
	  <thead>
		<tr class="text-center">
		  <th>#</th>
		  <th>Nazwa</th>
		  <th>Start</th>
		  <th>Koniec</th>
		  <th>Status akcji</th>
		  <th>Akcje</th>
		</tr>
	  </thead>
	  <tbody>
	  <? if($actions): ?>
		  <? foreach($actions as $action): ?>
			<tr class="text-center">
			  <td><?= $action->id ?></td>
			  <td><?= $action->name ?></td>
			  <td><?= date("Y-m-d H:i", $action->start) ?></td>
			  <td><?= date("Y-m-d H:i", $action->end) ?></td>
			  <td><?= $action->status == 1 ? "Opublikowana" : "Ukryta" ?></td>
			  <td>
			  	<? if ($action->status == 0): ?>
					<a href="<?= adminURL('actions', 'publish', ['id' => $action->id]) ?>" class="badge badge-pill badge-success"><span data-feather="eye"> Publish</span></a>
				<? else: ?>
					<a href="<?= adminURL('actions', 'hide', ['id' => $action->id]) ?>" class="badge badge-pill badge-warning"><span data-feather="eye-off"> Hide</span></a>
				<? endif ?>
				<a href="<?= adminURL('actions', 'edit', ['id' => $action->id]) ?>" class="badge badge-pill badge-primary"><span data-feather="edit-2"></span></a>
				<a href="<?= adminURL('actions', 'delete', ['id' => $action->id]) ?>" class="badge badge-pill badge-danger"><span data-feather="trash-2"></span></a>
			  </td>
			</tr>
			<? endforeach ?>
		<? else: ?>
			<tr>
				<td colspan="6" align="center"><i>Brak szablonów w bazie</i></td>
			</tr>
		<? endif ?>
	  </tbody>
	</table>
</div>