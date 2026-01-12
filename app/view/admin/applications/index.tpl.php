<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Lista akcji wolontariackich</h1>
</div>

<h5>Wybierz akcję aby wyświetlić zgłoszenia</h5>
<div class="table-responsive">
	<table class="table table-striped table-sm">
	  <thead>
		<tr class="text-center">
		  <th>#</th>
		  <th>Nazwa</th>
		  <th>Start</th>
		  <th>Koniec</th>
		  <th>Liczba zgłoszeń</th>
		  <th>Akcje</th>
		</tr>
	  </thead>
	  <tbody>
	  <? if($actions): ?>
		  <? foreach($actions as $action): ?>
			<tr class="text-center">
			  <td><?= $action->id ?></td>
			  <td><?= $action->name ?></td>
			  <td class="center"><?= date("Y-m-d H:i", $action->start) ?></td>
			  <td class="center"><?= date("Y-m-d H:i", $action->end) ?></td>
			  <td class="center"><?= $action->sum ?></td>
			  <td>
				<a href="<?= adminURL('applications', 'action', ['id' => $action->id]) ?>" class="badge badge-pill badge-primary"><span data-feather="list"></span> Pokaż zgłoszenia</a>
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