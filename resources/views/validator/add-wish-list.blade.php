@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
        <div class="alert alert-{{ $msg }}">
            <i class="fa fa-check-circle"></i>

            @if($msg == "warning")

                You must
                <a href="{{ URL::route('users.getLogin') }}">login</a> or
                <a href="{{ URL::route('users.getRegister') }}">create an account</a> to save

            @endif

            @if($msg == "success")
                Success: You have added
            @endif

            <a href="{{ $model->getUrl() }}">{{ $model->title }}</a> to your
            <a href="#">wish list</a>!
            <button type="button" class="close" data-dismiss="alert">×</button>

        </div>
    @endif
@endforeach

