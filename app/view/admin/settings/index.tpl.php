<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Ustawienia</h1>
</div>

<form class="needs-validation" action="<?= adminURL('settings', 'save', ['id' => $project->id]) ?>" method="post" novalidate>
  <input type="hidden" name="id" value="<?= $project->id ?>">
  <div class="form-row">
    <div class="col-md-6 mb-3">
      <label for="validationCustom01">Nazwa projektu</label>
      <input type="text" class="form-control" id="validationCustom01" placeholder="Nazwa projektu" name="name" value="<?= $project->name ?>" required>
      <div class="invalid-feedback">
        Nazwa organizacji nie jest poprawna
      </div>
    </div>
    <div class="col-md-2 mb-3">
      <label for="validationCustom04">Status</label>
      <select name="status" class="form-control" <?= $project->slug == "global" || $project->status == 2 ? 'disabled' : '' ?>>
      	<option value="0" <?= $project->status == 0 ? 'selected="selected"' : '' ?>>Nieaktywny</option>
      	<option value="1" <?= $project->status == 1 ? 'selected="selected"' : '' ?>>Aktywny</option>
      	<? if($project->status == 2): ?>
      		<option value="2" <?= $project->status == 2 ? 'selected="selected"' : '' ?>>Zablokowany</option>
      	<? endif ?>
      	
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom02">Slug - adres odnośnika w linku</label>
      <input type="text" class="form-control" id="validationCustom02" name="slug" placeholder="Slug" value="<?= $project->slug ?>" required <?= $project->slug == "global" ? 'disabled' : '' ?>>
      <div class="invalid-feedback">
        Slug nie jest poprawny
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('settings', 'index', ['id' => $project->id]) ?>">Anuluj</a>
		<button class="btn btn-primary" type="submit">Edytuj projekt</button> 
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