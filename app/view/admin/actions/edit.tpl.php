<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Akcje wolontariackie - Edytuj akcję</h1>
</div>

<form class="needs-validation" novalidate action="<?= adminURL('actions', 'edit_post', ['id' => $action->id]) ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $action->id ?>" />
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">Nazwa</label>
      <input type="text" class="form-control" id="validationCustom01" name="name" placeholder="Nazwa akcji" value="<?= isset($post['name']) ? $post['name'] : $action->name ?>" required>
    	<div class="invalid-feedback">
      		Nazwa akcji nie jest odpowiednia
    	</div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      	<label for="exampleFormControlFile1">Logo</label>
    	<input type="file" name="logo" class="form-control-file" id="exampleFormControlFile1">
    	<div class="invalid-feedback">
     		Musisz wgrać logo akcji
        </div>
    </div>
    <div class="col-md-4 mb-3">
    	<label for="exampleFormControlFile1">Aktualne logo</label><br>
    	<img src="data:<?= $action->logo_type ?>;base64,<?= base64_encode($action->logo) ?>" style="max-height: 200px;" />
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-2 mb-3">
      <label for="validationCustom02">Szablon</label>
      <? if($templates): ?>
      	<select name="template_id" class="form-control">
      		<? foreach($templates as $template): ?>
      			<option value="<?= $template->id ?>" <?= isset($post['template_id']) && $post['template_id'] == $template->id ? "selected='selected'" : $action->template_id == $template->id ? "selected='selected'" : "" ?>><?= $template->name ?></option>
      		<? endforeach; ?>
      	</select>
      <? endif ?>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-3 mb-3">
      	<label for="exampleFormControlStart">Start akcji</label>
      	<div class="input-group">
        	<input type="date" name="start_date" class="form-control" value="<?= isset($post['start_date']) ? $post['start_date'] : date("Y-m-d", $action->start) ?>" id="exampleFormControlStart" required>
        	<input type="time" name="start_time" class="form-control" value="<?= isset($post['start_time']) ? $post['start_time'] : date("H:i", $action->start) ?>" required>
        	<div class="invalid-feedback">
          		Musisz podać kiedy startuje akcja rekrutacyjna 
        	</div>
        </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-3 mb-3">
      	<label for="exampleFormControlStart">Koniec akcji</label>
      	<div class="input-group">
        	<input type="date" name="end_date" class="form-control" value="<?= isset($post['end_date']) ? $post['end_date'] : date("Y-m-d", $action->end) ?>" id="exampleFormControlEnd" required>
        	<input type="time" name="end_time" class="form-control" value="<?= isset($post['end_time']) ? $post['end_time'] : date("H:i", $action->end) ?>" required>
        	<div class="invalid-feedback">
          		Musisz podać kiedy kończy się akcja rekrutacyjna 
        	</div>
    	</div>
    </div>
  </div>
  <div class="form-row">
  	<div class="col-md-8 mb-3">
    	<label for="validationTextarea1">Krótki opis akcji</label>
    	<textarea class="form-control" rows="5" id="validationTextarea1" name="description_short" placeholder="Krótki opis akcji" required><?= isset($post['description_short']) ? $post['description_short'] : $action->description_short ?></textarea>
    	<div class="invalid-feedback">
      		Wprowadź krótki opis akcji
    	</div>
  	</div>
  </div>
  <div class="form-row">
  	<div class="col-md-8 mb-3">
    	<label for="validationTextarea2">Obszerny opis akcji</label>
    	<textarea class="form-control" rows="20" id="validationTextarea2" name="description_long" placeholder="Długi opis akcji" required><?= isset($post['description_long']) ? $post['description_long'] : $action->description_long ?></textarea>
    	<div class="invalid-feedback">
      		Wprowadź dłuższy i dokładniejszy opis akcji
    	</div>
  	</div>
  </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('actions', 'index') ?>">Anuluj</a>
		<button class="btn btn-primary" type="submit">Edutyj akcję</button> 
    </div>
  </div>
</form>


<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

<?= $this->element('tinymce', ['height' => 300, 'id' => 'validationTextarea1']) ?>
<?= $this->element('tinymce', ['height' => 400, 'id' => 'validationTextarea2', 'next' => 1]) ?>