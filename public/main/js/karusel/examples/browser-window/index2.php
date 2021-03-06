<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="cache-control" content="no-cache">
	
	<title>Slides, A Slideshow Plugin for jQuery</title>
	
	<link rel="stylesheet" href="css/style33.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script src="js/slides.js"></script>
	
	<script>
		$(function(){
			$("#slides").slides({
				slide: {
					browserWindow: true
				}
			});
		});
	</script>
</head>
<body>
	
	<div id="container">
		<div id="slides">
			<img src="http://slidesjs.com/examples/standard/img/slide-1.jpg" width="780" height="300" alt="Slide 1">
			
			<img src="http://slidesjs.com/examples/standard/img/slide-2.jpg" width="780" height="300" alt="Slide 2">

			<img src="http://slidesjs.com/examples/standard/img/slide-3.jpg" width="780" height="300" alt="Slide 3">

			<img src="http://slidesjs.com/examples/standard/img/slide-4.jpg" width="780" height="300" alt="Slide 4">

			<img src="http://slidesjs.com/examples/standard/img/slide-5.jpg" width="780" height="300" alt="Slide 5">

			<img src="http://slidesjs.com/examples/standard/img/slide-6.jpg" width="780" height="300" alt="Slide 6">

			<img src="http://slidesjs.com/examples/standard/img/slide-7.jpg" width="780" height="300" alt="Slide 7">
		</div>
	</div>
	
</body>
</html>
