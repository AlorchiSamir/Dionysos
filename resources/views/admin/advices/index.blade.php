@extends('admin.layouts.app')

@section('content')
<div>
	<div class="row-fluid">
		<div class="span12">
			<div class="tableau">
				<div class="tableau-title">
					<div class="caption">
						<i class="fa fa-globe"></i> Avis
					</div>
				</div>
				<div class="tableau-body">
					<table class="table table-striped table-bordered table-hover table-full-width" id="category_table">
						<thead>
							<tr>
								<th style="width:250px;">Auteur</th>
								<th style="width:250px;">Date</th>	
								<th style="width:250px;">Note</th>							
								<th>Contenu</th>								
							</tr>
						</thead>
						<tbody><?php
							foreach ($advices as $advice){ 
								?>
								<tr>
									<td><?php echo $advice->user->name; ?></td>
									<td><?php echo $advice->created_at; ?></td>
									<td><?php echo $advice->score; ?></td>
									<td><?php echo $advice->comment; ?></td>
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