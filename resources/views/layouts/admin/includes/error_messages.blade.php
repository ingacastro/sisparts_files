@if($errors->any())
<div class="custom-alerts alert alert-danger fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
		@if(isset($title)) <h5 style="font-weight: bold">{{ $title }}</h5>@endif
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif