<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Szablony - Podlgąd szablonu "<?= $template->name ?>" [#<?= $template->id ?>]</h1>
</div>
<em><a href="<?= adminURL('templates') ?>">&laquo; wróć do listy szablonów</a></em>

<? $prepared_fields = []; ?>

<? 
foreach($template_fields as $template_field) {
    if (!array_key_exists($template_field->position, $prepared_fields)) {
        $prepared_fields[$template_field->position] = "";
    }
    
    $prepared_fields[$template_field->position] .= $this->element('fields', ['template_field' => $template_field, 'edit' => 0]);
}
?>

<? for ($i=1;$i<=$template->parts;$i++): ?>
	<? $template->html = str_replace("{%PART_".$i."%}", isset($prepared_fields[$i]) ? $prepared_fields[$i] : "", $template->html); ?>
<? endfor ?>

<h5>Podgląd szablonu:</h5>
<hr>
<div style="width:90%;">
    <form class="needs-validation" action="" method="">
        <?= $template->html; ?>
        <div class="container">
            <div class="form-row">
            	<em><span class="required">*</span> - pola z gwiazdką są wymagane</em>
                <div class="col-sm">
                    <button class="btn btn-primary float-right" type="button">Wyślij zgłoszenie</button> 
                </div>
            </div>
        </div>
    </form>
</div>
