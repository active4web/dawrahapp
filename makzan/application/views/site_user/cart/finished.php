<div class="page-content mb-5">
        <div class="container">
		<div class="page-header rounded p-3">
                <h1 class="page-title mb-auto">
                    <span class="fa-layers fa-fw ml-3">
                        <i class="fas fa-circle" data-fa-transform="grow-12"></i>
                        <i class="fa-inverse fas fa-shopping-bag" data-fa-transform="shrink-2"></i>
                    </span>
                    <?=$title?>
                </h1>
            </div>
			<br>
            <p>تم إرسال طلبك بنجاح وجاري العمل عليه</p>
        </div><!-- .container -->
    </div><!-- .page-content -->
	<script type="text/javascript">
	$( document ).ready(function() {
		setTimeout(function(){
			window.location = "<?=base_url();?>";
		}, 5000);
	});
	</script>