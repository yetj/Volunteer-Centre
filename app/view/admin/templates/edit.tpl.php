<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Szablony - Edycja szablonu "<?= $template->name ?>" [#<?= $template->id ?>]</h1>
</div>
<em><a href="<?= adminURL('templates') ?>">&laquo; wróć do listy szablonów</a></em>

<? for ($i=1;$i<=$template->parts;$i++): ?>
	<? $template->html = str_replace("{%PART_".$i."%}", "Pozycja numer ".$i, $template->html); ?>
<? endfor ?>

<h5>Podgląd szablonu:</h5>
<div class="template-overview">
	<?= $template->html; ?>
</div>

<h5>Lista pól:</h5>
<form action="<?= adminURL('templates', 'edit_post', ['template_id' => $template->id]) ?>" method="post">
	<input type="hidden" name="template_id" value="<?= $template->id ?>">
    <table class="table table-bordered table-sm">
    	<thead>
    		<tr>
    			<th>#</th>
    			<th>Nazwa</th>
    			<th>Pozycja</th>
    			<th>Typ</th>
    			<th>Opcje</th>
    			<th>Domyślna wartość</th>
    			<th>Wymagane?</th>
    			<th>Kolejność</th>
    			<th>Akcje</th>
    		</tr>
    	</thead>
    	<tbody>
    		<? if($template_fields): ?>
    			<? foreach($template_fields as $template_field): ?>
    				<tr>
    					<td class="center"><?= $template_field->id ?></td>
    					<td class="center">
    						<input type="text" class="form-control form-control-sm" value="<?= $template_field->name ?>" name="field[<?= $template_field->id ?>][name]" />
    					</td>
    					<td class="center">
    						<select name="field[<?= $template_field->id ?>][position]" class="form-control form-control-sm" >
                            	<? for ($i=1;$i<=$template->parts;$i++): ?>
                            	    <option value="<?= $i ?>" <?= $template_field->position == $i ? "selected" : ""; ?>>Pozycja nr. <?= $i ?></option>
                            	<? endfor ?>
                            </select>
    					</td>
    					<td class="center"><?= $fields[$template_field->type] ?> (<?= $template_field->type ?>)</td>
    					
    					<?= $this->element('fields', ['template_field' => $template_field, 'edit' => 1]) ?>
    					
    					<td class="center">
    						<input type="number" class="form-control form-control-sm" value="<?= $template_field->sort ?>" name="field[<?= $template_field->id ?>][sort]" />
    					</td>
    					<td class="center">
            				<a href="<?= adminURL('templates', 'field_delete', ['id' => $template->id, 'field_id' => $template_field->id]) ?>" class="badge badge-pill badge-danger"><span data-feather="trash-2"></span></a>
    					</td>
    				</tr>
    			<? endforeach; ?>
    		<? else: ?>
    			<tr>
    				<td colspan="9">
    					<em>Brak pól do wyświetlenia</em>
    				</td>
    			</tr>
    		<? endif ?>
    	</tbody>
    </table>
    <div class="float-right">
        <button class="btn btn-success" type="submit" class="" name="save_changes" value="1"><span data-feather="file-plus"></span> Zapisz zmiany</button>
    </div>
</form>
<br><br>

<h5>Dodaj nowe pole:</h5>
<form class="needs-validation" action="<?= adminURL('templates', 'field_add_post', ['template_id' => $template->id]) ?>" method="post">
  <input type="hidden" name="id" value="<?= $template->id ?>">
  <div class="form-row">
    <div class="col-md-2 mb-3">
      <label for="validationEmail">Nazwa</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend"><span data-feather="type"></span></span>
        </div>
        <input type="text" class="form-control" placeholder="Nazwa" name="name" aria-describedby="inputGroupPrepend" required>
      </div>
    </div>
    <div class="col-md-2 mb-3">
      <label for="validationEmail">Pozycja</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend"><span data-feather="columns"></span></span>
        </div>
        <select name="position" class="form-control" >
        	<? for ($i=1;$i<=$template->parts;$i++): ?>
        	    <option value="<?= $i ?>">Pozycja nr. <?= $i ?></option>
        	<? endfor ?>
        </select>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationEmail">Typ pola</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend"><span data-feather="file"></span></span>
        </div>
        <select name="type" class="form-control" >
        	<? foreach($fields as $field_id => $field_name): ?>
        	    <option value="<?= $field_id ?>"><?= $field_name ?> (<?= $field_id ?>)</option>
        	<? endforeach ?>
        </select>
      </div>
    </div>
    
    <div class="col-md-2 mb-3">
    	<label>&nbsp;</label>
    	<div class="input-group">
			<button class="btn btn-success" type="submit"><span data-feather="file-plus"></span> Dodaj pole</button>
		</div> 
    </div>
  </div>
</form>