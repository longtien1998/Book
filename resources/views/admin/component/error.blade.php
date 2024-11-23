@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <h5>Thông báo !</h5>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif