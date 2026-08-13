<!DOCTYPE html>
<html lang="en">

	@include('layouts.head')

	<body>
		<div class="page-wrapper">
			@include('layouts.header')

			<div class="main-container">

				@include('layouts.sidebar')

				<div class="app-container">
					@yield('content')

					@include('layouts.footer')
				</div>
			</div>

		</div>
		
		@include('layouts.script')
	</body>

</html>