<div class="card card-user">
    <div class="image">
        <img src="{{url('theme/assets/img/background.jpg')}}" alt="..."/>
    </div>
    <div class="content">
        <div class="author">
            <img class="avatar border-white" src="{{url('theme/assets/img/faces/face-2.jpg')}}" alt="..."/>
            <h4 class="title">{{ $model->first_name }} {{ $model->last_name }}<br />
                <a><small>Member</small></a>
            </h4>
        </div>
        <p class="description text-center">
            {{ $model->email }}
        </p>
    </div>
    <hr>
    <div class="text-center">
        <div class="row">
            <div class="col-md-3 col-md-offset-1">
                <h5>12<br /><small>Files</small></h5>
            </div>
            <div class="col-md-4">
                <h5>2GB<br /><small>Used</small></h5>
            </div>
            <div class="col-md-3">
                <h5>24,6$<br /><small>Spent</small></h5>
            </div>
        </div>
    </div>
</div>