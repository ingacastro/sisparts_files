@if(isset($success_message))
    <div class="custom-alerts alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ $success_message }}
    </div>
@endif