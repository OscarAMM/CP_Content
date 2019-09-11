<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class catalogos extends MX_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('modelo_catalogos');
		$this->load->library(array('session','pagination','encrypt'));
		$this->load->helper(array('array','url','form'));
		$this->perPage = 10;
		$this->load->database();
	/*	$this->load->helper('array');
        $this->load->helper('url');
        $this->load->helper('form');
		$this->load->library('encrypt');
		$this->load->library('pagination');*/
	}
	
	public function index(){
		$tituloMigas = 'Gestión catálogos';
		$datos = Modules::run("inicio/inicio/funcionesBasicas",$tituloMigas);
		$data['token'] = $this->security->get_csrf_hash(); //CODEIGNITER function
		$this->load->model('modelo_inicio');
		$data['ANEXOS'] = $this->modelo_catalogos->obtenerArchivos();
		$data['perfil_usuarios'] = $this->modelo_catalogos->selectHTML('perfil_usuarios',1);
		$data['TUTORIALES'] = $this->modelo_catalogos->obtenerTutoriales();   
		$this->load->view('header',$datos);
		$this->load->view('vista_catalogos',$data);
		$this->load->view('footer');
		$this->load->view('vista_gestion_bienes');
	}
	public function tutorialesVista(){
		$tituloMigas = 'Tutoriales';
		$datos = Modules::run("inicio/inicio/funcionesBasicas",$tituloMigas);
		$data['token'] = $this->security->get_csrf_hash();
		$this->load->model('modelo_inicio');
		$data['TUTORIALES'] = $this->modelo_catalogos->obtenerTutoriales();   
		$this->load->view('header',$datos);
		$this->load->view('vista_tutoriales',$data);
		$this->load->view('footer');
	}
	public function listado(){
		$oper = $this->input->post('oper');
		$catalogo = $this->input->post('catalogo');
		$json = new stdClass;
		switch($catalogo) {
			case 'caracteristicas': 
				switch($oper){
					case 'add': 
						$data_insertar['NombreCaracteristica'] =  element('NombreCaracteristica',$_POST);$data_insertar['mostrarCaracteristica'] =  '1';
						$this->db->insert("cp_cat_caracteristicas",$data_insertar);
						break;
					case 'edit':
						$NombreCaracteristica = element('NombreCaracteristica',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdCaracteristica",$id,false);
						$this->db->update("cp_cat_caracteristicas",array('NombreCaracteristica' => $NombreCaracteristica));
						break;
					case 'del':
						$estado = element('estado',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdCaracteristica",$id);
						$this->db->update("cp_cat_caracteristicas",array('mostrarCaracteristica' => intval($estado)),false);
						break;
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"c.NombreCaracteristica",
						'select' => "c.IdCaracteristica AS id,c.NombreCaracteristica,c.mostrarCaracteristica", 'tabla'=>"cp_cat_caracteristicas AS c");
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('NombreCaracteristica'),$this->input->post());}            
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['NombreCaracteristica'] = element('NombreCaracteristica', $valor);
								$temporalregistros[$key]['mostrarCaracteristica'] = element('mostrarCaracteristica', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'estadosBienes': 
				switch($oper){
					case 'add': 
						$data_insertar['NombreEstadoBien']=element('NombreEstadoBien',$_POST);$data_insertar['IdTIpoMovimiento']=intval(element('NombreTipoMovimiento',$_POST));$data_insertar['mostrarCaracteristica'] =  '1';
						$this->db->insert("cp_cat_estados_bienes",$data_insertar);
						break;
					case 'edit':
						$NombreEstadoBien = element('NombreEstadoBien',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdEstadoBien",$id,false);
						$this->db->update("cp_cat_estados_bienes",array('NombreEstadoBien' => $NombreEstadoBien));
						break;
					case 'del':
						$estado = element('estado',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdEstadoBien",$id);
						$this->db->update("cp_cat_estados_bienes",array('mostrarCaracteristica' => intval($estado)),false);
						break;
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"m.NombreTipoMovimiento,e.NombreEstadoBien",
						'select' => "e.IdEstadoBien AS id,m.NombreTipoMovimiento,e.NombreEstadoBien,e.mostrarCaracteristica", 'tabla'=>"cp_cat_estados_bienes AS e",'join'=>array("cp_cat_tipos_movimientos AS m"=> "e.IdTIpoMovimiento = m.IdTipoMovimiento"));
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('NombreTipoMovimiento','NombreEstadoBien'),$this->input->post());}            
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['NombreTipoMovimiento'] = element('NombreTipoMovimiento', $valor);
								$temporalregistros[$key]['NombreEstadoBien'] = element('NombreEstadoBien', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'estatus': 
				switch($oper){
					case 'edit':
						$NombreEstatus = element('NombreEstatus',$_POST);$PrioridadEstatus = element('PrioridadEstatus',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdEstatus",$id,false);
						$this->db->update("cp_cat_estatus",array('NombreEstatus' => $NombreEstatus,'PrioridadEstatus' => $PrioridadEstatus));
						break;
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"e.PrioridadEstatus,e.NombreEstatus",
						'select' => "e.IdEstatus AS id,e.NombreEstatus,e.PrioridadEstatus", 'tabla'=>"cp_cat_estatus AS e");
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('NombreEstatus','PrioridadEstatus'),$this->input->post());}            
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['NombreEstatus'] = element('NombreEstatus', $valor);
								$temporalregistros[$key]['PrioridadEstatus'] = element('PrioridadEstatus', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'motivosMovimientos': 
				switch($oper){
					case 'add': 
						$data_insertar['NombreMotivo'] =  strtoupper(element('NombreMotivo',$_POST));$data_insertar['CodigoMotivo'] =  strtoupper(element('CodigoMotivo',$_POST));$data_insertar['IdTIpoMovimiento'] =  intval(element('NombreTipoMovimiento',$_POST));$data_insertar['MostrarMotivoMovimiento'] =  '1';
						$this->db->insert("cp_cat_motivos_movimientos",$data_insertar);
						break;
					case 'edit':
						$NombreMotivo =  strtoupper(element('NombreMotivo',$_POST));$CodigoMotivo =  strtoupper(element('CodigoMotivo',$_POST));$IdTIpoMovimiento =  intval(element('NombreTipoMovimiento',$_POST));
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdMotivoMovimiento",$id,false);
						$this->db->update("cp_cat_motivos_movimientos",array('NombreMotivo' => $NombreMotivo,'CodigoMotivo' => $CodigoMotivo,'IdTIpoMovimiento' => $IdTIpoMovimiento));
						break;
					case 'del':
						$estado = element('estado',$_POST);$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdMotivoMovimiento",$id);
						$this->db->update("cp_cat_motivos_movimientos",array('MostrarMotivoMovimiento' => intval($estado)),false);
						break;
					case 'permitir':
						$perfil = element('perfil',$_POST);
						$id = element('id',$_POST);
						$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); 
        				$id = $this->encrypt->decode($id);
						$estado = element('estado',$_POST);
						if($estado == 1){$data_insertar['IdPerfilUsuario'] =  intval($perfil);$data_insertar['IdMotivoMovimiento'] =  intval($id);$this->db->insert("cp_rel_perfiles_motivos_movimientos",$data_insertar);}
						if($estado == 0){$this->db->delete('cp_rel_perfiles_motivos_movimientos', array('IdPerfilUsuario' => intval($perfil),'IdMotivoMovimiento' => intval($id))); }

						if($perfil == 1){if($estado == 1){echo "activar dir";}if($estado == 0){echo "desactivar dir";}}
						if($perfil == 2){if($estado == 1){echo "activar cede";}if($estado == 0){echo "desactivar cede";}}
						if($perfil == 3){if($estado == 1){echo "activar su";}if($estado == 0){echo "desactivar su";}}
						if($perfil == 4){if($estado == 1){echo "activar supervisor";}if($estado == 0){echo "desactivar supervisor";}}
						if($perfil == 5){if($estado == 1){echo "activar nivel";}if($estado == 0){echo "desactivar nivel";}}
						break;
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'group_by'=>array("e.IdMotivoMovimiento"),'orden'=>"m.NombreTipoMovimiento,e.NombreMotivo,e.CodigoMotivo",
						'select' => "e.IdMotivoMovimiento AS id,m.NombreTipoMovimiento,e.NombreMotivo,e.CodigoMotivo,e.MostrarMotivoMovimiento AS mostrarCaracteristica,SUM(IF (pm.IdPerfilUsuario = 1, 1, 0)) AS director,SUM(IF (pm.IdPerfilUsuario = 4, 1, 0)) AS supervisor,SUM(IF (pm.IdPerfilUsuario = 5, 1, 0)) AS nivel,SUM(IF (pm.IdPerfilUsuario = 2, 1, 0)) AS cede,SUM(IF (pm.IdPerfilUsuario = 3, 1, 0)) AS su", 'tabla'=>"cp_cat_motivos_movimientos AS e",'join'=>array("cp_cat_tipos_movimientos AS m"=> "e.IdTipoMovimiento = m.IdTipoMovimiento", "cp_rel_perfiles_motivos_movimientos AS pm" => "pm.IdMotivoMovimiento = e.IdMotivoMovimiento"));
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('NombreTipoMovimiento','NombreMotivo','CodigoMotivo'),$this->input->post());}
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['NombreTipoMovimiento'] = element('NombreTipoMovimiento', $valor);
								$temporalregistros[$key]['NombreMotivo'] = element('NombreMotivo', $valor);
								$temporalregistros[$key]['CodigoMotivo'] = element('CodigoMotivo', $valor);
								$temporalregistros[$key]['mostrarCaracteristica'] = element('mostrarCaracteristica', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'recursosBienes': 
				switch($oper){
					case 'add': 
						$data_insertar['IdMotivoMovimiento'] =  strtoupper(element('IdTipoMovimiento',$_POST));$data_insertar['NombreRecurso'] =  strtoupper(element('NombreRecurso',$_POST));$data_insertar['AliasRecurso'] =  element('AliasRecurso',$_POST);$data_insertar['MostrarRecursoBien'] =  '1';
						$this->db->insert("cp_cat_recursos_bienes",$data_insertar);
						break;
					case 'edit':
						$IdMotivoMovimiento =  strtoupper(element('IdTipoMovimiento',$_POST));$NombreRecurso =  strtoupper(element('NombreRecurso',$_POST));$AliasRecurso =  element('AliasRecurso',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdRecursoBien",$id,false);
						$this->db->update("cp_cat_recursos_bienes",array('IdMotivoMovimiento' => $IdMotivoMovimiento,'NombreRecurso' => $NombreRecurso,'AliasRecurso' => $AliasRecurso));
						break;
					case 'del':
						$estado = element('estado',$_POST);$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdRecursoBien",$id);
						$this->db->update("cp_cat_recursos_bienes",array('MostrarRecursoBien' => intval($estado)),false);
						break;
					case 'permitir':
						$perfil = element('perfil',$_POST);
						$id = element('id',$_POST);
						$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); 
        				$id = $this->encrypt->decode($id);
						$estado = element('estado',$_POST);
						if($estado == 1){$data_insertar['IdPerfilUsuarios'] =  intval($perfil);$data_insertar['IdRecursoBien'] =  intval($id);$this->db->insert("cp_rel_recursobien_perfil",$data_insertar);}
						if($estado == 0){$this->db->delete('cp_rel_recursobien_perfil', array('IdPerfilUsuarios' => intval($perfil),'IdRecursoBien' => intval($id))); }

						if($perfil == 1){if($estado == 1){echo "activar dir";}if($estado == 0){echo "desactivar dir";}}
						if($perfil == 2){if($estado == 1){echo "activar cede";}if($estado == 0){echo "desactivar cede";}}
						if($perfil == 3){if($estado == 1){echo "activar su";}if($estado == 0){echo "desactivar su";}}
						if($perfil == 4){if($estado == 1){echo "activar supervisor";}if($estado == 0){echo "desactivar supervisor";}}
						if($perfil == 5){if($estado == 1){echo "activar nivel";}if($estado == 0){echo "desactivar nivel";}}
						break;
						
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"m.NombreMotivo, NombreRecurso",
						'select' => "r.IdRecursoBien AS id,IdTipoMovimiento,IFNULL(CONCAT(m.NombreMotivo,' (',m.CodigoMotivo,')'),'') AS NombreMotivo,r.NombreRecurso,r.AliasRecurso,r.MostrarRecursoBien AS mostrarCaracteristica,SUM(IF(rbp.IdPerfilUsuarios = 1, 1, 0)) AS director,SUM(IF(rbp.IdPerfilUsuarios = 4, 1, 0)) AS supervisor,SUM(IF(rbp.IdPerfilUsuarios = 5, 1, 0)) AS nivel,SUM(IF(rbp.IdPerfilUsuarios = 2, 1, 0)) AS cede,SUM(IF(rbp.IdPerfilUsuarios = 3, 1, 0)) AS su", 'tabla'=>"cp_cat_recursos_bienes AS r",'left_join'=>array("cp_cat_motivos_movimientos AS m"=> "r.IdMotivoMovimiento = m.IdMotivoMovimiento","cp_rel_recursobien_perfil AS rbp" => "r.IdRecursoBien = rbp.IdRecursoBien"),'group_by'=>array("r.IdRecursoBien"));
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('NombreMotivo','NombreRecurso'),$this->input->post());}            
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['motivoMovimiento'] = (element('motivoMovimiento', $valor) != '') ? element('motivoMovimiento', $valor) : "";
								$temporalregistros[$key]['IdTipoMovimiento'] = element('IdTipoMovimiento', $valor);
								$temporalregistros[$key]['NombreRecurso'] = element('NombreRecurso', $valor);
								$temporalregistros[$key]['AliasRecurso'] = (element('AliasRecurso', $valor) != '') ? element('AliasRecurso', $valor) : "";
								$temporalregistros[$key]['mostrarCaracteristica'] = element('mostrarCaracteristica', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'regionMunicipios': 
				switch($oper){
					case 'add': 
						$data_insertar['idRegion'] =  strtoupper(element('idr',$_POST));$data_insertar['municipio'] =  strtoupper(element('idm',$_POST));
						$this->db->insert("cp_cat_regionmunicipios",$data_insertar);
						break;
					case 'del':
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->delete('cp_cat_regionmunicipios', array('id' => $id)); 
						break;
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"r.nombre, m.NOM",
						'select' => "cr.id,cr.municipio AS idm,cr.idRegion AS idr,r.nombre,m.NOM", 'tabla'=>"cp_cat_regionmunicipios AS cr",'join'=>array("cp_cat_region AS r"=> "cr.idRegion = r.idRegion", "catmun AS m" => "cr.municipio = m.MUNICIPIO"));
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('nombre','NOM'),$this->input->post());}            
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['idm'] = element('idm', $valor);
								$temporalregistros[$key]['idr'] = element('idr', $valor);
								$temporalregistros[$key]['nombre'] = element('nombre', $valor);
								$temporalregistros[$key]['NOM'] = element('NOM', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'Secciones': 
				switch($oper){
					case 'add': 
						$data_insertar['NombreSeccion'] =  strtoupper(element('NombreSeccion',$_POST));$data_insertar['MenuTituloSeccion'] =  element('MenuTituloSeccion',$_POST);$data_insertar['UrlSeccion'] =  element('UrlSeccion',$_POST);$data_insertar['MenuCssSeccion'] =  element('MenuCssSeccion',$_POST);$data_insertar['DescripcionSeccion'] =  element('DescripcionSeccion',$_POST);$data_insertar['EstatusSeccion'] =  intval('1');
						$this->db->insert("cp_cat_secciones",$data_insertar);
						break;
					case 'edit':
						$NombreSeccion =  strtoupper(element('NombreSeccion',$_POST));$MenuTituloSeccion =  element('MenuTituloSeccion',$_POST);$UrlSeccion =  element('UrlSeccion',$_POST);$MenuCssSeccion =  element('MenuCssSeccion',$_POST);$DescripcionSeccion =  element('DescripcionSeccion',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdSeccion",$id,false);
						$this->db->update("cp_cat_secciones",array('NombreSeccion' => $NombreSeccion,'MenuTituloSeccion' => $MenuTituloSeccion,'UrlSeccion' => $UrlSeccion,'MenuCssSeccion' => $MenuCssSeccion,'DescripcionSeccion' => $DescripcionSeccion));
						break;
					case 'del':
						$estado = element('estado',$_POST);$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdSeccion",$id);
						$this->db->update("cp_cat_secciones",array('EstatusSeccion' => intval($estado)),false);
						break;
					case 'permitir':
						$perfil = element('perfil',$_POST);
						$id = element('id',$_POST);
						$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); 
        				$id = $this->encrypt->decode($id);
						$estado = element('estado',$_POST);
						if($estado == 1){$data_insertar['IdPerfilUsuario'] =  intval($perfil);$data_insertar['IdSeccion'] =  intval($id);$this->db->insert("cp_rel_perfiles_secciones",$data_insertar);}
						if($estado == 0){$this->db->delete('cp_rel_perfiles_secciones', array('IdPerfilUsuario' => intval($perfil),'IdSeccion' => intval($id))); }
						if($perfil == 1){if($estado == 1){echo "activar dir";}if($estado == 0){echo "desactivar dir";}}
						if($perfil == 2){if($estado == 1){echo "activar cede";}if($estado == 0){echo "desactivar cede";}}
						if($perfil == 3){if($estado == 1){echo "activar su";}if($estado == 0){echo "desactivar su";}}
						break;
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"director DESC, cede DESC, su DESC",
						'select' => "s.IdSeccion AS id,s.NombreSeccion,s.MenuTituloSeccion,s.UrlSeccion,s.MenuCssSeccion,s.DescripcionSeccion,s.EstatusSeccion,SUM(IF(rs.IdPerfilUsuario = 1, 1, 0)) AS director,SUM(IF(rs.IdPerfilUsuario = 2, 1, 0)) AS cede,SUM(IF(rs.IdPerfilUsuario = 3, 1, 0)) AS su,SUM(IF(rs.IdPerfilUsuario = 4, 1, 0)) AS supervisor,SUM(IF(rs.IdPerfilUsuario = 5, 1, 0)) AS nivel", 'tabla'=>"cp_cat_secciones AS s",'left_join'=>array("cp_rel_perfiles_secciones AS rs"=> "rs.IdSeccion = s.IdSeccion"),'group_by'=>array("s.IdSeccion"));
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('NombreSeccion','MenuTituloSeccion','UrlSeccion','MenuCssSeccion','DescripcionSeccion'),$this->input->post());}            
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['NombreSeccion'] = element('NombreSeccion', $valor);
								$temporalregistros[$key]['MenuTituloSeccion'] = element('MenuTituloSeccion', $valor);
								$temporalregistros[$key]['UrlSeccion'] = element('UrlSeccion', $valor);
								$temporalregistros[$key]['MenuCssSeccion'] = element('MenuCssSeccion', $valor);
								$temporalregistros[$key]['DescripcionSeccion'] = element('DescripcionSeccion', $valor);
								$temporalregistros[$key]['EstatusSeccion'] = element('EstatusSeccion', $valor);
								$temporalregistros[$key]['director'] = element('director', $valor);
								$temporalregistros[$key]['cede'] = element('cede', $valor);
								$temporalregistros[$key]['su'] = element('su', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'TipoBienes': 
				switch($oper){
					case 'add': 
						$data_insertar['NombreTipoBien'] =  strtoupper(element('NombreTipoBien',$_POST));$data_insertar['DescripcionTipoBien'] =  element('DescripcionTipoBien',$_POST);$data_insertar['AbreviacionBien'] =  strtoupper(element('AbreviacionBien',$_POST));$data_insertar['mostrarTipoBien'] =  intval('1');
						$this->db->insert("cp_cat_tipos_bienes",$data_insertar);
						break;
					case 'edit':
						$NombreTipoBien =  strtoupper(element('NombreTipoBien',$_POST));$DescripcionTipoBien =  element('DescripcionTipoBien',$_POST);$AbreviacionBien =  element('AbreviacionBien',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdTipoBien",$id,false);
						$this->db->update("cp_cat_tipos_bienes",array('NombreTipoBien' => $NombreTipoBien,'DescripcionTipoBien' => $DescripcionTipoBien,'AbreviacionBien' => $AbreviacionBien));
						break;
					case 'del':
						$estado = element('estado',$_POST);$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdTipoBien",$id);
						$this->db->update("cp_cat_tipos_bienes",array('mostrarTipoBien' => intval($estado)),false);
						break;
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"NombreTipoBien",
						'select' => "IdTipoBien AS id, NombreTipoBien,DescripcionTipoBien,AbreviacionBien,mostrarTipoBien", 'tabla'=>"cp_cat_tipos_bienes");
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('NombreTipoBien','DescripcionTipoBien'),$this->input->post());}            
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['NombreSeccion'] = element('NombreSeccion', $valor);
								$temporalregistros[$key]['MenuTituloSeccion'] = element('MenuTituloSeccion', $valor);
								$temporalregistros[$key]['UrlSeccion'] = element('UrlSeccion', $valor);
								$temporalregistros[$key]['MenuCssSeccion'] = element('MenuCssSeccion', $valor);
								$temporalregistros[$key]['DescripcionSeccion'] = element('DescripcionSeccion', $valor);
								$temporalregistros[$key]['EstatusSeccion'] = element('EstatusSeccion', $valor);
								$temporalregistros[$key]['director'] = element('director', $valor);
								$temporalregistros[$key]['cede'] = element('cede', $valor);
								$temporalregistros[$key]['su'] = element('su', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'Permisos': 
				switch($oper){
					case 'edit':
						$NombrePermiso =  element('NombrePermiso',$_POST);$id = element('id2',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdPermiso",$id,false);
						$this->db->update("cp_cat_permisos",array('NombrePermiso' => $NombrePermiso));
						break;
					case 'del':
						$estado = element('estado',$_POST);$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdPerfilPermiso",$id);
						$this->db->update("cp_rel_perfiles_permisos",array('Activado' => intval($estado)),false);
						break;
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"director DESC,cede DESC, su DESC, cp.NombrePermiso ASC",
						'select' => "p.IdPerfilPermiso AS id,cp.IdPermiso AS id2,cp.NombrePermiso,p.Activado,Sum(IF(p.IdPerfilUsuario = 1, 1, 0)) AS director,Sum(IF(p.IdPerfilUsuario = 2, 1, 0)) AS cede,Sum(IF(p.IdPerfilUsuario = 3, 1, 0)) AS su,Sum(IF(p.IdPerfilUsuario = 4, 1, 0)) AS supervisor,Sum(IF(p.IdPerfilUsuario = 5, 1, 0)) AS nivel", 'tabla'=>"cp_cat_permisos AS cp",'left_join'=>array("cp_rel_perfiles_permisos AS p"=> "p.IdPermiso = cp.IdPermiso", "cp_cat_perfiles_usuarios AS cpu" => "p.IdPerfilUsuario = cpu.IdPerfilUsuario"),'group_by'=>array("cp.IdPermiso"));
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('NombrePermiso'),$this->input->post());}            
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['NombrePermiso'] = element('NombrePermiso', $valor);
								$id = $this->encrypt->encode(element('id2', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id2'] = $id;
								$temporalregistros[$key]['Activado'] = element('Activado', $valor);
								$temporalregistros[$key]['director'] = element('director', $valor);
								$temporalregistros[$key]['cede'] = element('cede', $valor);
								$temporalregistros[$key]['su'] = element('su', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'Proveedor': 
				switch($oper){
					case 'add': 
						$data_insertar['IdUsuario'] =  intval("1");$data_insertar['RfcProveedor'] =  strtoupper(element('RfcProveedor',$_POST));$data_insertar['NombreProveedor'] =  strtoupper(element('NombreProveedor',$_POST));$data_insertar['DireccionProveedor'] =  strtoupper(element('DireccionProveedor',$_POST));$data_insertar['TelefonoProveedor'] =  strtoupper(element('TelefonoProveedor',$_POST));
						$this->db->insert("cp_proveedores",$data_insertar);
						break;
					case 'edit':
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdProveedor",$id,false);
						$this->db->update("cp_proveedores",array('RfcProveedor' => element('RfcProveedor',$_POST),'NombreProveedor' => element('NombreProveedor',$_POST),'DireccionProveedor' => element('DireccionProveedor',$_POST),'TelefonoProveedor' => element('TelefonoProveedor',$_POST)));
						break;
					default:
						$post = array('limit'=>'0','page'=>$this->input->post('page'),'orden'=>"p.RfcProveedor,p.NombreProveedor",'select' => "p.IdProveedor AS id, p.IdUsuario, p.RfcProveedor, p.NombreProveedor, p.DireccionProveedor, p.TelefonoProveedor", 'tabla'=>"cp_proveedores AS p");
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('RfcProveedor','NombreProveedor'),$this->input->post());}            
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar("",$post);
						$count = count($temporalregistros);
						//echo $count;
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"p.RfcProveedor,p.NombreProveedor",'select' => "p.IdProveedor AS id, p.IdUsuario, p.RfcProveedor, p.NombreProveedor, p.DireccionProveedor, p.TelefonoProveedor", 'tabla'=>"cp_proveedores AS p");
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$json->records = $count;
						$temporalregistros = array();
						
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['RfcProveedor'] = element('RfcProveedor', $valor);
								$temporalregistros[$key]['NombreProveedor'] = element('NombreProveedor', $valor);
								$temporalregistros[$key]['DireccionProveedor'] = (element('DireccionProveedor', $valor)) ? element('DireccionProveedor', $valor) : "";
								$temporalregistros[$key]['TelefonoProveedor'] = (element('TelefonoProveedor', $valor)) ? element('TelefonoProveedor', $valor) : "";
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'tablaListaCT': 
				switch($oper){
					default:
						$modalidades = "";
						if($this->session->userdata('perfilUsuario') == '5'){
							$modalidades = $this->modelo_catalogos->rel_UsuariosModa();
						}
						if($this->session->userdata('perfilUsuario') == '4'){
							$post = array('limit'=>'0','page'=>$this->input->post('page'),'orden'=>"r.nombre, u.CLAVECCT, u.Turno",'select' => "r.idRegion,GROUP_CONCAT(DISTINCT r.nombre SEPARATOR ', ') AS region,SUBSTR(a.CLAVECCT,3,3) AS moda,a.CLAVECCT AS ct,a.NOMBRECT AS nombre,t.turno AS turnoID,t.descripcion AS turno,m.NOM AS municipio,ec.DescripcionEstado AS estatus , u.ValidacionFinalizada AS verificacion", 'tabla'=>"cp_usuarios AS u",'join' => array("a_ctba AS a"=> "a.CLAVECCT = u.CLAVECCT", "cp_cat_estatusct AS ec" => "a.STATUS = ec.idEstadusCT", "cp_cat_turno AS t" => "t.turno= u.Turno", "cp_cat_regionmunicipios AS rm" => "a.MUNICIPIO = rm.municipio", "cp_cat_region AS r" => "rm.idRegion = r.idRegion", "catmun AS m" => "a.MUNICIPIO = m.MUNICIPIO"),'group_by'=>array("u.CLAVECCT"," u.Turno"),'where'=>("SUBSTR(a.CLAVECCT,3,3) IN ('DCC','DPB','EJN','DJN','EPR','DPR','EML','DML','FUA','DIN','EDI','DDI','BBE','BBI','BBS','DAR','DBA','DCT','DNP','DPT','DTA','DUP','EBA','EBH','EBT','ECB',	'ELS','ENE','ENP','ENS','EUT','FCJ','FEI','FGE','FHA','FLS','FMB','FRB','FSP','FTM','HDH','HMC','IID','KJN','KPR','KTV','TAI','FZP','FZT','FIZ','FSE','FSP','FZI','DST','DSN','ETV','SES','DES','EES','ESN','EST','FIS','FTV','FST','FJI','FJZ','FJS') AND a.CCT_ZONA = '".$this->session->userdata('claveCCT')."'"));
						}
						else if($this->session->userdata('perfilUsuario') == '5'){
							$post = array('limit'=>'0','page'=>$this->input->post('page'),'orden'=>"r.nombre, u.CLAVECCT, u.Turno",'select' => "r.idRegion,GROUP_CONCAT(DISTINCT r.nombre SEPARATOR ', ') AS region,SUBSTR(a.CLAVECCT,3,3) AS moda,a.CLAVECCT AS ct,a.NOMBRECT AS nombre,t.turno AS turnoID,t.descripcion AS turno,m.NOM AS municipio,ec.DescripcionEstado AS estatus , u.ValidacionFinalizada AS verificacion", 'tabla'=>"cp_usuarios AS u",'join' => array("a_ctba AS a"=> "a.CLAVECCT = u.CLAVECCT", "cp_cat_estatusct AS ec" => "a.STATUS = ec.idEstadusCT", "cp_cat_turno AS t" => "t.turno= u.Turno", "cp_cat_regionmunicipios AS rm" => "a.MUNICIPIO = rm.municipio", "cp_cat_region AS r" => "rm.idRegion = r.idRegion", "catmun AS m" => "a.MUNICIPIO = m.MUNICIPIO"),'group_by'=>array("u.CLAVECCT"," u.Turno"),'where'=>("SUBSTR(a.CLAVECCT,3,3) IN ('".$modalidades."') "));

						}
						else{
							$post = array('limit'=>'0','page'=>$this->input->post('page'),'orden'=>"r.nombre, u.CLAVECCT, u.Turno",'select' => "r.idRegion,GROUP_CONCAT(DISTINCT r.nombre SEPARATOR ', ') AS region,SUBSTR(a.CLAVECCT,3,3) AS moda,a.CLAVECCT AS ct,a.NOMBRECT AS nombre,t.turno AS turnoID,t.descripcion AS turno,m.NOM AS municipio,ec.DescripcionEstado AS estatus , u.ValidacionFinalizada AS verificacion", 'tabla'=>"cp_usuarios AS u",'join' => array("a_ctba AS a"=> "a.CLAVECCT = u.CLAVECCT", "cp_cat_estatusct AS ec" => "a.STATUS = ec.idEstadusCT", "cp_cat_turno AS t" => "t.turno= u.Turno", "cp_cat_regionmunicipios AS rm" => "a.MUNICIPIO = rm.municipio", "cp_cat_region AS r" => "rm.idRegion = r.idRegion", "catmun AS m" => "a.MUNICIPIO = m.MUNICIPIO"),'group_by'=>array("u.CLAVECCT"," u.Turno"),'where'=>("SUBSTR(a.CLAVECCT,3,3) IN ('DCC','DPB','EJN','DJN','EPR','DPR','EML','DML','FUA','DIN','EDI','DDI','BBE','BBI','BBS','DAR','DBA','DCT','DNP','DPT','DTA','DUP','EBA','EBH','EBT','ECB','FZT','ELS','ENE','ENP','ENS','EUT','FCJ','FEI','FGE','FHA','FLS','FMB','FRB','FSP','FTM','HDH','HMC','IID','KJN','KPR','KTV','TAI','FZP','FIZ','FSE','FSP','FZI','DST','DSN','ETV','SES','DES','EES','ESN','EST','FIS','FTV','FST','FJI','FJZ','FJS','ETK')"));

						}
						$validacion = $this->input->post('_search');
						
						if($validacion){$search['like']=array('r.nombre'=>$this->input->post('nombre'),'a.CLAVECCT'=>$this->input->post('CLAVECCT'),'a.NOMBRECT'=>$this->input->post('NOMBRECT'),'m.NOM'=>$this->input->post('NOM'),'ec.DescripcionEstado'=>$this->input->post('DescripcionEstado'),'t.descripcion'=>$this->input->post('descripcion'));
							//echo $this->input->post('action1');
							if($this->input->post('action1') !='')
								$search['where']=array('u.ValidacionFinalizada'=>$this->input->post('action1'));
						}            
						else $search = '';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						if($this->session->userdata('perfilUsuario') == '4'){
							$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"r.nombre, u.CLAVECCT, u.Turno",'select' => "r.idRegion,GROUP_CONCAT(DISTINCT r.nombre SEPARATOR ', ') AS region,SUBSTR(a.CLAVECCT,3,3) AS moda,a.CLAVECCT AS ct,a.NOMBRECT AS nombre,t.turno AS turnoID,t.descripcion AS turno,m.NOM AS municipio,ec.DescripcionEstado AS estatus, u.ValidacionFinalizada AS verificacion", 'tabla'=>"cp_usuarios AS u",'join' => array("a_ctba AS a"=> "a.CLAVECCT = u.CLAVECCT", "cp_cat_estatusct AS ec" => "a.STATUS = ec.idEstadusCT", "cp_cat_turno AS t" => "t.turno= u.Turno", "cp_cat_regionmunicipios AS rm" => "a.MUNICIPIO = rm.municipio", "cp_cat_region AS r" => "rm.idRegion = r.idRegion", "catmun AS m" => "a.MUNICIPIO = m.MUNICIPIO"),'group_by'=>array("u.CLAVECCT"," u.Turno"),'where'=>("SUBSTR(a.CLAVECCT,3,3) IN ('DCC','DPB','EJN','DJN','EPR','DPR','EML','DML','FUA','DIN','EDI','DDI','BBE','BBI','BBS','DAR','DBA','DCT','DNP','DPT','DTA','DUP','EBA','EBH','EBT','ECB',	'ELS','ENE','ENP','ENS','EUT','FCJ','FEI','FGE','FHA','FLS','FMB','FRB','FSP','FTM','HDH','HMC','IID','KJN','KPR','KTV','TAI','FZP','FIZ','FSE','FSP','FZI','DST','DSN','ETV','SES','DES','EES','ESN','EST','FIS','FTV','FST','FZT','FJI','FJZ','FJS') AND a.CCT_ZONA = '".$this->session->userdata('claveCCT')."'"));
						}else if($this->session->userdata('perfilUsuario') == '5'){
							$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"r.nombre, u.CLAVECCT, u.Turno",'select' => "r.idRegion,GROUP_CONCAT(DISTINCT r.nombre SEPARATOR ', ') AS region,SUBSTR(a.CLAVECCT,3,3) AS moda,a.CLAVECCT AS ct,a.NOMBRECT AS nombre,t.turno AS turnoID,t.descripcion AS turno,m.NOM AS municipio,ec.DescripcionEstado AS estatus, u.ValidacionFinalizada AS verificacion", 'tabla'=>"cp_usuarios AS u",'join' => array("a_ctba AS a"=> "a.CLAVECCT = u.CLAVECCT", "cp_cat_estatusct AS ec" => "a.STATUS = ec.idEstadusCT", "cp_cat_turno AS t" => "t.turno= u.Turno", "cp_cat_regionmunicipios AS rm" => "a.MUNICIPIO = rm.municipio", "cp_cat_region AS r" => "rm.idRegion = r.idRegion", "catmun AS m" => "a.MUNICIPIO = m.MUNICIPIO"),'group_by'=>array("u.CLAVECCT"," u.Turno"),'where'=>("SUBSTR(a.CLAVECCT,3,3) IN ('".$modalidades."')"));
						}
						else{
							$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"r.nombre, u.CLAVECCT, u.Turno",'select' => "r.idRegion,GROUP_CONCAT(DISTINCT r.nombre SEPARATOR ', ') AS region,SUBSTR(a.CLAVECCT,3,3) AS moda,a.CLAVECCT AS ct,a.NOMBRECT AS nombre,t.turno AS turnoID,t.descripcion AS turno,m.NOM AS municipio,ec.DescripcionEstado AS estatus, u.ValidacionFinalizada AS verificacion", 'tabla'=>"cp_usuarios AS u",'join' => array("a_ctba AS a"=> "a.CLAVECCT = u.CLAVECCT", "cp_cat_estatusct AS ec" => "a.STATUS = ec.idEstadusCT", "cp_cat_turno AS t" => "t.turno= u.Turno", "cp_cat_regionmunicipios AS rm" => "a.MUNICIPIO = rm.municipio", "cp_cat_region AS r" => "rm.idRegion = r.idRegion", "catmun AS m" => "a.MUNICIPIO = m.MUNICIPIO"),'group_by'=>array("u.CLAVECCT"," u.Turno"),'where'=>("SUBSTR(a.CLAVECCT,3,3) IN ('DCC','DPB','EJN','DJN','EPR','DPR','EML','DML','FUA','DIN','EDI','DDI','BBE','BBI','BBS','DAR','DBA','DCT','DNP','DPT','DTA','DUP','EBA','EBH','EBT','ECB',	'ELS','ENE','ENP','ENS','EUT','FCJ','FEI','FGE','FHA','FLS','FMB','FRB','FSP','FTM','HDH','HMC','IID','KJN','KPR','KTV','TAI','FZP','FIZ','FSE','FSP','FZI','DST','DSN','ETV','SES','DES','EES','ESN','EST','FIS','FTV','FZT','FST','FJI','FJZ','FJS','ETK')"));
						}
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$json->records = $count;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$temporalregistros[$key]['id'] = element('idRegion', $valor).'-'.element('ct', $valor).'-'.element('turno', $valor);
								$temporalregistros[$key]['nombre'] = trim(element('region', $valor));
								$temporalregistros[$key]['moda'] = element('moda', $valor);
								$temporalregistros[$key]['CLAVECCT'] = element('ct', $valor);
								$temporalregistros[$key]['NOMBRECT'] = trim(element('nombre', $valor));
								$temporalregistros[$key]['turno'] = element('turnoID', $valor);
								$temporalregistros[$key]['descripcion'] = element('turno', $valor);
								$temporalregistros[$key]['NOM'] = trim(element('municipio', $valor));
								$temporalregistros[$key]['DescripcionEstado'] = element('estatus', $valor);
								$temporalregistros[$key]['verificacion'] = element('verificacion', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'PreguntasFrecuentes': 
				switch($oper){
					case 'add': 
						$data_insertar['Pregunta'] = element('Pregunta',$_POST); $data_insertar['Respuesta'] = element('Respuesta',$_POST); $data_insertar['Estatus'] = intval('1');
						$this->db->insert("cp_faq",$data_insertar);
						break;
					case 'edit':
						$Pregunta =  element('Pregunta',$_POST); $Respuesta =  element('Respuesta',$_POST);
						$id = element('id',$_POST);
						$this->db->where("Id_Faq",$id,false);
						$this->db->update("cp_faq",array('Pregunta' => $Pregunta,'Respuesta' => $Respuesta));
						break;
					case 'del':
						$estado = element('estado',$_POST);$id = element('id',$_POST);
						$this->db->where("Id_Faq",$id);
						$this->db->update("cp_faq",array('Estatus' => intval($estado)),false);
						break;
					default:
						$post = array('limit'=>'0','page'=>$this->input->post('page'),'orden'=>"Pregunta",'select' => "Id_Faq,Pregunta,Respuesta,Estatus", 'tabla'=>"cp_faq");
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=array('Pregunta'=>$this->input->post('Pregunta'),'Respuesta'=>$this->input->post('Respuesta'));}            
						else $search = '';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"Pregunta",'select' => "Id_Faq,Pregunta,Respuesta,Estatus", 'tabla'=>"cp_faq");
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$json->records = $count;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$temporalregistros[$key]['id'] = element('Id_Faq', $valor);
								$temporalregistros[$key]['Pregunta'] = trim(element('Pregunta', $valor));
								$temporalregistros[$key]['Respuesta'] = trim(element('Respuesta', $valor));
								$temporalregistros[$key]['Estatus'] = element('Estatus', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'gestionBienes': 
				switch($oper){
					/*case 'add': 
						$data_insertar['IdMotivoMovimiento'] =  strtoupper(element('IdTipoMovimiento',$_POST));$data_insertar['NombreRecurso'] =  strtoupper(element('NombreRecurso',$_POST));$data_insertar['AliasRecurso'] =  element('AliasRecurso',$_POST);$data_insertar['MostrarRecursoBien'] =  '1';
						$this->db->insert("cp_cat_recursos_bienes",$data_insertar);
						break;
					case 'edit':
						$IdMotivoMovimiento =  strtoupper(element('IdTipoMovimiento',$_POST));$NombreRecurso =  strtoupper(element('NombreRecurso',$_POST));$AliasRecurso =  element('AliasRecurso',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdRecursoBien",$id,false);
						$this->db->update("cp_cat_recursos_bienes",array('IdMotivoMovimiento' => $IdMotivoMovimiento,'NombreRecurso' => $NombreRecurso,'AliasRecurso' => $AliasRecurso));
						break;
					case 'del':
						$estado = element('estado',$_POST);$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdRecursoBien",$id);
						$this->db->update("cp_cat_recursos_bienes",array('MostrarRecursoBien' => intval($estado)),false);
						break;*/
					case 'verificar':
						$id = element('id',$_POST);
						if($this->session->userdata('perfilUsuario') == '2' || $this->session->userdata('perfilUsuario') == '3'){ //SOLO CEDE Y ADMIN GENERAL
							$id = str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
							$this->db->where("IdBien",$id);
							$this->db->update("cp_bienes",array('IdEstatus' => intval(5)),false);

							$data_insertar['IdUsuario'] =  $this->session->userdata('usuarioId');
							$data_insertar['IdBien'] = $id;
							$data_insertar['Observaciones'] = element('desc',$_POST);
							$data_insertar['fechaverificado'] = date("Y-m-d H:i:s");
							$this->db->insert("cp_bienes_verificados",$data_insertar);
						}
						echo "verificar".$id;
						break;
					default:
						/*$post = array('limit'=>'100000','page'=>$this->input->post('page'),'orden'=>"ctb.NombreTipoBien, a.NombreArticulo, ceb.NombreEstadoBien, ce.NombreEstatus,crb.NombreRecurso, cmm.NombreMotivo, b.NoInventario, b.MarcaBien, b.ModeloBien, b.SerieBien, b.DescripcionBien",
							'select' => 'b.IdBien, ctb.NombreTipoBien, a.NombreArticulo, ceb.NombreEstadoBien, ce.NombreEstatus, GROUP_CONCAT(CONCAT(p.NombreProveedor,p.RfcProveedor) SEPARATOR ", ") AS proveedor, crb.NombreRecurso, cmm.NombreMotivo, b.NoInventario, b.MarcaBien, b.ModeloBien, b.SerieBien, b.DescripcionBien, b.PrecioUnitario, b.RegBorrado, b.BienCompartido', 
							'tabla'=>"cp_bienes AS b",
							'left_join'=>array("cim_articulo AS a"=> "a.IdTipoBien = ctb.IdTipoBien AND b.IdArticulo = a.IdArticulo"),
							'group_by'=>array("b.IdBien"),
							'join'=>array("cp_cat_tipos_bienes AS ctb"=> "b.IdTipoBien = ctb.IdTipoBien","cp_cat_estados_bienes AS ceb"=> "b.IdEstadoBien = ceb.IdEstadoBien","cp_cat_estatus AS ce"=> "b.IdEstatus = ce.IdEstatus","cp_proveedores AS p"=> "b.IdProveedor = p.IdProveedor","cp_cat_recursos_bienes AS crb"=> "b.IdRecursoBien = crb.IdRecursoBien","cp_cat_motivos_movimientos AS cmm"=> "b.IdMotivoMovimiento = cmm.IdMotivoMovimiento"));*/
						$claveCT_ = $this->input->post('claveCT');

						if($this->session->userdata('perfilUsuario') == '4'){// si es SUPERVISOR valida que el centro de trabajo sea de el
							$this->db->select("a.CLAVECCT AS cct, a.CLAVECCT AS id, a.CLAVECCT AS value, a.TURNO AS turno, a.NOMBRECT AS nombre, a.DOMICILIO AS domicilio, m.NOM AS municipio, l.NOMBRELOC AS localidad",false);
							$this->db->from('a_ctba AS a');
							$this->db->join('catmun AS m ', 'a.MUNICIPIO = m.MUNICIPIO','left');
							$this->db->join('a_itba AS l ', 'a.LOCALIDAD = l.LOCALIDAD AND a.MUNICIPIO = l.MUNICIPIO','left');
							$this->db->join('cp_cat_moda AS cm ', 'cm.Moda = SUBSTR(a.CLAVECCT,3,3) AND cm.ActivoSistema = 1');
							$this->db->like('a.CLAVECCT ', $claveCT_);
							$this->db->where('a.STATUS IN (1,4)');
							$this->db->where('a.CCT_ZONA = "'.$this->session->userdata('claveCCT').'"');
							$this->db->limit(1);
							$query = $this->db->get();
							//print_r($query);
							if($query->num_rows() == 0){
								return false;
							}
						}

						if($this->session->userdata('perfilUsuario') == '5'){// si es DIRECTOR DE NIVEL valida que el centro de trabajo sea de el
							$modalidades = $this->modelo_catalogos->rel_UsuariosModa();

							$this->db->select("a.CLAVECCT AS cct, a.CLAVECCT AS id, a.CLAVECCT AS value, a.TURNO AS turno, a.NOMBRECT AS nombre, a.DOMICILIO AS domicilio, m.NOM AS municipio, l.NOMBRELOC AS localidad",false);
							$this->db->from('a_ctba AS a');
							$this->db->join('catmun AS m ', 'a.MUNICIPIO = m.MUNICIPIO','left');
							$this->db->join('a_itba AS l ', 'a.LOCALIDAD = l.LOCALIDAD AND a.MUNICIPIO = l.MUNICIPIO','left');
							$this->db->join('cp_cat_moda AS cm ', 'cm.Moda = SUBSTR(a.CLAVECCT,3,3) AND cm.ActivoSistema = 1');
							$this->db->like('a.CLAVECCT ', $claveCT_);
							$this->db->where('a.STATUS IN (1,4)');
							$this->db->where("SUBSTR(a.CLAVECCT,3,3) IN ('".$modalidades."')");
							$this->db->limit(1);
							$query = $this->db->get();
							//print_r($query);
							if($query->num_rows() == 0){
								return false;
							}
						}

						$post = array('limit'=>'0','page'=>$this->input->post('page'),'orden'=>"ctb.NombreTipoBien, a.NombreArticulo, ceb.NombreEstadoBien, ce.NombreEstatus,crb.NombreRecurso, cmm.NombreMotivo, b.NoInventario, b.MarcaBien, b.ModeloBien, b.SerieBien, b.DescripcionBien",
							'select' => 'COUNT(*) AS total', 
							'tabla'=>"cp_usuarios AS u",
							'where'=>'u.CLAVECCT = "'.$claveCT_.'" AND b.RegBorrado = 0',
							'left_join'=>array("cim_articulo AS a"=> "a.IdTipoBien = ctb.IdTipoBien AND b.IdArticulo = a.IdArticulo",'cp_rel_bienes_articulos AS ba' => 'ba.IdBien = b.IdBien'),
							'join'=>array("cp_bienes AS b" => "b.CCTBien = u.CLAVECCT","cp_cat_tipos_bienes AS ctb"=> "b.IdTipoBien = ctb.IdTipoBien","cp_cat_estados_bienes AS ceb"=> "b.IdEstadoBien = ceb.IdEstadoBien","cp_cat_estatus AS ce"=> "b.IdEstatus = ce.IdEstatus","cp_proveedores AS p"=> "b.IdProveedor = p.IdProveedor","cp_cat_recursos_bienes AS crb"=> "b.IdRecursoBien = crb.IdRecursoBien","cp_cat_motivos_movimientos AS cmm"=> "b.IdMotivoMovimiento = cmm.IdMotivoMovimiento"));
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('NombreTipoBien','NombreArticulo','NombreEstadoBien','NombreEstatus','NombreRecurso','NombreMotivo','NoInventario','MarcaBien','ModeloBien','SerieBien','DescripcionBien','Observaciones'),$this->input->post());
							
							if($this->input->post('Verificado')){
								$esta = explode(',', $this->input->post('Verificado'));
								if(count($esta) > 1){
								/*	$esta_ = array();
									foreach($esta as $key2 => $value2){
										$esta_[$key2] = array( 'b.IdEstatus' => $value2);
									}*/

									$search['where'] = array('IN_WHERE' => array('b.IdEstatus' =>$this->input->post('Verificado')) );
								}
								else{
									$search['where'] = array('b.IdEstatus'=>$this->input->post('Verificado')) ;
								}
							}
	
						}            
						else {$search='';}
						
						
						if(/*$this->input->post('_search') == 'false' || */($this->input->post('NombreTipoBien') == '0' && $this->input->post('NombreArticulo') == '0' && $this->input->post('NombreEstadoBien') == '0' && $this->input->post('NombreEstatus') == '0' && $this->input->post('NombreRecurso') == '0' && $this->input->post('NombreMotivo') == '0' && $this->input->post('NoInventario') == '' && $this->input->post('MarcaBien') == '' && $this->input->post('ModeloBien') == '' && $this->input->post('SerieBien') == '' && $this->input->post('DescripcionBien') == '' && $this->input->post('proveedor') == '' ) && $this->input->post('Observaciones') == ''  && $this->input->post('claveCT') == '') {$json->rows=array();echo json_encode($json); return false;}
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);

						$count = $temporalregistros[0]['total'];
						
						$post['limit'] = $this->input->post('rows');
						$off = 0;
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$off = $post['offset']= $post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$json->records = $count;
						/*
						echo "total:".$count;
						echo "  limit:".$post['limit'];
						echo "  offset:".$post['offset'];
						die();//*/
						
						
						$temporalregistros = array();
						$post = array('limit'=>$this->input->post('rows'), 'offset'=>$off, 'page'=>$this->input->post('page'),'orden'=>"ctb.NombreTipoBien, a.NombreArticulo, ceb.NombreEstadoBien, ce.NombreEstatus,crb.NombreRecurso, cmm.NombreMotivo, b.NoInventario, b.MarcaBien, b.ModeloBien, b.SerieBien, b.DescripcionBien",
							'select' => 'b.IdBien, ctb.NombreTipoBien, a.NombreArticulo, ceb.NombreEstadoBien, ce.NombreEstatus, GROUP_CONCAT(DISTINCT CONCAT(p.NombreProveedor,p.RfcProveedor) SEPARATOR ", ") AS proveedor, crb.NombreRecurso, cmm.NombreMotivo, b.NoInventario, b.MarcaBien, b.ModeloBien,b.IdEstatus, b.SerieBien, b.DescripcionBien, b.PrecioUnitario, b.RegBorrado,b.Observaciones, if(ba.IdArticulo,1,0) AS BienCompartido, GROUP_CONCAT(DISTINCT CONCAT("Folio: ",an.NoFacturaAnexo," - Fecha: ",an.FechaFacturaAnexo)) AS FacturaFecha, GROUP_CONCAT(DISTINCT CONCAT("No. Salida: ",b.NoSalidaBien," - Fecha: ",date(b.FechaCreacion))) AS Nosalida',
							'tabla'=>"cp_usuarios AS u",
							'where'=>'u.CLAVECCT = "'.$claveCT_.'" AND b.RegBorrado = 0',
							'left_join'=>array("cim_articulo AS a"=> "a.IdTipoBien = ctb.IdTipoBien AND b.IdArticulo = a.IdArticulo",'cp_rel_bienes_articulos AS ba' => 'ba.IdBien = b.IdBien', 'cp_rel_bienes_anexos AS rba' => 'rba.IdBien = b.IdBien' , 'cp_anexos AS an' => 'an.IdAnexo = rba.IdAnexo AND an.Tipo = 1'),
							'group_by'=>array("b.IdBien"),
							'join'=>array("cp_bienes AS b" => "b.CCTBien = u.CLAVECCT", "cp_cat_tipos_bienes AS ctb"=> "b.IdTipoBien = ctb.IdTipoBien","cp_cat_estados_bienes AS ceb"=> "b.IdEstadoBien = ceb.IdEstadoBien","cp_cat_estatus AS ce"=> "b.IdEstatus = ce.IdEstatus","cp_proveedores AS p"=> "b.IdProveedor = p.IdProveedor","cp_cat_recursos_bienes AS crb"=> "b.IdRecursoBien = crb.IdRecursoBien","cp_cat_motivos_movimientos AS cmm"=> "b.IdMotivoMovimiento = cmm.IdMotivoMovimiento"));
						//print_r($post); die();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('IdBien', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['NombreTipoBien'] = element('NombreTipoBien', $valor);
								$temporalregistros[$key]['NombreArticulo'] = (element('NombreArticulo', $valor)) ? element('NombreArticulo', $valor) : "";
								$temporalregistros[$key]['NombreEstadoBien'] = element('NombreEstadoBien', $valor);
								$temporalregistros[$key]['IdEstatus'] = element('IdEstatus', $valor);
								$temporalregistros[$key]['NombreEstatus'] = element('NombreEstatus', $valor);
								$temporalregistros[$key]['proveedor'] = element('proveedor', $valor);
								$temporalregistros[$key]['NombreRecurso'] = element('NombreRecurso', $valor);
								$temporalregistros[$key]['NombreMotivo'] = element('NombreMotivo', $valor);
								$temporalregistros[$key]['NoInventario'] = (element('NoInventario', $valor)) ? element('NoInventario', $valor) : "";
								$temporalregistros[$key]['MarcaBien'] = element('MarcaBien', $valor);
								$temporalregistros[$key]['ModeloBien'] = element('ModeloBien', $valor);
								$temporalregistros[$key]['SerieBien'] = element('SerieBien', $valor);
								$temporalregistros[$key]['FacturaFecha'] = (element('FacturaFecha', $valor)) ? element('FacturaFecha', $valor)  : "";
								$temporalregistros[$key]['Nosalida'] =  (element('Nosalida', $valor)) ? element('Nosalida', $valor)  : "";
								$temporalregistros[$key]['DescripcionBien'] = element('DescripcionBien', $valor);
								$temporalregistros[$key]['PrecioUnitario'] = (element('PrecioUnitario', $valor)) ? element('PrecioUnitario', $valor) : "0";
								$temporalregistros[$key]['RegBorrado'] = element('RegBorrado', $valor);
								$temporalregistros[$key]['BienCompartido'] = element('BienCompartido', $valor);
								
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'Modalidades': 
				switch($oper){
					case 'edit':
						$Moda =  strtoupper(element('Moda',$_POST));$Descripcion =  strtoupper(element('Descripcion',$_POST));
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id); $id = $this->encrypt->decode($id);
						$this->db->where("IdModa",$id,false);
						$this->db->update("cp_cat_moda",array('Moda' => $Moda,'Descripcion' => $Descripcion));
						break;
					case 'del':
						$estado = element('estado',$_POST);$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdModa",$id);
						$this->db->update("cp_cat_moda",array('ActivoSistema' => intval($estado)),false);
						break;
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"Moda,Descripcion",
						'select' => "IdModa AS id, Moda, Descripcion, ActivoSistema", 'tabla'=>"cp_cat_moda");
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('Moda','Descripcion'),$this->input->post());}
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['Moda'] = element('Moda', $valor);
								$temporalregistros[$key]['Descripcion'] = (element('Descripcion', $valor)) ? element('Descripcion', $valor) : "";
								$temporalregistros[$key]['estado'] = element('ActivoSistema', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case 'colores': 
				switch($oper){
					case 'add': 

						$data_insertar['Color'] =  element('Color',$_POST);
						$data_insertar['Estatus'] =  '1';
						$this->db->insert("cp_cat_colores_articulos",$data_insertar);
						break;
					case 'edit':
						$Color = element('Color',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdColor",$id,false);
						$this->db->update("cp_cat_colores_articulos",array('Color' => $Color));
						break;
					case 'del':
						$estado = element('estado',$_POST);
						$id = element('id',$_POST);$id=str_replace(array('-', '_', '~'),array('+', '/', '='), $id);$id = $this->encrypt->decode($id);
						$this->db->where("IdColor",$id);
						$this->db->update("cp_cat_colores_articulos",array('Estatus' => intval($estado)),false);
						break;
					default:
						$post = array('limit'=>$this->input->post('rows'),'page'=>$this->input->post('page'),'orden'=>"c.Color",
						'select' => "c.IdColor AS id,c.Color,c.Estatus", 'tabla'=>"cp_cat_colores_articulos AS c");
						
						$validacion = $this->input->post('_search');
						if($validacion){$search['like']=elements(array('Color'),$this->input->post());}            
						else $search='';
				
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search,$post);
						$count = count($temporalregistros);
						
						if( $count > 0 && $post['limit'] > 0) {
							$total_pages = ceil($count/$post['limit']);
							if ($post['page'] > $total_pages) $post['page']=$total_pages;
							$post['offset']=$post['limit']*$post['page'] - $post['limit'];
						} else {$total_pages = 0;$post['page']=0;$post['offset']=0;}    
						
						$json->page=$post['page'];
						$json->total=$total_pages;
						$temporalregistros = array();
						$temporalregistros = $this->modelo_catalogos->listar($search, $post);
			
						if(count ($temporalregistros) > 0 ){
							foreach($temporalregistros as $key => $valor){
								$id = $this->encrypt->encode(element('id', $valor));$id  = str_replace(array('+', '/', '='), array('-', '_', '~'), $id);$temporalregistros[$key]['id'] = $id;
								$temporalregistros[$key]['Color'] = element('Color', $valor);
								$temporalregistros[$key]['Estatus'] = element('Estatus', $valor);
							}
						}
						$json->rows=$temporalregistros;
						echo json_encode($json);
						break;
				 }
				 break;
			case '': break;
		}
	}
	public function catalogo($catalogo = "",$opcion = 1){
		switch($catalogo) {
			case 'motivoMovimiento': 
				echo $this->modelo_catalogos->selectHTML($catalogo,$opcion);
				break;
			case 'Region': 
				echo $this->modelo_catalogos->selectHTML($catalogo,$opcion);
				break;
			case 'Municipio': 
				echo $this->modelo_catalogos->selectHTML($catalogo,$opcion);
				break;
			case 'catEstatusEscuela':
				echo $this->modelo_catalogos->selectHTML($catalogo,$opcion);
				break;
			case 'catTurnos':
				echo $this->modelo_catalogos->selectHTML($catalogo,$opcion);
				break;
			case 'tipoBien':
				echo $this->modelo_catalogos->selectHTML($catalogo,$opcion);
				break;
			case 'articuloCIM':
				echo $this->modelo_catalogos->selectHTML($catalogo,$opcion);
				break;
			case 'estadosBienes':
				echo $this->modelo_catalogos->selectHTML($catalogo,$opcion);
				break;
			case 'recursosBienes':
				echo $this->modelo_catalogos->selectHTML($catalogo,$opcion);
				break;
			case 'estatusBienes':
				echo $this->modelo_catalogos->selectHTML($catalogo,$opcion);
				break;
			default:
				echo "";
		}
	}
	public function listaCentrosTrabajo(){
		$tituloMigas = 'Centros de Trabajo';
		$datos = Modules::run("inicio/inicio/funcionesBasicas",$tituloMigas);
		$data['token'] = $this->security->get_csrf_hash();
		$this->load->model('modelo_inicio');
		$this->load->view('header',$datos);
		$this->load->view('vista_listaCT',$data);
		$this->load->view('footer');
	}
	public function DocumentosDescargables(){
		$tituloMigas = 'Documentos Descargables';
		$datos = Modules::run("inicio/inicio/funcionesBasicas",$tituloMigas);
		$data['token'] = $this->security->get_csrf_hash();
		$this->load->model('modelo_inicio');
		$data['ANEXOS'] = $this->modelo_catalogos->obtenerArchivos();
		$this->load->view('header',$datos);
		$this->load->view('vista_documentos_descargables',$data);
		$this->load->view('footer');
	}
	public function FAQ(){
		$tituloMigas = 'Preguntas Frecuentes';
		$datos = Modules::run("inicio/inicio/funcionesBasicas",$tituloMigas);
		$data['token'] = $this->security->get_csrf_hash();
		$this->load->model('modelo_inicio');
		
		$preguntas = $this->modelo_catalogos->seleccionar_preguntas();
		$datos['preguntas'] = $preguntas;
		
		$this->load->view('header',$datos);
		$this->load->view('vista_preguntas_frecuentes',$data);
		$this->load->view('footer');
	}
	public function GuardarArchivoDescargable(){
//		Modules::run("inicio/inicio/verificarPermisos",array(4,6));	//4->GESTION ARCHIVOS, 6-> CRUD BAJAS

		$datosArchivos['archivos'] = array_keys($_FILES);
		$datosRes = Modules::run("gestion_archivos/gestion_archivos/guardarArchivosDescargables",$datosArchivos);
		if($datosRes[0]['RESULTADO'] == 'Se ha guardado correctamente'){
			$res = $this->modelo_catalogos->guardarArchivo($datosRes);
			//echo $res;	
		}
		echo json_encode($datosRes);
	}
	public function GuardarArchivoTutorial(){
		$datosArchivos['archivos'] = array_keys($_FILES);
		if($this->input->post('nombre_tutorial') == '' || $this->input->post('perfil_usuario') == ''){
			echo json_encode(array('RESULTADO' => 'Revice la Informacion'));
			die();
		}
		$datosRes = Modules::run("gestion_archivos/gestion_archivos/guardarArchivosTutoriales",$datosArchivos);
		if($datosRes[0]['RESULTADO'] == 'Se ha guardado correctamente'){
			$res = $this->modelo_catalogos->guardarArchivoTutorial($datosRes);
			//echo $res;	
		}
		echo json_encode($datosRes);
	}

	public function Archivos_Descargables(){
		//Modules::run("inicio/inicio/verificarPermisos",6);	//6-> CRUD BAJAS
		echo $this->modelo_catalogos->obtenerArchivos();
	}
	public function Archivos_Tutoriales(){
		//Modules::run("inicio/inicio/verificarPermisos",6);	//6-> CRUD BAJAS
		echo $this->modelo_catalogos->obtenerTutoriales();
	}
	
	public function eliminar_Archivo(){
		echo $this->modelo_catalogos->eliminar_Archivo();
	}
	public function eliminar_Tutorial(){
		echo $this->modelo_catalogos->eliminar_Tutorial();
	}
	
	public function bienes_administrador(){
		$tituloMigas = 'Gestión de bienes';
		$datos = Modules::run("inicio/inicio/funcionesBasicas",$tituloMigas);
		$data['token'] = $this->security->get_csrf_hash();
		$data['perfil'] = $this->session->userdata('perfilUsuario');

		$this->load->model('modelo_inicio');
		
		$this->load->view('header',$datos);
		$this->load->view('vista_gestion_bienes',$data);
		$this->load->view('footer');
	}

	public function vistaHTML(){
		$vista = $this->input->post('vista');
		$html = "";
		$data = array();
		switch($vista) {
			case 'reporteBienesAdmin': 
				$data["adquisicion"] = $this->modelo_catalogos->selectDATA("adquisicion");
				$data["modalidades"] = $this->modelo_catalogos->selectDATA("modalidades");
				$data["recurso"] = $this->modelo_catalogos->selectDATA("recurso");
				$data["tipoBien"] = $this->modelo_catalogos->selectDATA("tipoBien");
				$html = $this->load->view('vista_reporteBienes',$data, TRUE);
				break;
			case 'altaPersonal':
				$data['token'] = $this->security->get_csrf_hash();
				$data["funciones"] = $this->modelo_catalogos->selectDATA("funciones");
				$data["cct"] = $this->session->userdata('claveCCT');
				$data["turno"] = $this->session->userdata('turno');
				if($this->input->post('cct') && $this->input->post('turno')){
					$data["cct"] = $this->input->post('cct');
					$data["turno"] = $this->input->post('turno');
				}
				$html = $this->load->view('vista_altaPersonal',$data, TRUE);
				break;
		}
		echo  $html;
	}
	public function plantilla_ALTAPERSONAL(){
		$this->legacy_db = $this->load->database('stats', true);
		$claveCCT = $this->session->userdata('claveCCT');
		$turno = $this->session->userdata('turno');
		if($this->input->post('cct')){
			$claveCCT = $this->input->post('cct');
			$turno = $this->input->post('turno');
		}

		//print_r($_POST);

		//RECUPERA SI EXISTE LA PERSONA EN LA TABLA DE PPX_PERSONA SI EXISTE RECUPERA EL ID SI NO SE INSERTA UNO NUEVO
		$sql = "SELECT idppx_persona FROM ppx_persona WHERE CONCAT(rfc_raiz,rfc_homclave) = '".trim(element('rfc',$_POST)).trim(element('homo',$_POST))."' LIMIT 1";
		$query = $this->legacy_db->query($sql);
		$id = $id_p = 0;
		if($query->num_rows() > 0){
			$campo = $query->row();
			$id_p = $campo->idppx_persona;
		}
		else{
			$sql = "INSERT IGNORE INTO ppx_persona(idppx_persona, rfc_raiz, rfc_homclave, apepa_perso, apema_perso, nombres_perso, curp_perso, numife_persona, id_edonac, muni_nac, pais_nac, genero, edoCivil, fechanac, fotopersona, tipo_per)
				VALUES(NULL,
				UPPER('".trim(element('rfc',$_POST))."'),
				UPPER('".trim(element('homo',$_POST))."'),				
				UPPER('".trim(element('app',$_POST))."'),
				UPPER('".trim(element('apm',$_POST))."'),
				UPPER('".trim(element('nombre',$_POST))."'),
				UPPER('".trim(element('curp',$_POST))."'),
				'".trim(element('_numife',$_POST))."',	
				0,
				0,
				0,		
				'".trim(element('_genero',$_POST))."',
				0,
				'".trim(element('_fecha',$_POST))."',
				'',
				1)";
			$query = $this->legacy_db->query($sql);
			$id_p = $this->legacy_db->insert_id();
		}

		//RECUPERA EL ID DEL EMPLEADO EN LA TABLA PPX_EMPLEADO
		if(!empty($id_p)){
			$sql = "SELECT id_empleado FROM ppx_empleado WHERE id_persona = ".$id_p." LIMIT 1";
			$query = $this->legacy_db->query($sql);
			$campo = $query->row();
			$id = $campo->id_empleado;
		}
		else{return false;}

		//OBTIENE EL CICLO ACTUAL DE PLANTILLA
		$cicloCurso = 0;
		$sql = "SELECT idciclo FROM ppx_cat_ciclo WHERE status = '1' LIMIT 1";
			$query = $this->legacy_db->query($sql);
			$campo = $query->row();
			$cicloCurso = $campo->idciclo;

		//INSERTA A LA PERSONA EN EL CENTRO DE TRABAJO CON SITUACION Y FUNCION
		$sql = "INSERT IGNORE INTO ppx_empleado_ctt(id_empleado_ctt,id_empleadosubs, clavect, turno, idfuncion, estatus, idsituacion, observacion, cicloCurso, personaSuplir)
			VALUES(NULL,".$id.",
			UPPER('".trim($claveCCT)."'),				
			UPPER('".trim($turno)."'),
			".trim(element('funcion',$_POST)).",
			0,
			".trim(element('situacion',$_POST)).",
			'',	
			".$cicloCurso.",
			0)";
		$query = $this->legacy_db->query($sql);
		$id_e = $this->legacy_db->insert_id();

		//echo "Idpersona: ".$id_p." id_empleado: ".$id." idempleadocct: ".$id_e;
		echo "INSERT";
		
		die();
	}

	public function getAnexosBien(){

		$IDSOL = element('idBien', $_POST);
		$content_html = "";
		if(!empty($IDSOL)) {
			$temporalregistros = $this->modelo_catalogos->obtenerAnexosBien($IDSOL);

			$content_html .= $this->bienesanexos($temporalregistros);
			
		}
		echo utf8_encode($content_html);
	}

	public function bienesanexos($temporalregistros){
			$rutaimage  = 'resources\images\pdf_icono.png';
			$content_html = '<div>';
			if(count($temporalregistros) > 0){
				foreach($temporalregistros as $key => $valor){
				    $ubicacionarchivo = element('UbicacionAnexo', $valor);
				    $nombrearchivo = element('NoFacturaAnexo', $valor);
				    $extensionarchivo = element('ExtensionAnexo', $valor);
				    $nombreanexo = element('NombreAnexo', $valor);
				    
				    $urlanexo = INDEX_CP.$ubicacionarchivo.$nombreanexo.$extensionarchivo;
					
				    if($extensionarchivo == '.pdf' || $extensionarchivo == '.PDF') {
				        $content_html .= '<div class="col-sm-6" style="height:75px;overflow:hidden;"><img src='.INDEX_CP.$rutaimage.' href='.$urlanexo.' width="60"  border="0" >';
				        $content_html .= '<a src='.$urlanexo.' href='.$urlanexo.' onclick="window.open(this.href,this.target);return false;">No. factura o Folio: <strong>'.$nombrearchivo.'</strong></a><hr style="margin: 10px 0;"></div>';
				    } else if($extensionarchivo == '.xml' || $extensionarchivo == '.xml'){
						$content_html .= '<div class="col-sm-6" style="height:75px;overflow:hidden;"><img src="'.INDEX_CP.'resources/images/xml_icono.png" href='.$urlanexo.' width="60"  border="0" >';
				        $content_html .= '<a src='.$urlanexo.' href='.$urlanexo.' onclick="window.open(this.href,this.target);return false;">No. factura o Folio: <strong>'.$nombrearchivo.'</strong></a><hr style="margin: 10px 0;"></div>';
					}
				    else {
				        $content_html .= '<div class="col-sm-6" style="height:75px;overflow:hidden;"><img src='.$urlanexo.' href='.$urlanexo.' width="60"  border="0" onclick="window.open(this.src)">';	
				        $content_html .= '<a src='.$urlanexo.' href='.$urlanexo.' onclick="window.open(this.href,this.target);return false;">No. factura o Folio: <strong>'.$nombrearchivo.'</strong></a><hr style="margin: 10px 0;"></div>';
				    }
				}
			}
			else{
				$content_html .= 'No tiene Evidencia este Bien.';
			}
			$content_html .= '<div>';

			return $content_html;
	}

	public function getAnexosBien2(){

		 $rutaimage  = 'resources\images\pdf_icono.png';
		$IDSOL = element('idBien', $_POST);
		$content_html = "";
		if(!empty($IDSOL)) {
			$temporalregistros = $this->modelo_catalogos->obtenerAnexosBien2($IDSOL);
			$content_html .= $this->bienesanexos($temporalregistros);
		}
		echo utf8_encode($content_html);
	}
	/**********************************************
	FUNCIÓN PARA REALIZAR LA BÚSQUEDA PRE ALPHA
	*********************************************** */

	public function execute_search(){
		$serie = $this->input->post('search');
		$dataSerie['results'] = $this->modelo_catalogos->search_serie($serie);
		$this->load->view('TestSerie', $dataSerie);
	}
	
}




/*
*end modules/bitacoras/controllers/bitacoras.php
*/