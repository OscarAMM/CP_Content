<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class modelo_catalogos extends CI_Model
{	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->database();
	}
	public function listar($reglas = '', $vars = '')
	{
		$vars = elements(array('limit', 'offset', 'orderby','orden','select','tabla','join','left_join','group_by','where'), $vars);
		$reglas = elements(array('where','like'),$reglas);
        if($vars['select']){$this->db->select("".$vars['select']."",false);}
		$this->db->from($vars['tabla']);
        $this->db->order_by($vars['orden'],false);

		if($vars['join']){
			foreach($vars['join'] as $key => $value){
				if($value != false) $this->db->join($key,$value);
			}
		}
		if($vars['left_join']){
			foreach($vars['left_join'] as $key => $value){
				if($value != false) $this->db->join($key,$value,'left');
			}
		}
		
		if($vars['where']){$this->db->where("".$vars['where']."");}
		
		if($reglas['where']){
			foreach($reglas['where'] as $key => $value){
                if($key == 'idestatus'){
                   if($value != false) $this->db->where('cp_solicitudes.idestatus',$value);   
                }
				else{
					if($key == 'IN_WHERE'){
						foreach($value as $key2 => $value2){
							$value2 = explode(',', $value2);
							$this->db->where_in($key2,$value2,false);
							/*foreach($value2 as $key3 => $value3){
								$par1 = $par2 = "";
								if($key3 == 0){ $par1 = "((";$par2 = "";}
								else {$par1 = "";$par2 = "";}

								if($key3 == 1) {$par2 = ")";$par1 = "";}
								else  {$par1 = "";$par2 = "";}

								if($key3 == 0){
									$this->db->where($par1.$key3,$value3);
								}
								else{
									$this->db->or_where($key3,$value3.$par2);
								}
							}*/
						}
					}
					else{
						$this->db->where($key,$value);  
					}
				}
			}
		}
        if($reglas['like']){
			foreach($reglas['like'] as $key => $value){
				if($value != false) $this->db->like($key,$value);
			}
		}
		
		if($vars['group_by']){
			foreach($vars['group_by'] as $key => $value){
				$this->db->group_by($value);
			}
		}

		if($vars['limit'] && $vars['offset']) $this->db->limit($vars['limit'],$vars['offset']);
		elseif($vars['limit']) $this->db->limit($vars['limit']);

		$query=$this->db->get();
		return $query->result_array();
	
	}
	function selectDATA($catalogo){
		switch($catalogo) {
			case 'tipoBien': 
				$this->db->select('IdTipoBien AS id, NombreTipoBien, AbreviacionBien',false);
				$this->db->from('cp_cat_tipos_bienes');
				$this->db->order_by('NombreTipoBien');
				$query = $this->db->get();
				$res = $query->num_rows();
				$arr = array();
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						$arr[$value['id']] = $value['NombreTipoBien']."(".$value['AbreviacionBien'].")";
					}
				}
				return $arr;
				break;
			case 'adquisicion': 
				$this->db->select('IdMotivoMovimiento AS id, NombreMotivo, CodigoMotivo',false);
				$this->db->from('cp_cat_motivos_movimientos');
				$this->db->order_by('NombreMotivo');
				$query = $this->db->get();
				$res = $query->num_rows();
				$arr = array();
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						$arr[$value['id']] = $value['NombreMotivo']."(".$value['CodigoMotivo'].")";
					}
				}
				return $arr;
				break;
			case 'recurso': 
				$this->db->select('IdRecursoBien AS id, NombreRecurso, AliasRecurso',false);
				$this->db->from('cp_cat_recursos_bienes');
				$this->db->order_by('NombreRecurso');
				$query = $this->db->get();
				$res = $query->num_rows();
				$arr = array();
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						$arr[$value['id']] = $value['NombreRecurso']."(".$value['AliasRecurso'].")";
					}
				}
				return $arr;
				break;
			case 'funciones': 
				$moda = substr($this->session->userdata('claveCCT'), 2, 3);
				if($this->input->post('cct')){
					$moda = substr($this->input->post('cct'), 2, 3);
				}

				$this->db->select('id AS id, funcion',false);
				$this->db->from('cp_funciones');
				$this->db->where('moda',$moda);
				$this->db->where('id IN (1, 2, 13, 14, 45, 51)');
				$this->db->order_by('funcion');
				$query = $this->db->get();
				$res = $query->num_rows();
				$arr = array();
				$arr[0] = 'SELECCIONE';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						$arr[$value['id']] = $value['funcion'];
					}
				}
				return $arr;
				break;
		}
	}
	function selectHTML($catalogo,$opcion){
		switch($catalogo) {
			case 'perfil_usuarios': 
				$this->db->select('IdPerfilUsuario, NombrePerfil',false);
				$this->db->from('cp_cat_perfiles_usuarios');
				$this->db->order_by('IdPerfilUsuario');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['IdPerfilUsuario']."'>".$value['NombrePerfil']."</option>";}
					}
				}
				return $anexos;
		
				break;
			case 'motivoMovimiento': 
				$this->db->select('IdMotivoMovimiento,NombreMotivo',false);
				$this->db->from('cp_cat_motivos_movimientos');
				$this->db->order_by('NombreMotivo');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<select><option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['IdMotivoMovimiento']."'>".$value['NombreMotivo']."</option>";}
						else{$anexos .= "<option value='".$value['NombreMotivo']."'>".$value['NombreMotivo']."</option>";}
					}
				}
				echo $anexos.'</select>';
		
				break;
			case 'Region': 
				$this->db->select('cp_cat_region.idRegion,cp_cat_region.nombre',false);
				$this->db->from('cp_cat_region');
				$this->db->order_by('cp_cat_region.nombre');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<select><option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['idRegion']."'>".$value['nombre']."</option>";}
						else{$anexos .= "<option value='".$value['nombre']."'>".$value['nombre']."</option>";}
					}
				}
				echo $anexos.'</select>';
				break;
			case 'Municipio': 
				$this->db->select('catmun.MUNICIPIO,catmun.NOM',false);
				$this->db->from('catmun');
				$this->db->order_by('catmun.NOM');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<select><option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['MUNICIPIO']."'>".$value['NOM']."</option>";}
						else{$anexos .= "<option value='".$value['NOM']."'>".$value['NOM']."</option>";}
					}
				}
				echo $anexos.'</select>';
				break;
			case 'catEstatusEscuela': 
				$this->db->select('DescripcionEstado',false);
				$this->db->from('cp_cat_estatusct');
				$this->db->order_by('DescripcionEstado');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<select><option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['DescripcionEstado']."'>".$value['DescripcionEstado']."</option>";}
						else{$anexos .= "<option value='".$value['DescripcionEstado']."'>".$value['DescripcionEstado']."</option>";}
					}
				}
				echo $anexos.'</select>';
				break;
			case 'catTurnos': 
				$this->db->select('descripcion',false);
				$this->db->from('cp_cat_turno');
				$this->db->order_by('descripcion');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<select><option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['descripcion']."'>".$value['descripcion']."</option>";}
						else{$anexos .= "<option value='".$value['descripcion']."'>".$value['descripcion']."</option>";}
					}
				}
				echo $anexos.'</select>';
				break;
			case 'tipoBien': 
				$this->db->select('IdTipoBien AS id,NombreTipoBien AS nombre',false);
				$this->db->from('cp_cat_tipos_bienes');
				$this->db->order_by('NombreTipoBien');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<select><option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['id']."'>".$value['nombre']."</option>";}
						else{$anexos .= "<option value='".$value['nombre']."'>".$value['nombre']."</option>";}
					}
				}
				echo $anexos.'</select>';
				break;
			case 'articuloCIM': 
				$this->db->select('IdArticulo AS id,NombreArticulo AS nombre',false);
				$this->db->from('cim_articulo');
				$this->db->order_by('NombreArticulo');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<select><option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['id']."'>".$value['nombre']."</option>";}
						else{$anexos .= "<option value='".$value['nombre']."'>".$value['nombre']."</option>";}
					}
				}
				echo $anexos.'</select>';
				break;
			case 'estadosBienes': 
				$this->db->select('IdEstadoBien AS id,NombreEstadoBien AS nombre',false);
				$this->db->from('cp_cat_estados_bienes');
				$this->db->order_by('NombreEstadoBien');
				$this->db->group_by('NombreEstadoBien');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<select><option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['id']."'>".$value['nombre']."</option>";}
						else{$anexos .= "<option value='".$value['nombre']."'>".$value['nombre']."</option>";}
					}
				}
				echo $anexos.'</select>';
				break;
			case 'recursosBienes': 
				$this->db->select('IdRecursoBien AS id,NombreRecurso AS nombre',false);
				$this->db->from('cp_cat_recursos_bienes');
				$this->db->order_by('NombreRecurso');
				$this->db->not_like('NombreRecurso','BAJA_');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<select><option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['id']."'>".$value['nombre']."</option>";}
						else{$anexos .= "<option value='".$value['nombre']."'>".$value['nombre']."</option>";}
					}
				}
				echo $anexos.'</select>';
				break;
			case 'estatusBienes': 
				$this->db->select('IdEstatus AS id,NombreEstatus AS nombre',false);
				$this->db->from('cp_cat_estatus');
				$this->db->where('IdEstatus NOT IN(6,7,8,9,10,11)');
				$this->db->order_by('NombreEstatus');
				$query = $this->db->get();
				$res = $query->num_rows();
				$anexos = '<select><option value="0">Seleccione</option>';
				if ($res>0){
					foreach ($query->result_array() as $key => $value){
						if($opcion == 1){$anexos .= "<option value='".$value['id']."'>".$value['nombre']."</option>";}
						else{$anexos .= "<option value='".$value['nombre']."'>".$value['nombre']."</option>";}
					}
				}
				echo $anexos.'</select>';
				break;
		}
	}
	public function seleccionar_preguntas(){
		$this->db->select('Pregunta, Respuesta',false);
		$this->db->from('cp_faq');
		$this->db->where('Estatus',1);
		$this->db->order_by('Pregunta');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function guardarArchivo($datos){
		$n = explode('.',$datos[0]['ARCHIVO']['file_name']);
		$data_insertar['NombreArchivo'] = $n[0];
		$data_insertar['NombreArchivoDescargable'] = $this->input->post('nombre_Archivo');
		$data_insertar['Descripcion'] = $this->input->post('descripcion_Archivo');
		$data_insertar['Extension'] =  $datos[0]['ARCHIVO']['file_ext'];
		$this->db->insert("cp_archivos_descargables",$data_insertar);
	}
	public function guardarArchivoTutorial($datos){
		$n = explode('.',$datos[0]['ARCHIVO']['file_name']);
		$data_insertar['NombreArchivo'] = $n[0];
		$data_insertar['IdPerfilUsuario'] = $this->input->post('perfil_usuario');
		$data_insertar['NombreTutorial'] = $this->input->post('nombre_tutorial');
		$data_insertar['Extencion'] =  $datos[0]['ARCHIVO']['file_ext'];
		$this->db->insert("cp_tutoriales",$data_insertar);
	}
	public function obtenerArchivos(){
		$this->db->select("IdArchivo AS id,NombreArchivo AS nombre, NombreArchivoDescargable AS nom, Extension AS ext, Descripcion");
		$this->db->from('cp_archivos_descargables');
		$query = $this->db->get();
		$res = $query->num_rows();
		$anexos = "";
		if ($res>0){
			foreach ($query->result_array() as $key => $value){
				$f = "<b>Archivo:</b> ".$value['nom'];
				$value['id'] = $value['id'].rand(100000000,199999999);
				$del = "";
				if($this->session->userdata('perfilUsuario') == '3')
					$del = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="eliminar_anexo2(this);" rel="'.$value['id'].'" style="float:left" ><span class="glyphicon glyphicon-remove" aria-hidden="true" title="Eliminar"></span></button>';

				$title = "Ver";$title2 = "Descargar";
				
				if($value['ext'] == '.jpg' || $value['ext'] == '.png' || $value['ext'] == '.jpeg' || $value['ext'] == '.JPG' || $value['ext'] == '.PNG' || $value['ext'] == '.JPEG'){
					$anexos .= "<div class='col-xs-4 anexos_preview'>".$del."<a target='_blank' href='".INDEX_CP."archivosDescargables/".$value['nombre'].$value['ext']."'><img src='".INDEX_CP."archivosDescargables/".$value['nombre'].$value['ext']."' title='".$title."'/></a><div class='col-sm12'>".$f."<br> <b>Descripcion:</b> ".$value['Descripcion']."</div></div>";
				}
				if($value['ext'] == '.pdf' || $value['ext'] == '.PDF'){
					$anexos .= "<div class='col-xs-4 anexos_preview' >".$del."<a target='_blank' href='".INDEX_CP."archivosDescargables/".$value['nombre'].$value['ext']."'><img src='".INDEX_CP."resources/images/pdf_icono.png' title='".$title2."'/></a><div class='col-sm12'>".$f."<br> <b>Descripcion:</b> ".$value['Descripcion']."</div></div>";
				}
				if($value['ext'] == '.xml' || $value['ext'] == '.XML'){
					$anexos .= "<div class='col-xs-4 anexos_preview' >".$del."<a target='_blank' href='".INDEX_CP."archivosDescargables/".$value['nombre'].$value['ext']."'><img src='".INDEX_CP."resources/images/xml_icono.png' title='".$title2."'/></a><div class='col-sm12'>".$f."<br> <b>Descripcion:</b> ".$value['Descripcion']."</div></div>";
				}
				if($value['ext'] == '.doc' || $value['ext'] == '.docx'){
					$anexos .= "<div class='col-xs-4 anexos_preview' >".$del."<a target='_blank' href='".INDEX_CP."archivosDescargables/".$value['nombre'].$value['ext']."'><img src='".INDEX_CP."resources/images/word_ico.png' title='".$title2."'/></a><div class='col-sm12'>".$f."<br> <b>Descripcion:</b> ".$value['Descripcion']."</div></div>";
				}
				if($value['ext'] == '.xls' || $value['ext'] == '.xlsx'){
					$anexos .= "<div class='col-xs-4 anexos_preview' >".$del."<a target='_blank' href='".INDEX_CP."archivosDescargables/".$value['nombre'].$value['ext']."'><img src='".INDEX_CP."resources/images/xls_ico.png' title='".$title2."'/></a><div class='col-sm12'>".$f."<br> <b>Descripcion:</b> ".$value['Descripcion']."</div></div>";
				}
			}
		}
		else{$anexos .= "<b>Sin Archivos</b>";}
		$anexos .= "<div class='clearfix'></div>";
		return $anexos;
	}
	public function obtenerTutoriales(){
		$this->db->select("t.IdTutorial AS id,t.IdPerfilUsuario,t.NombreArchivo AS nombre,t.Extencion AS ext,t.FechaCreacion,pu.NombrePerfil, t.NombreTutorial");
		$this->db->from('cp_tutoriales AS t');
		$this->db->join('cp_cat_perfiles_usuarios AS pu', 't.IdPerfilUsuario = pu.IdPerfilUsuario');
		if($this->session->userdata('perfilUsuario') != '3'){
			$this->db->where('t.IdPerfilUsuario',$this->session->userdata('perfilUsuario'));
		}
		$this->db->order_by('t.IdPerfilUsuario');
		$query = $this->db->get();
		$res = $query->num_rows();
		$anexos = "";
		if ($res>0){
			foreach ($query->result_array() as $key => $value){
				$f = "<b>Perfil:</b> ".$value['NombrePerfil']."<br><b>Nombre Tutorial:</b> ".$value['NombreTutorial'];
				if($this->session->userdata('perfilUsuario') != '3'){
					$f = "<b>Nombre Tutorial:</b> ".$value['NombreTutorial'];
				}
				$value['id'] = $value['id'].rand(100000000,199999999);
				$del = "";
				if($this->session->userdata('perfilUsuario') == '3')
					$del = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="eliminar_tutorial(this);" rel="'.$value['id'].'" style="float:left" ><span class="glyphicon glyphicon-remove" aria-hidden="true" title="Eliminar"></span></button>';

				$title2 = "Descargar";
				
				if($value['ext'] == '.pdf' || $value['ext'] == '.PDF'){
					$anexos .= "<div class='col-xs-4 anexos_preview' >".$del."<a target='_blank' href='".INDEX_CP."archivosDescargables/".$value['nombre'].$value['ext']."'><img src='".INDEX_CP."resources/images/pdf_icono.png' title='".$title2."'/></a><div class='col-sm12'>".$f."</div></div>";
				}
				if($value['ext'] == '.doc' || $value['ext'] == '.docx'){
					$anexos .= "<div class='col-xs-4 anexos_preview' >".$del."<a target='_blank' href='".INDEX_CP."archivosDescargables/".$value['nombre'].$value['ext']."'><img src='".INDEX_CP."resources/images/word_ico.png' title='".$title2."'/></a><div class='col-sm12'>".$f."</div></div>";
				}
			}
		}
		else{$anexos .= "<b>Sin Tutoriales</b>";}
		$anexos .= "<div class='clearfix'></div>";
		return $anexos;
	}
	public function eliminar_Archivo(){
		$this->load->helper('file');
		$query = $this->db->query("SELECT IdArchivo,NombreArchivo,NombreArchivoDescargable,Extension FROM cp_archivos_descargables WHERE IdArchivo = ".substr($this->input->post('id'), 0, -9));
		$campo = $query->row(); 
		if(unlink("archivosDescargables/".$campo->NombreArchivo.$campo->Extension)){			
			$this->db->where('IdArchivo',  substr($this->input->post('id'), 0, -9));
			echo $this->db->delete('cp_archivos_descargables');
		}
		else{echo "erroraleliminar";}
	}

	public function eliminar_Tutorial(){
		$this->load->helper('file');
		$query = $this->db->query("SELECT IdTutorial,NombreArchivo,Extencion FROM cp_tutoriales WHERE IdTutorial = ".substr($this->input->post('id'), 0, -9));
		$campo = $query->row(); 
		if(unlink("archivosDescargables/".$campo->NombreArchivo.$campo->Extencion)){			
			$this->db->where('IdTutorial',  substr($this->input->post('id'), 0, -9));
			echo $this->db->delete('cp_tutoriales');
		}
		else{echo "erroraleliminar";}
	}

	public function rel_UsuariosModa(){
		$id = $this->session->userdata("usuarioId");
		$query = $this->db->query("SELECT Moda FROM cp_rel_usuariosmodalidades WHERE IdUsuario = ".$id);
		$res = $query->num_rows();
		$modas = array();
		if ($res>0){
			foreach ($query->result_array() as $key => $value){
				array_push($modas, $value['Moda']);
			}
		}
		$modas2 = implode("','",$modas);
		return $modas2;
		//break; COMENTÉ ESTO NO SE TE OLVIDE QUITARLO
	}
	public function obtenerAnexosBien($bienes){
		$this->db->select('a.NoFacturaAnexo,a.IdAnexo,a.UbicacionAnexo,a.NombreAnexo,a.ExtensionAnexo,a.IdUsuario');
		$this->db->from('cp_anexos AS a');
		$this->db->join('cp_rel_bienes_anexos as ra','ra.IdAnexo = a.IdAnexo');
		$this->db->where('ra.IdBien IN('.$bienes.')');
		$this->db->where('RegBorrado', '0');
		$this->db->group_by('a.IdAnexo');

         $queryAnexos = $this->db->get();
        if ($queryAnexos->num_rows() >= 1){
			return $queryAnexos->result_array();
		}
		else{
			return array();
		}

	}
	public function obtenerAnexosBien2($bienes){
		$this->load->library('encrypt');
		$bienes = str_replace(array('-', '_', '~'),array('+', '/', '='), $bienes); 
	    $bienes = $this->encrypt->decode($bienes); 	

		$this->db->select('a.NoFacturaAnexo,a.IdAnexo,a.UbicacionAnexo,a.NombreAnexo,a.ExtensionAnexo,a.IdUsuario');
		$this->db->from('cp_anexos AS a');
		$this->db->join('cp_rel_bienes_anexos as ra','ra.IdAnexo = a.IdAnexo');
		$this->db->where('ra.IdBien IN('.$bienes.')');
		$this->db->where('RegBorrado', '0');
		$this->db->group_by('a.IdAnexo');

         $queryAnexos = $this->db->get();
        if ($queryAnexos->num_rows() >= 1){
			return $queryAnexos->result_array();
		}
		else{
			return array();
		}

	}
	// ********************************************** NEW FUNCTION ******************************************************************//
	
	function search_serie($serie){
		/********************FUNCTIONAL CODE*********************
		$this->db->like('SerieBien', $serie);
		$query = $this->db->get('cp_bienes');
		return $query->result();
		***************************************** */
	
		//$this->db->like('cp_bienes.SerieBien',$serie);
		$this->db->select('cp_bienes.SerieBien, cp_bienes.MarcaBien,cp_bienes.ModeloBien,cp_bienes.DescripcionBien,a_ctba.NOMBRECT, cp_bienes.IdBien, cp_rel_bienes_ccts_responsables.CLAVECCT' );
		$this->db->from('cp_bienes');
		$this->db->join('cp_rel_bienes_ccts_responsables', 'cp_bienes.IdBien = cp_rel_bienes_ccts_responsables.IdBien', 'left');
		$this->db->join('a_ctba', 'cp_rel_bienes_ccts_responsables.CLAVECCT = a_ctba.CLAVECCT', 'left');
		$this->db->like('SerieBien', $serie , 'both');
		$query = $this->db->get();
		return $query->result();
		
		
		
		
		

	}
}


/*
*end modules/bitacoras/models/modelo_catalogos.php
*/