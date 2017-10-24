@extends('frontend.master')

@section('content')

	<div class="container">

		@include('validator.flash-message')

		<div class="row">
			<div id="content" class="col-sm-12">

				<div class="row">
					<?php if(count($model) == 0){
						echo "There is no product that matches the search criteria.";
					}?>
					<?php foreach ($model as $key=>$item): ?>
						<div class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="product-thumb transition">
								<div class="image">
									<a href="{{ URL::route('frontend.articles.pricing', ['id' => $item->id, 'url' => $item->url_title.".html" ]) }}">
										<img src="{{url('images/'.$item->image)}}" alt="{{ $item->title }}" title="{{ $item->title }}"
											 class="img-responsive" style="width: 100%">
									</a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="row">
					<div class="text-center">
						<a href="{{ URL::route('frontend.articles.getListProduct') }}" class="btn btn-primary">Show List Product</a>
					</div>
				</div>


			</div>
		</div>
	</div>


@stop