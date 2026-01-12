<? $adjacent = 1 ?>

<? $total = $pageConfig['rows']; ?>
<? $perPage = $pageConfig['second']; ?>
<? $page = $pageConfig['page']; ?>
<? $url = $pageConfig['url']; ?>

<? $url .= '/page/' ?>
<? $start = ($page - 1) * $perPage ?>
<? $prev = $page - 1 ?>
<? $next = $page + 1 ?>
<? $lastpage = ceil($total/$perPage) ?>
<? $lastpage_min_1 = $lastpage - 1 ?>

<? if($lastpage > 1): ?>
	<nav aria-label="">
	<ul class="pagination justify-content-center">
	
	<? if($page > 1): ?>
		<li class="page-item"><a class="page-link" href='<?= $url ?>1/'>&laquo;&laquo;</a></li>
		<li class="page-item"><a class="page-link" href='<?= $url.$prev ?>/'>&laquo;</a></li>
	<? else: ?>
		<li class='page-item disabled'><a class="page-link">&laquo;&laquo;</a></li>
		<li class='page-item disabled'><a class="page-link">&laquo;</a></li>
	<? endif ?>
	
	<? if($lastpage < 7 + ($adjacent * 2)): ?>
	
		<? for($counter = 1; $counter <= $lastpage; $counter++): ?>
			<? if($counter == $page): ?>
				<li class='page-item active'>
					<a class="page-link"><?= $counter ?></a>
				</li>
			<? else: ?>
				<li class="page-item">
					<a class="page-link" href='<?= $url.$counter ?>/'><?= $counter ?></a>
				</li>
			<? endif ?>
		<? endfor ?>
		
	<? elseif($lastpage > 5 + ($adjacent * 2)): ?>
	
		<? if($page <= 1 + ($adjacent * 2)): ?>
			<? for ($counter = 1; $counter < 4 + ($adjacent * 2); $counter++): ?>
				<? if($counter == $page): ?>
					<li class='page-item active'>
						<a class="page-link"><?= $counter ?></a>
					</li>
				<? else: ?>
					<li class="page-item">
						<a class="page-link" href='<?= $url.$counter ?>/'><?= $counter ?></a>
					</li>
				<? endif ?>
			<? endfor ?>
			<li class='page-item disabled'>
				<a class="page-link">...</a>
			</li>
			<li class="page-item">
				<a class="page-link" href='<?= $url.$lastpage_min_1 ?>/'><?= $lastpage_min_1 ?></a>
			</li>
			<li class="page-item">
				<a class="page-link" href='<?= $url.$lastpage ?>/'><?= $lastpage ?></a>
			</li>
		<? elseif($lastpage - ($adjacent * 2) > $page && $page > ($adjacent * 2)): ?>
			<li class="page-item">
				<a class="page-link" href='<?= $url ?>1/'>1</a>
			</li>
			<li class="page-item">
				<a class="page-link" href='<?= $url ?>2/'>2</a>
			</li>
			<li class='page-item disabled'>
				<a class="page-link">...</a>
			</li>
			<? for($counter = $page - $adjacent; $counter <= $page + $adjacent; $counter++): ?>
				<? if($counter == $page): ?>
					<li class='page-item active'>
						<a class="page-link"><?= $counter ?></a>
					</li>
				<? else: ?>
					<li class="page-item">
						<a class="page-link" href='<?= $url.$counter ?>'><?= $counter ?></a>
					</li>
				<? endif ?>
			<? endfor ?>
			<li class='page-item disabled'>
				<a class="page-link">...</a>
			</li>
			<li class="page-item">
				<a class="page-link" href='<?= $url.$lastpage_min_1 ?>/'><?= $lastpage_min_1 ?></a>
			</li>
			<li class="page-item">
				<a class="page-link" href='<?= $url.$lastpage ?>/'><?= $lastpage ?></a>
			</li>
		<? else: ?>
			<li class="page-item">
				<a class="page-link" href='<?= $url ?>1/'>1</a>
			</li>
			<li class="page-item">
				<a class="page-link" href='<?= $url ?>2/'>2</a>
			</li>
			<li class='page-item disabled'>
				<a class="page-link">...</a>
			</li>
			<? for($counter = $lastpage - (2 + ($adjacent * 2)); $counter <= $lastpage; $counter++): ?>
				<? if($counter == $page): ?>
					<li class='page-item active'>
						<a class="page-link"><?= $counter ?></a>
					</li>
				<? else: ?>
					<li class="page-item">
						<a class="page-link" href='<?= $url.$counter ?>/'><?= $counter ?></a>
					</li>
				<? endif ?>
			<? endfor ?>
		<? endif ?>
	<? endif ?>
	
	<? if($page < $counter - 1): ?>
		<li class="page-item">
			<a class="page-link" href='<?= $url.$next ?>/'>&raquo;</a>
		</li>
		<li class="page-item">
			<a class="page-link" href='<?= $url.$lastpage ?>/'>&raquo;&raquo;</a>
		</li>
	<? else: ?>
		<li class='page-item disabled'>
			<a class="page-link">&raquo;</a>
		</li>
		<li class='page-item disabled'>
			<a class="page-link">&raquo;&raquo;</a>
		</li>
	<? endif ?>
	</ul></div>	  
<? endif ?>