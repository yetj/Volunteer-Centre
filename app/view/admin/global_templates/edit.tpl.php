<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Szablony globalne - Educja szablonu</h1>
</div>

<form class="needs-validation" novalidate action="<?= adminURL('global_templates', 'edit_post', ['id' => $template->id]) ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $template->id ?>">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">Nazwa</label>
      <input type="text" class="form-control" id="validationCustom01" name="name" placeholder="Nazwa szablonu" value="<?= $template->name ?>" required>
    	<div class="invalid-feedback">
      		Nazwa szablonu nie jest odpowiednia
    	</div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      	<label for="exampleFormControlFile1">Zdjęcie poglądowe</label>
    	<input type="file" name="img" class="form-control-file" id="exampleFormControlFile1">
    </div>
    <div class="col-md-4 mb-3">
    	<label for="exampleFormControlFile2">Obecne zdjęcie poglądowe:</label><br>
    	<img src="data:<?= $template->img_type ?>;base64,<?= base64_encode($template->img) ?>"/>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-2 mb-3">
      <label for="validationCustom02">Liczba części szablonu</label>
      <input type="number" class="form-control" id="validationCustom02" name="parts" placeholder="0" value="<?= $template->parts ?>" required>
    </div>
  </div>
  <div class="form-row">
  	<div class="col-md-8 mb-3">
    	<label for="validationTextarea">Kod HTML szablonu</label>
    	<textarea class="form-control" rows="20" id="validationTextarea" name="html" placeholder="Kod HTML szablonu" required><?= $template->html ?></textarea>
    	<div class="invalid-feedback">
      		Proszę wprowadzić kod HTML szablonu
    	</div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('global_templates', 'index') ?>">Anuluj</a>
		<button class="btn btn-primary" type="submit">Zaktualizuj szablon</button> 
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