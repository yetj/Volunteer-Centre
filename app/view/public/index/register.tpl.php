
        <div class="container">
<section class="jumbotron text-center">
		  <img src="/img/volunteering.png" style="width:100%"/>
          <br><br><br>
		  <h1 class="jumbotron-heading">Zasady i proces rejestracji</h1>
          <p class="lead text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          
      </section>
        </div>


      <div class="container marketing">
			<h1 class="jumbotron-heading">Formularz rejestracyjny</h1>
			<br><br>
			<form class="needs-validation" novalidate>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">Login</label>
      <input type="text" class="form-control" id="validationCustom01" placeholder="Login" value="" required>
      <div class="invalid-feedback">
        Wybrany login nie jest poprawny!
      </div>
      <div class="valid-feedback">
        Ok!
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationEmail">E-mail</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
        </div>
        <input type="email" class="form-control" id="validationEmail" placeholder="E-mail" aria-describedby="inputGroupPrepend" required>
        <div class="invalid-feedback">
          Wprowadzony adres e-mail nie jest poprawny!
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom02">Hasło</label>
      <input type="password" class="form-control" id="validationCustom02" placeholder="Hasło" required>
      <div class="invalid-feedback">
        Hasło nie spełnia podstawowych wymagań.
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationCustom03">Powtórz hasło</label>
      <input type="password" class="form-control" id="validationCustom03" placeholder="Powtórz hasło" required>
      <div class="invalid-feedback">
        Wprowadzone hasłą nie są takie same.
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
      <label for="validationCustom04">Nazwa organizacji</label>
      <input type="text" class="form-control" id="validationCustom04" placeholder="Nazwa organizacji" required>
      <div class="invalid-feedback">
        Nazwa organizacji nie jest poprawna
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
      <label for="validationDescription">Opis organizacji<br />
	  <small class="text-muted font-italic">Czym zajmuje się organizacja? Do jakich celów potrzebuje wolontaroiszy?<br />Im więcej szczegółów, tym łatwiej nam będzie zweryfikować czy pasuje ona do naszych standardów.</small></label>
	  <textarea name="content" class="form-control" id="validationDescription" placeholder="Opis organizacji" required></textarea>
      <div class="invalid-feedback">
        Opis organizacji jest zbyt krótki...
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        Potwierdzam, że zapoznałem się z <a href="/global/index/page/show/regulamin">regulaminem</a> i <a href="/global/index/page/show/polityka-prywatnosci">polityką prywatności<a/>.
      </label>
      <div class="invalid-feedback">
        Musisz potwierdzić, że zapoznałeś się z regulaminem i polityką prywatności
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<button class="btn btn-primary float-right" type="submit">Wyślij zgłoszenie</button>
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
<hr class="featurette-divider">
