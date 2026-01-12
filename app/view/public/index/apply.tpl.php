<? if($action_id == 0): ?>
    <div class="container">
    	<h3>Lista dostępnych akcji wolontariackich:</h3>
    	<? if ($actions): ?>
    		<table class="table table-striped">
    			<thead>
    				<tr>
    					<? if ($project->id == 1): ?>
    						<th>Organizacja</th>
    					<? endif ?>
    					<th>Nazwa</th>
    					<th>Krótki opis akcji</th>
    					<th>Start nadsyłania zgłoszeń</th>
    					<th>Koniec nadsyłania zgłoszeń</th>
    					<th></th>
    				</tr>
    			</thead>
    			<tbody>
            		<? foreach($actions as $a): ?>
            			<tr>
        					<? if ($project->id == 1): ?>
        						<td class="center" style="width:15%"><?= $a->project_name ?></td>
        					<? endif ?>
            				<td class="center" style="width:20%"><strong><?= $a->name ?></strong></td>
            				<td><?= $a->description_short ?></td>
            				<td class="center" style="white-space: nowrap;"><?= date("Y-m-d", $a->start) ?><br><?= date("H:i", $a->start) ?></td>
            				<td class="center" style="white-space: nowrap;"><?= date("Y-m-d", $a->end) ?><br><?= date("H:i", $a->end) ?></td>
            				<td class="center"><a href="<?= publicURL($project->id == 1 ? $a->project_slug : $project->slug, 'index', 'page', ['show' => 'apply', 'action' => $a->id]) ?>" class="btn btn-primary">Zgłoś się!</a></td>
            			</tr>
            		<? endforeach ?>
        		</tbody>
    		</table>
    	<? else: ?>
    		<br><div class="alert alert-warning "><span data-feather="alert-triangle"></span> Brak dostępnych akcji wolontariackich do których można się zgłosić</div>
    	<? endif ?>
    </div>
<? else: ?>
    <? 
    $prepared_fields = [];
    
    
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
    
    <div class="container">
        <h3><?= $action->name ?></h3>
        <hr>
    	<?= $action->description_long ?>
    	<br>
    	<small><em>Początek nadsyłania zgłoszeń: <?= date("Y-m-d H:i", $action->start) ?></em><br>
    	<em>Koniec nadsyłania zgłoszeń: <?= date("Y-m-d H:i", $action->end) ?></em></small>
    	<br>
    	<br>
    	<? if (time() >= $action->start && time() <= $action->end ): ?>
            <h5>Wyślij swoje zgłoszenie:</h5>
            <hr>
                <form class="form-horizontal needs-validation" id="applyForm" action="" method="post" enctype="multipart/form-data">
                	<input type="hidden" name="action_id" value="<?= $action->id ?>" />
                	<input type="hidden" name="project_id" value="<?= $project->id ?>" />
                    <?= $template->html; ?>
                    <div class="container">
                        <div class="form-row">
                        	<em><span class="required">*</span> - pola z gwiazdką są wymagane</em>
                            <div class="col-sm">
                                <button class="btn btn-primary float-right" type="submit">Wyślij zgłoszenie</button> 
                            </div>
                        </div>
                    </div>
                </form>
        <? else: ?>
        	<hr>
        	<div class="alert alert-warning "><span data-feather="alert-triangle"></span> Niestety możliwość nadsyłania zgłoszeń jest obecnie niedostępna!</div>
        <? endif ?>
    </div>

<? endif ?>