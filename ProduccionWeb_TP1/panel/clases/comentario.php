<?php 
Class Comentario{

	private $con;
	
	public function __construct($con){
		$this->con = $con;
	}

	public function getList($estado, $pag, $idprod){
		$desde = ($pag - 1) * 10;
		$hasta = $desde + 10;
		
		$query = " 	SELECT productos.nombre, comentarios.id, comentarios.descripcion, comentarios.calificacion, comentarios.fecha, comentarios.estado
					FROM comentarios 
					INNER JOIN productos 
					ON comentarios.IDproducto = productos.id
					WHERE comentarios.enabled = 1 AND (comentarios.estado = " .$estado. " OR " .$estado. " = 2) AND (comentarios.IDproducto = " .$idprod. " OR " .$idprod. " = 0)
					LIMIT $desde, $hasta";

        return $this->con->query($query); 
	}
	
	public function get($id){
		$query = "	SELECT id
					FROM comentarios WHERE id = ".$id;
        $query = $this->con->query($query); 
			
		$comentario = $query->fetch(PDO::FETCH_OBJ);
			
			$sql = 'SELECT perfil_id, permiso_id
					FROM perfil_permisos  
					WHERE perfil_id = '.$comentario->id;
					
			foreach($this->con->query($sql) as $permiso){
				$comentario->permisos[] = $permiso['permiso_id'];
			}
			/*echo '<pre>';
			var_dump($comentario);echo '</pre>'; */
            return $comentario;
	}

	public function update($modif, $id){
		$act = ($modif -1) * -1;
		$this->con->exec("UPDATE campos_dinamicos SET estado = ".$act." WHERE id = ".$id);
	}	
	
	public function getPaginas($estado){
		$query = "	SELECT 
					CASE
						WHEN COUNT(*)> 0 THEN 
							CASE
								WHEN MOD(COUNT(*),10) = 0 THEN COUNT(*) DIV 10
								ELSE (COUNT(*) DIV 10) + 1
							END

						ELSE 0
					END
					FROM comentarios 
					WHERE comentarios.enabled = 1 AND (comentarios.estado = " .$estado. " or " .$estado. " = 2)";

		return $this->con->query($query)->fetchColumn(); 
	}
}