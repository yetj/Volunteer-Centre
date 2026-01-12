<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Logi</h1>
</div>



<h3>Lista logów</h3>
<div class="table-responsive">
	<table class="table table-striped table-sm">
	  <thead>
		<tr class="text-center">
		  <th class="align-middle">#</th>
		  <th class="align-middle">Data</th>
		  <th class="align-middle">Użytkownik i Email</th>
		  <th class="align-middle">IP</th>
		  <th class="align-middle">Moduł</th>
		  <th class="align-middle">Akcja</th>
		</tr>
	  </thead>
	  <tbody>
	  	<? if($logs): ?>
	  		<? foreach($logs as $log): ?>
	  			<tr>
	  				<td><?= $log->id ?></td>
	  				<td class="text-center"><?= date("Y-m-d H:i:s", $log->date) ?></td>
	  				<td><?= $log->name ?></td>
	  				<td class="text-center"><?= $log->ip ?></td>
	  				<td class="text-center"><?= $log->controller ?></td>
	  				<td class="text-center"><?= $log->action ?></td>
	  			</tr>	
	  		<? endforeach ?>
	  	<? else: ?>
	  		<tr><td colspan="6"><em>Brak logów do wyświetlenia...</em></td></tr>
	  	<? endif ?>
	  </tbody>
  </table>
  <?= $this->element('pagination', ['pageConfig' => $pageConfig]) ?>
</div>