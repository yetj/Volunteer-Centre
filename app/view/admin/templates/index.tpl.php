<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Szablony</h1>
	<a href="<?= adminURL('templates', 'add') ?>" class="btn btn-success float-right"><span data-feather="plus"></span> Utwórz nowy szablon</a>
</div>


<div class="table-responsive">
	<table class="table table-striped table-sm">
	  <thead>
		<tr class="text-center">
		  <th>#</th>
		  <th>Nazwa</th>
		  <th>Rodzaj szablonu</th>
		  <th>Akcje</th>
		</tr>
	  </thead>
	  <tbody>
	  <? if($templates): ?>
		  <? foreach($templates as $template): ?>
			<tr class="text-center">
			  <td><?= $template->id ?></td>
			  <td><?= $template->name ?></td>
			  <td><img width="35" src="data:<?= $template->img_type ?>;base64,<?= base64_encode($template->img) ?>"/></td>
			  <td>
				<a href="<?= adminURL('templates', 'preview', ['id' => $template->id]) ?>" class="badge badge-pill badge-info"><span data-feather="sun"></span></a>
				<a href="<?= adminURL('templates', 'edit', ['id' => $template->id]) ?>" class="badge badge-pill badge-primary"><span data-feather="edit-2"></span></a>
				<a href="<?= adminURL('templates', 'delete', ['id' => $template->id]) ?>" class="badge badge-pill badge-danger"><span data-feather="trash-2"></span></a>
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