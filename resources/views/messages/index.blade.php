@extends('layouts.app')

@section('content')
<div class='mini-banner'>
  <div class="container">
      <ol class="breadcrumb-nav">
          <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
          <li class="breadcrumb-item active">{{ __('messages') }}</li>
      </ol>
  </div>
</div>
<div class='container'>
	<div class="row-fluid">
		<div class="span12">
			<div class="tableau message-box">				
				<div class="tableau-body">
					<table class="table table-striped table-bordered table-hover table-full-width" id="category_table">
						<thead>
							<tr>
								<th>{{ __('title') }}</th>
								<th>{{ __('author') }}</th>
								<th style="width:250px;">{{ __('date') }}</th>	
								<th style="width:250px;">{{ __('view') }}</th>							
								<th style="width:250px;">{{ __('reply') }}</th>								
							</tr>
						</thead>
						<tbody><?php
							foreach ($messages as $message){ 
								?>
								<tr onclick="location.href='{{ url('/message/'.$message->id) }}'">
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