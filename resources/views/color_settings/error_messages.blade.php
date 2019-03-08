@if($errors->any())
    <div class="custom-alerts alert alert-danger fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
        	<?php $email_error_counter = 0 ?>
            @foreach($errors->all() as $error)
            	@if(strpos($error, 'correo') && $email_error_counter == 1) 
            		<?php continue; ?> 
				@elseif(strpos($error, 'correo'))
					<?php $email_error_counter = 1 ?> 
            	@endif
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif