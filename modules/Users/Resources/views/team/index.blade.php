@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
            <li><a href="#">Team</a></li>
        </ul>
        <?php
        $searchTeam = app('request')->input('searchTeam');
        ?>

        <div class="row">
            <div id="content" class="col-sm-9">
                <form class="form-inline" method="GET">
                    <input type="text" class="form-control" name="searchTeam" placeholder="Email..." value="{{ $searchTeam }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <span style="margin-left: 20px">Your Sponsor: {{ ($model_sponsor) ? $model_sponsor->userSponsor->email : "No Sponsor"}} </span>
                </form>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            My Team
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-left">Email</td>
                                    <td class="text-center">Date Join</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($model) == 0): ?>
                                    <tr>
                                        <td colspan="5">No member</td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($model as $item): ?>
                                    <tr>
                                        <td class="text-left" style="vertical-align: middle">{{ $item->userMember->email }}</td>
                                        <td class="text-center" style="vertical-align: middle"><span class="label label-success">{{ $item->created_at }}</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo $model->render(); ?>
                </div>

                <div class="buttons clearfix">
                    <div class="pull-right"><a href="{{ URL::route('users.getMyAccount') }}" class="btn btn-primary">Continue</a></div>
                </div>
            </div>

            @include('users::includes.my_account_column_right')

        </div>

    </div>
</div>
@stop
