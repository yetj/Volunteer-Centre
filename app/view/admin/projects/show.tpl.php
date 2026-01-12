<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Zgłoszenie - #<?= $project->id ?> - <?= $project->name ?></h1>
</div>
<h5><a href="<?= adminURL('projects', 'waiting') ?>">&laquo; wróć do listy projektów</a></h5>
		
		<div class="form-row">
			<div class="col-md-4">
				<dl>
				  <dt>Nazwa</dt>
					<dd><?= $project->name ?></dd>
				  <dt>Imię i nazwisko</dt>
					<dd><?= $project->requester_name ?></dd>
				  <dt>E-mail</dt>
					<dd><?= $project->requester_email ?></dd>
				  <dt>Dodatkowa forma kontaktu:</dt>
					<dd><?= $project->requester_contact ?></dd>
				</dl>
			</div>
			<div class="col-md-4">
				Obecny status projektu: 
                    <? if($project->status == 1): ?>
                    	<span class="badge badge-success">Zatwierdzony</span>
                    <? elseif($project->status == 2): ?>
                    	<span class="badge badge-danger">Odrzucony</span>
                    <? else: ?>
                    	<span class="badge badge-warning">Oczekujący</span>
                    <? endif ?>
				<br><br>
				<form action="<?= adminURL('projects', 'show', ['id' => $project->id]) ?>" method="post">
					<input type="hidden" value="<?= $project->id ?>" name="id">
					<div class="input-group">
					  <div class="input-group-prepend">
						<label class="input-group-text" for="inputGroupSelect01">Zmień status projektu</label>
					  </div>
					  <select class="custom-select" id="inputGroupSelect01" name="status">
						<option value="0" <?= $project->status == 0 ? 'selected="selected"' : '' ?>>Oczekujący</option>
						<option value="1" <?= $project->status == 1 ? 'selected="selected"' : '' ?>>Zatwierdzony</option>
						<option value="2" <?= $project->status == 2 ? 'selected="selected"' : '' ?>>Odrzucony</option>
					  </select>
					  <button class="btn btn-primary" type="submit">Zmień status</button> 
					</div>
				</form>
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-8">
				<dl>
					<dt>Krótki opis</dt>
					<dd><?= $project->short_description ?></dd>
					<dt>Długi opis</dt>
					<dd><?= $project->long_description ?></dd>
				</dl>
			</div>
		</div>
			