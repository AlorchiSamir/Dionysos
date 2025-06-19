@extends('admin.layouts.app')

@section('content')
<div>
	<div class="row-fluid">
		<div class="span12">
			<div class="tableau">
				<div class="tableau-title">
					<div class="caption">
						<i class="fa fa-globe"></i> Professionels
					</div>
				</div>
				<div class="tableau-body">
					<table class="table table-striped table-bordered table-hover table-full-width" id="category_table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nom</th>
								<th style="width:30px;">Téléphone</th>	
								<th style="width:30px;">Email</th>							
								<th style="width:55px;"></th>								
							</tr>
						</thead>
						<tbody><?php
							foreach ($professionals as $professional){ 
								?>
								<tr><td><?php echo $professional->id; ?></td>
								<td><?php echo $professional->surname; ?></td>
								<td><?php echo $professional->tel; ?></td>
								<td><?php echo $professional->email; ?></td>
								<td>
									<a href="{{ url('admin/professional/validate/'.$professional->id) }}" class='btn btn-primary'>
										<i class='icon-edit'></i>Valider
									</a>
								</td></tr>
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