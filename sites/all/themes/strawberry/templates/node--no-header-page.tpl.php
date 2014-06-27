<?php
	// no main header image page, used for terms page
?>

<section id="terms" class="light-grey-bg menu-container">
		
	<div class="h10"><!-- --></div>
	
	<div class="max-container">
		<div class="h25 onlyOnMobile"><!-- --></div>
		
		<?php strawberry_RenderSiteMenu(); ?>
		

		<div class="max-content">
			<div class="tomb">
				<div class="h40"><!-- --></div>
				<h1><?php print $title; ?></h1>
				
				<?php print $body[0]['safe_value'];?>
			   
				<p class="btop"><a href="#terms">Back to top</a></p>
			
			<div class="clear"><!-- --></div>
			</div>
		</div>
		<div class="clear"><!-- --></div>
	</div>
	<div class="h100"><!-- --></div>
</section>
	
	
