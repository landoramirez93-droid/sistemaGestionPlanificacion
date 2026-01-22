@if ($errors->any())
<div class="alert alert-danger">
    <strong>Revisa los siguientes errores:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif