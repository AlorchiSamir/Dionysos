<?php $messages = \App\Models\Tools\Message::getInstance()->fetch();
?>
@if(!is_null($messages))
	
<div class="portlet-body container" style='margin-top: 10px'>
	<?php if(isset($messages[\App\Models\Tools\Message::TYPE_ERROR])): 
		$error = $messages[\App\Models\Tools\Message::TYPE_ERROR];
		foreach ($error as $message): ?>
			<div class="alert alert-error message-info">
				<button class="close" data-dismiss="alert"></button>
				<strong>{{ __('error') }} !</strong> <?= $message; ?>
			</div>
	<?php endforeach;
	endif; ?>
	<?php if(isset($messages[\App\Models\Tools\Message::TYPE_WARNING])): 
		$warning = $messages[\App\Models\Tools\Message::TYPE_WARNING];
		foreach ($warning as $message): ?>
			<div class="alert message-info">
				<button class="close" data-dismiss="alert"></button>
				<strong>{{ __('warning') }} !</strong> <?= $message; ?>
			</div>
	<?php endforeach;
	endif; ?>
	<?php if(isset($messages[\App\Models\Tools\Message::TYPE_SUCCESS])): 
		$success = $messages[\App\Models\Tools\Message::TYPE_SUCCESS];
		foreach ($success as $message): ?>
			<div class="alert alert-success message-info">
				<button class="close" data-dismiss="alert"></button>
				<?= $message; ?>
			</div>
	<?php endforeach;
	endif; ?>
	<?php if(isset($messages[\App\Models\Tools\Message::TYPE_INFO])): 
		$info = $messages[\App\Models\Tools\Message::TYPE_INFO];
		foreach ($info as $message): ?>
			<div class="alert alert-info message-info">
				<button class="close" data-dismiss="info"></button>
				<strong>{{ __('info') }} !</strong> <?= $message; ?>
			</div>
	<?php endforeach;
	endif; ?>
</div> 
<?php \App\Models\Tools\Message::getInstance()->clean(); ?>
@endif