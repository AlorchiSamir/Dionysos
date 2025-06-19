@extends('admin.layouts.app')

@section('content')
<div>
	<div class="row-fluid">
		<div class="span12">
			<div class="tableau">
				<div class="tableau-title">
					<div class="caption">
						<i class="fa fa-globe"></i> Métiers
					</div>
				</div>
				<div class="tableau-body">
					<div class="clearfix">
						<div class="btn-group">
							<a href="{{ url('admin/metier/create') }}" id="create" class="btn green">Ajouter</a>
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover table-full-width" id="category_table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nom</th>
								<th style="width:30px;">Couleur</th>	
								<th style="width:30px;">Professionels</th>	
								<th style="width:30px;"><i class='fa fa-eye'></i></th>							
								<th style="width:55px;"></th>								
							</tr>
						</thead>
						<tbody><?php
							foreach ($metiers as $metier){ 
								?>
								<tr><td><?php echo $metier->id; ?></td>
								<td><?php echo $metier->name; ?></td>
								<td><div style='background-color:{{ $metier->color }}; height: 26px; width: 100%;' ></div></td>
								<td><?php echo count($metier->professionals); ?></td>
								<td><?php //echo $metier->getCountVisits(); ?></td>
								<td>
									<a href="{{ url('admin/metier/skill/'.$metier->id) }}" class='btn btn-primary'><i class='icon-edit'></i>Skills</a>
									<a href="{{ url('admin/metier/update/'.$metier->id) }}" class='btn btn-primary'><i class='icon-edit'></i> Modifier</a>
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