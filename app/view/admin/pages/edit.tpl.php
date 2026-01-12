<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Strony - Edycja strony</h1>
</div>

<form class="needs-validation" novalidate action="<?= adminURL('pages', 'edit_post', ['id' => $page->id]) ?>" method="post">
	<input type="hidden" name="id" value="<?= $page->id ?>">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">Nazwa strony</label>
      <input type="text" class="form-control" id="validationCustom01" name="title" value="<?= $page->title ?>" placeholder="Nazwa strony" required>
      <div class="invalid-feedback">
        Wybrana nazwa strony nie jest poprawna!
      </div>
      <div class="valid-feedback">
        Ok!
      </div>
    </div>
  </div>
  <? if($page->system == 0): ?>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">Status strony</label>

		<div class="custom-control custom-radio">
		  <input type="radio" id="customRadio1" name="display" class="custom-control-input" value="1" <?= $page->display ? 'checked="checked"' : '' ?>>
		  <label class="custom-control-label" for="customRadio1">Aktywna</label>
		</div>
		<div class="custom-control custom-radio">
		  <input type="radio" id="customRadio2" name="display" class="custom-control-input" value="0" <?= $page->display ? '' : 'checked="checked"' ?>>
		  <label class="custom-control-label" for="customRadio2">Nieaktywna</label>
		</div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">Ukryć stronę w menu?</label>

		<div class="custom-control custom-radio">
		  <input type="checkbox" id="customCheckbox1" name="hidden" value="1" class="custom-control-input" <?= $page->hidden ? 'checked="checked"' : '' ?>>
		  <label class="custom-control-label" for="customCheckbox1" value="1">Strona niewidoczna w menu</label>
		</div>
    </div>
  </div>
  <? else: ?>
  <div class="form-row">
    <div class="col-md-8 mb-3">
    	<strong>Strony systemowej nie można ukryć.</strong>
    </div>
  </div>
  <? endif ?>
  <? if($page->slug != "apply" && $page->slug != "register"): ?>
  <div class="form-row">
    <div class="col-md-8 mb-3">
      <label>Treść strony</label>
	  <textarea name="content" class="form-control" id="validationDescription" placeholder="Treść strony"><?= $page->content ?></textarea>
    </div>
  </div>
  <? endif ?>
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('pages', 'index') ?>">Anuluj</a>
		<button class="btn btn-primary" type="submit">Zapisz zmiany</button> 
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


<?= $this->element('tinymce') ?>