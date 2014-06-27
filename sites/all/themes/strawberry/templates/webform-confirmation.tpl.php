<?php

/**
 * @file
 * Customize confirmation screen after successful submission.
 *
 * This file may be renamed "webform-confirmation-[nid].tpl.php" to target a
 * specific webform e-mail on your site. Or you can leave it
 * "webform-confirmation.tpl.php" to affect all webform confirmations on your
 * site.
 *
 * Available variables:
 * - $node: The node object for this webform.
 * - $confirmation_message: The confirmation message input by the webform author.
 * - $sid: The unique submission ID of this submission.
 */
?>


<section class="light-grey-bg section_page scroll-section">
	<div class="h10"></div>
	<div class="max-container">
		
		<?php strawberry_RenderSiteMenu(); ?>

		<div class="middle-container">


			<div class="webform-confirmation">
			  <?php if ($confirmation_message): ?>
				<?php print $confirmation_message ?>
			  <?php else: ?>
				<p><strong><?php print t('Thank you, your submission has been received.'); ?></strong></p>
			  <?php endif; ?>
			</div>
			

		</div>
	</div>
</section>