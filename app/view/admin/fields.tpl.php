<? if ($template_field->type == "text"): ?>
     <? if ($edit): ?>
        <td class="center">
        	<strong>Szerokość pola w px:</strong> 
        	<input type="number" class="form-control form-control-sm" min="50" value="<?= $template_field->options <= 50 ? 50 : $template_field->options ?>" name="field[<?= $template_field->id ?>][options][]" />
        </td>
		<td class="center">
			<input type="text" class="form-control form-control-sm" value="<?= $template_field->defaults ?>" name="field[<?= $template_field->id ?>][defaults]" />
		</td>
		<td class="center">
			<input type="checkbox" class="form-control-sm" name="field[<?= $template_field->id ?>][required]" value="1" <?= $template_field->required ? "checked" : ""; ?>>
		</td>
	<? else: ?>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label for="field_<?= $template_field->id ?>"><?= $template_field->name ?><?= $template_field->required ? "<span class='required'>*</span>" : "" ?></label>
                <div class="input-group">
                    <input type="text" class="form-control" id="field_<?= $template_field->id ?>" placeholder="<?= $template_field->defaults ?>" name="field[<?= $template_field->id ?>]" <?= $template_field->required ? "required" : "" ?>>
                </div>
            </div>
        </div>
	<? endif ?>
<? elseif ($template_field->type == "textarea"): ?>
    <? if ($edit): ?>
        <td class="center">
        	<strong>Szerokość pola w px:</strong> 
        	<input type="number" class="form-control form-control-sm" min="50" value="<?= explode("|", $template_field->options)[0] <= 50 ? 50 : explode("|", $template_field->options)[0] ?>" name="field[<?= $template_field->id ?>][options][]" />
        	<strong>Wysokość pola w px:</strong> 
        	<input type="number" class="form-control form-control-sm" min="50" value="<?= explode("|", $template_field->options)[1] <= 50 ? 50 : explode("|", $template_field->options)[1] ?>" name="field[<?= $template_field->id ?>][options][]" />
        </td>
		<td class="center">
			<textarea name="field[<?= $template_field->id ?>][defaults]" class="form-control form-control-sm" style="min-height:100px !important; min-width:300px !important;" ><?= $template_field->defaults ?></textarea>
		</td>
		<td class="center">
			<input type="checkbox" class="form-control-sm" name="field[<?= $template_field->id ?>][required]" value="1" <?= $template_field->required ? "checked" : ""; ?>>
		</td>
	<? else: ?>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label for="field_<?= $template_field->id ?>"><?= $template_field->name ?><?= $template_field->required ? "<span class='required'>*</span>" : "" ?></label>
                <div class="input-group">
                	<textarea id="field_<?= $template_field->id ?>" class="form-control form-control-sm" name="field[<?= $template_field->id ?>]" placeholder="<?= $template_field->defaults ?>" style="height:<?= $template_field->options ? explode("|", $template_field->options)[1] : 150 ?>px !important; width:<?= $template_field->options ? explode("|", $template_field->options)[0] : 400 ?>px !important;" <?= $template_field->required ? "required" : "" ?>><?= $template_field->defaults ?></textarea>
                </div>
            </div>
        </div>
	<? endif ?>
<? elseif ($template_field->type == "email"): ?>
     <? if ($edit): ?>
        <td class="center">
        	<strong>Szerokość pola w px:</strong> 
        	<input type="number" class="form-control form-control-sm" min="50" value="<?= $template_field->options <= 50 ? 50 : $template_field->options ?>" name="field[<?= $template_field->id ?>][options][]" />
        </td>
		<td class="center">
			<input type="email" class="form-control form-control-sm" value="<?= $template_field->defaults ?>" name="field[<?= $template_field->id ?>][defaults]" />
		</td>
		<td class="center">
			<input type="checkbox" class="form-control-sm" name="field[<?= $template_field->id ?>][required]" value="1" <?= $template_field->required ? "checked" : ""; ?>>
		</td>
	<? else: ?>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label for="field_<?= $template_field->id ?>"><?= $template_field->name ?><?= $template_field->required ? "<span class='required'>*</span>" : "" ?></label>
                <div class="input-group">
                    <input type="email" class="form-control" id="field_<?= $template_field->id ?>" placeholder="<?= $template_field->defaults ?>" name="field[<?= $template_field->id ?>]" <?= $template_field->required ? "required" : "" ?>>
                </div>
            </div>
        </div>
	<? endif ?>
<? else: ?>
    <? if ($edit): ?>
    	<td colspan="3"><em>Nieobsługiwane pole...</em></td>
	<? else: ?>
		
	<? endif ?>
<? endif ?>