<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Projekt - Tworzenie nowego</h1>
</div>
<h5><a href="<?= adminURL('projects') ?>">&laquo; wróć do listy projektów</a></h5>

<form class="needs-validation" action="<?= adminURL('projects', 'add_post') ?>" method="post" novalidate>
  <div class="form-row">
    <div class="col-md-6 mb-3">
      <label for="validationCustom01">Nazwa projektu</label>
      <input type="text" class="form-control" id="validationCustom01" placeholder="Nazwa projektu" name="name" value="" required>
      <div class="invalid-feedback">
        Nazwa organizacji nie jest poprawna
      </div>
    </div>
    <div class="col-md-2 mb-3">
      <label for="validationCustom04">Status</label>
      <select name="status" class="form-control">
      	<option value="0">Nieaktywny</option>
      	<option value="1">Aktywny</option>
      	<option value="2">Zablokowany</option>
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom02">Slug</label>
      <input type="text" class="form-control" id="validationCustom02" name="slug" placeholder="Slug" required>
      <div class="invalid-feedback">
        Slug nie jest poprawny
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationCustom03">Właściciel</label>
      	<select name="owner" class="form-control" id="validationCustom03">
      		<option value="0">-- brak właściciela --</option>
      		<? foreach($members as $member): ?>
      			<option value="<?= $member->id ?>"><?= $member->access > 0 ? '*' : ''; ?> <?= $member->name ?> (<?= $member->email ?>)</option>
      		<? endforeach ?>
      	</select>
      <div class="invalid-feedback">
        Wybrano złego właściciela
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('projects') ?>">Anuluj</a>
		<button class="btn btn-primary" type="submit">Dodaj projekt</button> 
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