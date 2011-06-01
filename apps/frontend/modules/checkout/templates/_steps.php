<div style=" float: right;width: 700px;margin-bottom: 20px;">
	<ol id="progress" style="width:<?php echo count($availableSteps) * 170 ?>px">
		<?php $i = 0; foreach ($availableSteps as $step => $infos) : $i++;?>
		<li class="step <?php echo ($i === 1) ? 'first ' : '' ?><?php echo ($i === count($availableSteps)) ? 'last ' : '' ?><?php echo ($step === $currentStep) ? 'current ' : '' ?><?php echo $step ?>">
			<a href="#">
				<?php if($step === $currentStep) : ?><strong><?php endif; ?>
				<span><?php echo $infos['title'] ?></span>
				<?php echo $infos['subtitle'] ?>
				<?php if($step === $currentStep) : ?></strong><?php endif; ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ol>
</div>