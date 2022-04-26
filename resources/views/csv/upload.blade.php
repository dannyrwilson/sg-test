@extends('layout')

@section('body_content')
	
	<h1>Street Group Tech Test</h1>
	
	<hr />

	<form enctype="multipart/form-data" action="" method="post">
		
		@csrf

		@if ($errors->any())
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
		@endif
 

		<div class="card">
			<div class="card-header">
				CSV File Upload
			</div>
			<div class="card-body">
				<div class="form-group">
					<label for="csvFile" class="mb-2">Choose CSV File:</label>
					<input type="file" name="csvFile" class="form-control" id="csvFile" />
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>

	</form>
	
@endsection