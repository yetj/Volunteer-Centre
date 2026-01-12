<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Strony - Lista</h1>
	<a href="<?= adminURL('pages', 'add'); ?>" class="btn btn-success float-right"><span data-feather="plus"></span> Dodaj stronę</a>
</div>

			<? if($pages): ?>
    			<button class="btn btn-primary reorder_link" id="saveReorder"><span data-feather="edit-2"></span> Edytuj kolejność</button>
    			<div id="reorderHelper" class="light_box" style="display:none;">
    				1. Przeciągnij wpisy w tabeli, aby zmienić ich kolejność.<br>
    				2. Kliknij 'Zapisz kolejność' kiedy zakończysz.
    			</div>
    			<br>
    			<br>
			<? endif ?>
			<div class="table-responsive">
				<table class="table table-striped table-sm">
				  <thead>
					<tr class="text-center">
					  <th class="align-middle">#</th>
					  <th class="align-middle">Nazwa</th>
					  <th class="align-middle">Slug</th>
					  <th class="align-middle">Status</th>
					  <th class="align-middle">Ukryta w menu</th>
					  <th class="align-middle">Akcje</th>
					</tr>
				  </thead>
				  <tbody class="reorder-table">
				  <? if($pages): ?>
    				  <? foreach($pages as $page): ?>
    					<tr class="text-center" id="entry_id_<?= $page->id ?>">
    					  <td><?= $page->id ?></td>
    					  <td><?= $page->title ?></td>
    					  <td><?= $page->slug ?></td>
    					  <? if($page->system == 1): ?>
    					  	<td><span class="badge badge-primary">SYSTEMOWA</span></td>
    					  <? elseif($page->display == 1): ?>
    					  	<td><span class="badge badge-success">Aktywna</span></td>
    					  <? else: ?>
    					  	<td><span class="badge badge-danger">Nieaktywna</span></td>
    					  <? endif ?>
    					  <? if($page->hidden): ?>
    					  	<td><span class="badge badge-danger">Tak</span></td>
    					  <? else: ?>
    					  	<td><span class="badge badge-success">Nie</span></td>
    					  <? endif ?>
    					  <td>
    						<a href="<?= adminURL('pages', 'edit', ['id' => $page->id]) ?>" class="badge badge-pill badge-info"><span data-feather="edit-2"></span></a>
    						<? if($page->system == 0): ?>
    							<a href="<?= adminURL('pages', 'delete', ['id' => $page->id]) ?>" class="badge badge-pill badge-danger"><span data-feather="trash-2"></span></a>
    						<? endif ?>
    					  </td>
    					</tr>
    					<? endforeach ?>
					<? else: ?>
						<tr>
							<td colspan="5" align="center"><i>Brak stron w bazie</i></td>
						</tr>
					<? endif ?>
				  </tbody>
				</table>
			</div>
			
			
<script>
jQuery(document).ready(function(){
    jQuery('.reorder_link').on('click',function(){
        jQuery("tbody.reorder-table").sortable({ tolerance: 'pointer' });
        jQuery('.reorder_link').html('<span data-feather="save"></span> Zapisz kolejność');
		feather.replace();
        jQuery('.reorder_link').attr("id","saveReorder");
        jQuery('#reorderHelper').slideDown('slow');
        jQuery('.image_link').attr("href","javascript:void(0);");
        jQuery('.image_link').css("cursor","move");
        jQuery("#saveReorder").click(function( e ){
            if( !jQuery("#saveReorder i").length ){
                jQuery(this).html('Zapisywanie...');
                jQuery("tbody.reorder-table").sortable('destroy');
                jQuery("#reorderHelper").html( "Zapisywanie kolejności... Może to chwilę potrwać. Proszę nie opuszczać tej strony." ).removeClass('light_box').addClass('notice notice_error');
    
                var h = [];
                jQuery("tbody.reorder-table tr").each(function() {  h.push(jQuery(this).attr('id').substr(9));  });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= adminURL('pages', 'update_order') ?>",
                    data: {ids: "" + h + ""},
                    success: function(data){
                        window.location.reload();
                    }
                });
                return false;
            }   
            e.preventDefault();     
        });
		
    });
});
</script>