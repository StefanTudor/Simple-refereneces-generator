<!DOCTYPE html>
<html>
<head>
	<title>Generador de referencias</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="robots" content="noindex">
	<meta name="googlebot" content="noindex">
	<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<style>
		body {
			background-color: #6fbbb0;
			height: 100vh;
		}
		
		.bg-grey {
			background-color: #eee;
		}
		
		.bg-turq {
			background-color: #bed5c8;
		}

		.bg-red {
        	background-color: #e9c4c4;
        }
		
		.log-line:hover {
		   -webkit-transition-delay:0s;
		   -webkit-transition-duration:0.5s;
		   -webkit-transition-property:all;
		   -webkit-transition-timing-function:ease;
		   background-color:#00000018;
		}

		
	</style>
</head>
<body>

<?php
$cookie_name = "user";
if(!isset($_COOKIE[$cookie_name])) {
	 ?>
	 <div style="height:30vh"></div>
	 <div class="container">
		 <div class="row justify-content-center m-3">
			<div class="col-md-7 col-lg-5 bg-light p-5">
				<h4 class="mb-3">Completa tu nombre:</h4>
				<form action="/" method='post' onsubmit="setUserCookie">
					<input type='text' name='name' class="form-control form-control-lg mb-3 rounded-0" type="text" placeholder="Nombre">
					<button type='submit' class="form-control btn btn-dark btn-lg submit rounded-0">GUARDAR</button>
				</form>
			</div>
		 </div>
	 </div>
	 <?php
	 
} else {
	?>
	
	<div style="height:8vh"></div>
	<div class="container">
		<div class="row justify-content-center m-1 rounded bg-light">
			<div class="col-md-10 col-lg-10 p-5 pb-3">
				<button id="increase" class="btn btn-dark btn-lg rounded w-100 py-3">➕ Generar referencia</button>
			</div>
    
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-outline-secondary mb-3" id="btn-update" data-bs-toggle="modal" data-bs-target="#exampleModal" style="max-width:300px;">
				Cambiar la proxima referencia	
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Actualizar la proxima referencia</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<input type="number" class="form-control" id="ref-update" aria-label="Referencia" placeholder="Referencia">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
							<button type="button" class="btn btn-success" id="btn-send-ref">Actualizar</button>
						</div>
					</div>
				</div>
			</div>

    
			<div class="col-md-10 col-lg-10 p-lg-5 mb-5 p-sm-0 overflow-auto" style="max-height:60vh;">
			
	<?php
	
	$csvFile = file('log_file.csv');
    $log = [];
    foreach ($csvFile as $line) {
        $log[] = str_getcsv($line);
    }
		
	if($log) { 
		foreach (array_reverse($log) as $log_line) {
			if($log_line[3] == 0) {
				if($log_line[0] == $_COOKIE[$cookie_name]) {
				?>
					<div class="log-line p-2 px-4 bg-turq border-bottom d-flex justify-content-between">
						<span>Has generado el presupuesto con el número <b>#<?php echo $log_line[1] ?></b>.</span>
						<span><?php echo $log_line[2] ?></span>
					</div>
				<?php
				} else {
				?>
				<div class="log-line p-2 px-4 bg-grey border-bottom d-flex justify-content-between">
					<span><?php echo $log_line[0] ?> generó el presupuesto con el número <b>#<?php echo $log_line[1] ?></b>.</span>
					<span><?php echo $log_line[2] ?></span>
				</div>
				<?php
				}
			}
				
			if($log_line[3] == 1) {
				if($log_line[0] == $_COOKIE[$cookie_name]) {
				?>
					<div class="log-line p-2 px-4 bg-red border-bottom d-flex justify-content-between">
						<span>Has establecido la siguiente referencia en <b>#<?php echo $log_line[1] ?></b>.</span>
						<span><?php echo $log_line[2] ?></span>
					</div>
				<?php
				} else {
				?>
				<div class="log-line p-2 px-4 bg-red border-bottom d-flex justify-content-between">
					<span><?php echo $log_line[0] ?> estableció la siguiente referencia en <b>#<?php echo $log_line[1] ?></b>.</span>
					<span><?php echo $log_line[2] ?></span>
				</div>
				<?php
				}
			}
		}
	} else {
		echo "No data.";
	}
	?>
			</div>
		 </div>
	</div>
	<?php
}
?>

<script>
	function setUserCookie() {
		<?php
		if(isset($_POST['name']) && !empty($_POST['name'])){
			setcookie('user',$_POST['name'], time() + 86400 * 30, '/');
			header("refresh: 0;");
		}
		?>
	}

</script>

<script type='text/javascript'>

$("#increase").click(function(event){

    var request = $.ajax({
        url: "/increase.php",
        type: "post"
    });

    request.done(function (response, textStatus, jqXHR){
		location.reload(true); 
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
});

$("#btn-update").click(function() {

    var request = $.ajax({
        url: "/get_ref.php",
        type: "post"
    });

    request.done(function (response, textStatus, jqXHR){
		$("#ref-update").attr("value", parseInt(response));
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
});

$("#btn-send-ref").click(function() {

	var updatedRef = $("#ref-update").val();
    var request = $.ajax({
        url: "/update_ref.php",
        type: "post",
		data: {"updated_ref":updatedRef}
    });

    request.done(function (response, textStatus, jqXHR){
		location.reload(true); 
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>
