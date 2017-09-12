@if (count($errors) > 0)
    <div class="alert alert-danger" id="alert_id">

        @foreach ($errors->all() as $error)
            <p>{!! $error !!}</p>
        @endforeach

    </div>
@endif

<script>
    $(document).ready(function(){
        $("#alert_id").delay(10000).slideUp();
    });
</script>