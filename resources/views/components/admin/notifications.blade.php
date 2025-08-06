@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@elseif (session('warning'))
<div class="alert alert-success">
    {{ session('warning') }}
</div>
@elseif (session('error'))
<div class="alert alert-success">
    {{ session('error') }}
</div>
@endif