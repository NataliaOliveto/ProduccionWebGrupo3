<?php
require('inc/filtro.php');
?>

<div class="container-fluid">

	<?php $comentarioMenu = 'Comentarios';
	
	include('inc/side_bar.php');

	if(isset($_GET['modif'], $_GET['id'])){
		$comen->update($_GET['modif'], $_GET['id']);
		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '';
		header('Location: comentarios.php?estado='.$_GET['estado'].'&pagina='.$pagina);	
	}

	?>

	<div class="col-sm-9 col-md-10 main">

		<p class="visible-xs">
			
		</p>

		<h1 class="page-header">
			<?php echo $comentarioMenu ?>
		</h1>

		<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
			<a href="comentarios.php?estado=<?php echo $_GET['estado']?>&pagina=1"><button type="button" class="btn btn-warning" title="Primera">|<-</button></a>
			<a href="comentarios.php?estado=<?php echo $_GET['estado']?>&pagina=<?php echo(($_GET['pagina'] != 1) ? ($_GET['pagina'] - 1) : $_GET['pagina']); ?>"><button type="button" class="btn btn-warning" title="Anterior"><</button></a>
			<div class="btn-group">
				<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php echo $_GET['pagina'] ?>
				</button>
					<?php
					$estadito = $_GET['estado'];					
					$paginado = $comen->getPaginas($estadito);?>
					<div class="dropdown-menu">
						<?php 
							for($i = 1; $i <= $paginado; $i++){ ?>
							<a class="dropdown-item" href="comentarios.php?estado=<?php echo $_GET['estado']?>&pagina=<?php echo $i ?>">
							<?php 		
							echo $i; ?> </a>
						<?php }?>
					</div>
			</div>			
			<a href="comentarios.php?estado=<?php echo $_GET['estado']?>&pagina=<?php echo(($_GET['pagina'] != $paginado ) ? ($_GET['pagina'] + 1) : $_GET['pagina'])?>"><button type="button" class="btn btn-warning" title="Siguiente">></button></a>
			<a href="comentarios.php?estado=<?php echo $_GET['estado']?>&pagina=<?php echo $paginado ?>"><button type="button" class="btn btn-warning" title="Anterior">->|</button></a>
		</div>

		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Ranqueo</th>
						<th>Producto</th>
						<th>Fecha</th>
						<th>Comentario</th>
						</tr> 
				</thead>
				
				<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
					<div class="btn-group">
					<button type="button" id= "buttonOrderBy" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php echo $lblSort ?>
					</button>
					<div class="dropdown-menu">          
						<a class="dropdown-item" href="comentarios.php?estado=0&pagina=1">
						Inactivos
						</a>
						<a class="dropdown-item" href="comentarios.php?estado=1&pagina=1">
						Activos
						</a>
						<a class="dropdown-item" href="comentarios.php?estado=2&pagina=1">
						Todos
						</a>
					</div>
				</div>
	
				<tbody>
				
					<?php 
					$pagina = empty($_GET['pagina']) ? 0 : $_GET['pagina'];
					foreach ($comen->getList($_GET['estado'], $pagina) as $comentarios) { ?>
						<tr>
						<td><?php echo $comentarios['id'];?></td>
						<td><?php echo $comentarios['calificacion'];?></td>
						<td><?php echo $comentarios['nombre'];?></td>
						<td><?php echo $comentarios['fecha'];?></td>
						<td><?php echo $comentarios['descripcion'];?></td>
						<td>
							<?php if($comentarios['estado'] == 0){ ?>
								<a href="comentarios.php?estado=<?php echo $_GET['estado']?>&modif=<?php echo $comentarios['estado'] ?>&id=<?php echo $comentarios['id']?>&pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : '' ?>"><button type="button" class="btn btn-success" title="Activar">A</button></a>
							<?php } else { ?>
								<a href="comentarios.php?estado=<?php echo $_GET['estado']?>&modif=<?php echo $comentarios['estado'] ?>&id=<?php echo $comentarios['id']?>&pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : '' ?>"><button type="button" class="btn btn-warning" title="Desactivar">D</button></a>
							<?php } ?>
						</td>
						</tr>
					<?php } ?> 
				</tbody>
			</table>
		</div>
	</div>
	
</div>
</div>

<?php include('inc/footer.php'); ?>