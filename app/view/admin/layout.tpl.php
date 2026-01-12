<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
    <?php 
    	if($selected_project) {
			echo 'Admin: ' . $selected_project->name.' - '.$title;
		} else {
			echo 'Admin: '.$this->title;
		}
	?>
    </title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="/css/admin-panel.css">
  </head>

  <body>


    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?=adminURL('index')?>">Volunteer centre - Admin panel</a>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="<?=adminURL('index', 'profil')?>" style="display:inline-block;">Profil  </a>
          <a class="nav-link" href="<?=adminURL('index', 'logout')?>" style="display:inline-block;">&raquo; Wyloguj</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <? if($admin_nav): ?>
              	<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                  <span>Panel admina</span>
                </h6>
                <ul class="nav flex-column">
                        <? foreach($admin_nav as $nav): ?>
                          <li class="nav-item">
                            <a class="nav-link <? if($nav[1] == $controller): ?>active<? endif; ?>" href="<?=adminURL($nav[1])?>">
                              <span data-feather="<?= $nav[0] ?>"></span>
                              <?= $nav[2] ?> <span class="sr-only">(current)</span>
                            </a>
                          </li>
                        <? endforeach; ?>
                </ul>
                
            <? endif ?>
            
			<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
			  <span>Wybierz projekt do zarządzania</span>
            </h6>
            
            <div class="dropdown input-group col-auto">
  				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    				<? if($selected_project): ?>
        				<?= $selected_project->name ?>
        			<? else: ?>
                      	Wybierz projekt...
                    <? endif ?>
  				</button>

  				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
  					<? if(sizeof($member_projects) > 0): ?>
  						<a class="dropdown-item" href="<?=adminURL($controller, $action, array_merge($params, ['project' => 0]))?>"><i>-- Brak projektu --</i></a>
  						<? foreach($member_projects as $project): ?>
    						<a class="dropdown-item" href="<?=adminURL($controller, $action, array_merge($params, ['project' => $project->id]))?>"><?= $project->name ?></a>
    					<? endforeach ?>
    				<? else: ?>
    					<a class="dropdown-item" href="#"><i>Brak projektów...</i></a>
    				<? endif ?>
 				</div>
			</div>
            
            <? if($selected_project): ?>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                  <span>Panel klienta - <?= $selected_project->name ?></span>
                </h6>
                <ul class="nav flex-column">
                    <? foreach($project_nav as $nav): ?>
                      <li class="nav-item">
                        <a class="nav-link <? if($nav[1] == $controller && $nav[0] != 'globe'): ?>active<? endif; ?>" href="<?= $nav[0] != 'globe' ? adminURL($nav[1]) : publicURL($selected_project->slug) ?>">
                          <span data-feather="<?= $nav[0] ?>"></span>
                          <?= $nav[2] ?> <span class="sr-only">(current)</span>
                        </a>
                      </li>
                    <? endforeach; ?>
                </ul>
            <? endif ?>
			
          </div>
        </nav>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/js/jquery-3.4.1.min.js"></script>
        <script src="/js/jquery-ui.min.js"></script>
        <script src="/js/Popper.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/bootstrap.bundle.min.js"></script>
    
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        	<? if(count($errors)): ?>
        		<? foreach($errors as $error): ?>
        		<div class="container">
        			<br><br>
        			<div class="alert alert-danger align-items-center" role="alert">
 						<h4 class="alert-heading">Ups, wystąpił problem.</h4><br>
  						<p><?=$error?></p>
  						<hr>
  						<p class="mb-0"><em>Jeśli zrobiłeś wszystko tak jak należy i pojawił się ten błąd, skontaktuj się administratorem.</em></p>
					</div>
				</div>
        		<? endforeach; ?>
    		<? endif; ?>
    		
    		<? if(count($success)): ?>
        		<? foreach($success as $success_one): ?>
        		<div class="container">
        			<br>
        			<div class="alert alert-success align-items-center" role="alert">
        				<br>
  						<p><?=$success_one?></p>
					</div>
				</div>
        		<? endforeach; ?>
    		<? endif; ?>
    		
        	<?= $content ?>
		</main>
      </div>
    </div>



    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

  </body>
</html>
