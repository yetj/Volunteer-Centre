<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Szablony - Usuń pole</h1>
</div>

<form class="needs-validation" novalidate action="<?= adminURL('templates', 'field_delete_post', ['field_id' => $field->id, 'template_id' => $field->template_id]) ?>" method="post">
	<input type="hidden" name="field_id" value="<?= $field->id ?>">
  <div class="form-row">
    <div class="col-md-8 mb-3">
		Czy aby na pewno chcesz usunąć pole [<strong>#<?= $field->id ?></strong>] o nazwie <strong><?= $field->name ?></strong>?
    </div>
  </div>
  
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('templates', 'edit', ['id' => $field->template_id]) ?>">Anuluj</a>
		<button class="btn btn-danger" type="submit">Usuń pole</button> 
    </div>
  </div>
</form>