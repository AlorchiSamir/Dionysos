@extends('admin.layouts.app')

@section('content')
<div>
	<div class="row-fluid">
		<div class="span12">
			<div class="tableau">
				<div class="tableau-title">
					<div class="caption">
						<i class="fa fa-globe"></i> Messages
					</div>
				</div>
				<div class="tableau-body">
					<table class="table table-striped table-bordered table-hover table-full-width" id="category_table">
						<thead>
							<tr>
								<th>Titre</th>
								<th>Auteur</th>
								<th style="width:250px;">Date</th>	
								<th style="width:250px;">Lu</th>							
								<th style="width:250px;">Répondu</th>								
							</tr>
						</thead>
						<tbody><?php
							foreach ($messages as $message){ 
								?>
								<tr>
									<td><?php echo $message->title; ?></td>
									<td><?php echo $message->getSender()->name; ?></td>
									<td><?php echo $message->send_time; ?></td>
									<td><?php echo $message->view_time; ?></td>
									<td><?php echo $message->response_time; ?></td>
								</tr>
							<?php }
						?></tbody>
					</table>					
				</div>				
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
@endsection