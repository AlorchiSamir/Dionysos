<div class="modal fade" id="message-modal-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ __('message') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                
            </div>
            <form id='message-admin-form' method="POST" action="{{ url('message/send') }}" enctype="multipart/form-data">
                <div class="modal-body">      
                    
                        @csrf
                        <div class="form-group row">
                            <label for="title" class="col-md-2 col-form-label">{{ __('title') }}</label>
                            <div class="col-md-12">
                                <input id="title" type="text" class="form-control" name="title">
                            </div>
                        </div>
                        <!--<div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-12">
                                <input id="email" type="text" class="form-control" name="email">
                            </div>
                        </div>-->

                        <div class="form-group row">
                            <label for="content" class="col-md-2 col-form-label">{{ __('text') }}</label>
                            <div class="col-md-12">
                                <textarea class="form-control" name='content'></textarea>
                            </div>
                        </div>

                </div>
                <div class='modal-footer'>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">{{ __('send') }}</button>
                        </div>
                    </div>
                </div>
            </form>            
        </div>
    </div>
</div> 