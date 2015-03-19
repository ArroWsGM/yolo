<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admincontroller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
		
		$this->load->helper(array(	'url',
									'form',
									'date',
									'string',
									'custom',
									'file'));
		
		$this->load->library(array(	'form_validation',
									'image_lib',
									'upload',
									'pagination'));
	}

	public function mainpage(){
		$data['title'] = 'Изменить главную страницу';
		$data['path'] = base_url($this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_mainpage_path')).'/';
		//$data['cart']=$this->session->userdata('cart'); getConParam('admin_item_per_page')
		$config['base_url'] = site_url('admincontroller/mainpage');
		$config['total_rows'] = $this->db->count_all('mainpage');
		$config['per_page'] = $this->Admin_model->getConParam('admin_item_per_page');

		$this->pagination->initialize($config);
		
		if($this->uri->segment(3)>=$config['total_rows'] && $this->uri->segment(3)!=false)
			redirect(site_url());
		
		$this->form_validation->set_rules('text', 'Текст', 'trim|htmlspecialchars|max_length[2048]');
		
		if ($this->form_validation->run() === FALSE){
			$data['mainpage'] = $this->Admin_model->getAll('mainpage', array('field'=>'id', 'order'=>'desc'), $config['per_page'], $this->uri->segment(3));
			$data['pagination']=$this->pagination->create_links();
			//var_dump($data['mainpage']);
			//exit;
			$this->load->view('templates/header', $data);
			$this->load->view('templates/menu');
			$this->load->view('mainpage', $data);
			$this->load->view('templates/footer');
		}
		else {
			$currid=$this->Admin_model->getMaxID('mainpage');
			$path='./'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_mainpage_path').$currid.'/';
			$result=$this->do_upload($path, 'img_bg_name', 'original');
			if(isset($result['error'])){
				$this->getError($result);
			}
			else{
				//var_dump($path);
				//var_dump($this->upload->file_type);
				//var_dump($_FILES);
				//var_dump($result);
				if($result['image_width']<=1280){
					$arr['img_bg_name']=$result['file_name'];
					$arr['width']=$result['image_width'];
					$arr['height']=$result['image_height'];
					$this->input->post(NULL, TRUE);
					$arr['text']=$this->input->post('text');
					$this->Admin_model->insert('mainpage', $arr);
					redirect(current_url());
					//$data['mainpage'] = $this->Admin_model->getAll('mainpage');
					//$this->load->view('templates/header', $data);
					//$this->load->view('templates/menu');
					//$this->load->view('mainpage', $data);
					//$this->load->view('templates/footer');
				}
				else {
					$config['source_image']	= $result['full_path'];
					$config['new_image'] = 'resize1280'.$result['file_ext'];
					$config['width'] = 1280;
					$config['height'] = 1280;
					$config['maintain_ratio'] = TRUE;
					$this->image_lib->initialize($config);
					if (!$this->image_lib->resize()){
						$this->getError(array('error'=>$this->image_lib->display_errors()));
					}
					else{
						$imgInfo=getimagesize($path.$config['new_image']);
						$arr['img_bg_name']=$config['new_image'];
						$arr['width']=$imgInfo[0];
						$arr['height']=$imgInfo[1];
						$this->input->post(NULL, TRUE);
						$arr['text']=$this->input->post('text');
						$this->Admin_model->insert('mainpage', $arr);
						redirect(current_url());
						//$data['mainpage'] = $this->Admin_model->getAll('mainpage');
						//$this->load->view('templates/header', $data);
						//$this->load->view('templates/menu');
						//$this->load->view('mainpage', $data);
						//$this->load->view('templates/footer');
					}
				}
				
			}
		}

	}
	
	public function blog($field='date'){
		$data['title'] = 'Блог';
		
		$config['base_url'] = site_url('admincontroller/blog').'/'.$field;
		$config['total_rows'] = $this->db->count_all('blog');
		$config['per_page'] = $this->Admin_model->getConParam('admin_item_per_page');
		$config['uri_segment'] = 4;

		$this->pagination->initialize($config);
		
		if($this->uri->segment(4)>=$config['total_rows'] && $this->uri->segment(4)!=false)
			redirect(site_url('admincontroller/blog/date'));
		
		$order=($field=='name')?'asc':'desc';
		
		$data['blog']=$this->Admin_model->getAll('blog', array('field'=>$field, 'order'=>$order), $config['per_page'], $this->uri->segment(4));
		//$data['pagination']=$this->pagination->create_links();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu');
		$this->load->view('blog/blog', $data);
		$this->load->view('templates/footer');
	}
	
	public function editBlog($action='add', $id=null){
		$data['title'] = 'Добавить/изменить запись';
		if($action == "edit"){
			$this->input->post(NULL, TRUE);
			$arr=$this->input->post();
			unset($arr['refer_from']);
			if($id)
				if(count($this->Admin_model->getRow('blog', $id))==0)
					redirect(site_url('admincontroller/blog/date'));
			
			$this->form_validation->set_rules('name', 'Имя', 'trim|htmlspecialchars|required|max_length[255]');
			$this->form_validation->set_rules('text', 'Текст', 'trim|htmlspecialchars|required');
			
			if ($this->form_validation->run() === FALSE){
				$data['blog']=($arr) ? $arr : $this->Admin_model->getRow('blog', $id);
				
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu');
				$this->load->view('templates/tinymce');
				$this->load->view('blog/blogrecord', $data);
				$this->load->view('templates/footer');
				return;
			}
			else{
				if ($_FILES && $_FILES['photo']['error']!=4){
					//list($size['width'], $size['height']) = getimagesize($_FILES['photo']['tmp_name']);
					//var_dump($_FILES);
					//exit;
					if(!$id && empty($arr['id'])) $id=$this->Admin_model->getMaxID('blog');
					if(!empty($arr['id'])) $id=$arr['id'];
					$path='./'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_blog_path').$id;
					$photo=$this->Admin_model->getRow('blog', $id)['photo'];
					if($photo)
						$name=preg_replace('/_thumb/i', '', $photo);
					else
						$name='blgt_'.random_string('unique');
					$result=$this->do_upload($path, 'photo', $name, $overwrite=true, $delete=false);
					if(isset($result['error'])){
						$this->getError(array('error'=>$result['error']));
						return;
					}
					$width=$this->Admin_model->getConParam('img_thumb_width');
					$height=$this->Admin_model->getConParam('img_thumb_height');
					$res=$this->makeThumb('thumb', $result['full_path'], array('width'=>$width, 'height'=>$height));
					if(!$res){
						$this->getError(array('error'=>'Ошибка в Image Manipulation Class'));
						return;
					}
				}
				$replace=preg_replace('/\.\w+/i', '', basename($result['file_name']));
				$img=str_replace($replace, $replace.'_thumb', $result['file_name']);
				if(is_file($result['full_path'])) unlink($result['full_path']);
				if(!isset($arr['id']) || $arr['id']===''){
					unset($arr['id']);
					if($result['file_name']) $arr['photo']=$img;
					$this->Admin_model->insert('blog', $arr);
					$id=$this->db->insert_id();
				}
				else{
					//unset($arr['id']);
					if($result['file_name']) $arr['photo']=$img;
					$this->Admin_model->update('blog', $arr['id'], $arr);
					$id=$arr['id'];
				}
				redirect(site_url('admincontroller/editBlog/edit').'/'.$id);
			}
			
			//var_dump($arr);
			//exit;
		}
		//$data['blog'] = $this->Admin_model->getRow('blog', $id);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu');
		$this->load->view('templates/tinymce');
		$this->load->view('blog/blogrecord', $data);
		$this->load->view('templates/footer');
	}
	
	public function getBlogGallery($data=false, $table='blogimg', $alt='name', $nameprefix='blogimg_', $view='blog'){
		if($data=='true'){
			if(empty($this->input->post()) && empty($_FILES) && $_SERVER['CONTENT_LENGTH']>0){
				$max=ini_get('post_max_size');
				$length=bytesToSize($_SERVER['CONTENT_LENGTH']);
				$data=array('type' => 'error', 'message' => "Превышен суммарный размер данных ($max): передано $length");
				header('HTTP/1.1 413 Request Entity Too Large');
				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode($data);
				return;
			}
			if(!empty($_FILES) && implode($_FILES[$table]['error'])==1){
				$max=ini_get('upload_max_filesize');
				$length=bytesToSize($_SERVER['CONTENT_LENGTH']);
				$data=array('type' => 'error', 'message' => "Превышен максимальный размер файла ($max): передано $length");
				header('HTTP/1.1 413 Request Entity Too Large');
				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode($data);
				return;
			}
		//sleep(3);
			$this->input->post(NULL, TRUE);
			$post=$this->input->post();
			if (isset($post['path'])) $path=$this->input->post('path');
			else $path='./'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_blog_path');
			$desc=$post[$alt];
			//var_dump($_FILES);
			//exit;
			$result=$this->uploadMultiple($path, $table, $nameprefix);
			if(isset($result['error'])){
				$data=array('type' => 'error', 'message' => 'Ошибка загрузки файла #'.$result['num'].': '.$result['error']);
				header('HTTP/1.1 400 Bad Request');
				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode($data);
				return;
			}
			else{
				if (isset($post['thumbs'])){
					$width=$this->Admin_model->getConParam('img_thumb_width');
					$height=$this->Admin_model->getConParam('img_thumb_height');
					$i=0;
					foreach($result as $val){
						//var_dump($val['full_path']);
						$this->image_lib->clear();
						$res=$this->makeThumb('thumb', $val['full_path'], array('width'=>$width, 'height'=>$height));
						if(!$res){
							$this->getError(array('error'=>'Ошибка в Image Manipulation Class'));
							return;
						}
						$arr[$i]['thumb']=$val['raw_name'].'_thumb'.$val['file_ext'];
						if (isset($post['eployee_id'])) $arr[$i]['eployee_id']=$post['eployee_id'];
						$i++;
					}
				}
			
				$i=0;
				foreach($result as $val){
					$arr[$i]['path']=$val['file_name'];
					$arr[$i]['width']=$val['image_width'];
					$arr[$i]['height']=$val['image_height'];
					if($desc!='')$arr[$i][$alt]=$desc;
					$i++;
				}
				//var_dump($arr);
				//return;
				$data=array('status' => $this->Admin_model->insert_batch($table, $arr));
				echo json_encode($data);
				return;
			}
		}
		//var_dump($view);
		$data=array();
		$data[$table] = $this->db->count_all($table);
		//var_dump($data);
		echo $this->load->view($view.'/bloggall', $data, true);
	}

	public function getBlogGalleryItems($table='blogimg', $field='false', $val='false', $offset=''){
		$config['base_url'] = site_url('admincontroller/getBlogGalleryItems').'/'.$table.'/'.$field.'/'.$val;
		$config['per_page'] = $this->Admin_model->getConParam('img_per_page_portfolio');
		$config['uri_segment'] = 6;

		
		$this->input->post(null, true);
		if ($field!='false'){
			$where['field']=$field;
			$where['value']=$val;
			$data[$table] = $this->Admin_model->getWhere($table, $where, $config['per_page'], $this->uri->segment(6));
			$config['total_rows'] = $this->db->get_where($table, array($field => $val))->num_rows();
		}
		else{
			$data[$table] = $this->Admin_model->getAll($table, array('field'=>'id', 'order'=>'desc'), $config['per_page'], $this->uri->segment(6));
			$config['total_rows'] = $this->db->count_all($table);
		}
		
		$this->pagination->initialize($config);
		$data['count'] = $config['total_rows'];
		echo $this->load->view('galleries/'.$table, $data, true);
	}
	
	public function team($field='name'){
		$data['title'] = 'Команда';
		
		$config['base_url'] = site_url('admincontroller/team').'/'.$field;
		$config['total_rows'] = $this->db->count_all('employee');
		$config['per_page'] = $this->Admin_model->getConParam('admin_item_per_page');
		$config['uri_segment'] = 4;

		$this->pagination->initialize($config);
		
		if($this->uri->segment(4)>=$config['total_rows'] && $this->uri->segment(4)!=false)
			redirect(site_url('admincontroller/team/date'));
		
		$order=($field=='name')?'asc':'desc';
		
		$data['blog']=$this->Admin_model->getAll('employee', array('field'=>$field, 'order'=>$order), $config['per_page'], $this->uri->segment(4));
		$text=$this->Admin_model->getAll('team');
		if (count($text)) $data['text']=$text[0];
		//$data['pagination']=$this->pagination->create_links();
		$spec = $this->Admin_model->getAll('spec', array('field'=>'name', 'order'=>'asc'));
		foreach($spec as $val){
			$data['spec'][$val['id']]=$val['name'];
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu');
		$this->load->view('team/team', $data);
		$this->load->view('templates/footer');
	}
	
	public function teamspec($action=null, $id=null){
		if($action=='add'){
			$this->input->post(NULL, TRUE);
			$arr=$this->input->post();
			$this->Admin_model->insert('spec', $arr);
		}
		if($action=='update'){
			$this->input->post(NULL, TRUE);
			$arr=$this->input->post();
			$this->Admin_model->update('spec', $id, $arr);
		}
		if($action=='delete'){
			$this->Admin_model->delete('spec', $id);
		}
		$data['spec']=$this->Admin_model->getAll('spec', array('field'=>'name', 'order'=>'asc'));
		echo $this->load->view('team/teamspec', $data, true);
	}

	public function employee($action='add', $id=null){
		$data['title'] = 'Добавить/изменить запись';
		if($action=='edit'){
			$this->input->post(NULL, TRUE);
			$arr=$this->input->post();
			if($arr['id']=='') unset($arr['id']);
			if($id)
				if(count($this->Admin_model->getRow('employee', $id))==0)
					redirect(site_url('admincontroller/team'));
			
			$this->form_validation->set_rules('name', 'Имя', 'trim|htmlspecialchars|required|max_length[255]');
			$this->form_validation->set_rules('spec_id', 'Специальность', 'required');
			$this->form_validation->set_rules('qualification', 'Квалификация', 'trim|htmlspecialchars|required|max_length[255]');
			
			if ($this->form_validation->run() === FALSE){
				$data['employee']=($arr) ? $arr : $this->Admin_model->getRow('employee', $id);
				$data['spec'] = $this->Admin_model->getAll('spec', array('field'=>'name', 'order'=>'asc'));
				if($id){
					$data['terms'] = $this->Admin_model->getWhere('terms', array('field'=>'eployee_id', 'value'=>$id));
					$data['portfolio'] = $this->Admin_model->getWhere('portfolio', array('field'=>'eployee_id', 'value'=>$id));
				}
				
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu');
				$this->load->view('templates/tinymce');
				$this->load->view('team/employee', $data);
				$this->load->view('templates/footer');
				return;
			}
			else{
				if ($_FILES && $_FILES['photo']['error']!=4){
					//list($size['width'], $size['height']) = getimagesize($_FILES['photo']['tmp_name']);
					//var_dump($_FILES);
					//exit;
					if(!$id && empty($arr['id'])) $id=$this->Admin_model->getMaxID('employee');
					if(!empty($arr['id'])) $id=$arr['id'];
					$path='./'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_employee_path').$id;
					$photo=$this->Admin_model->getRow('employee', $id)['photo'];
					if($photo)
						$name=$photo;
					else
						$name='empl_'.random_string('unique');
					$result=$this->do_upload($path, 'photo', $name, $overwrite=true, $delete=false);
					if(isset($result['error'])){
						$this->getError(array('error'=>$result['error']));
						return;
					}
					$res=$this->makeThumb('ava', $result['full_path'], array('width'=>$result['image_width'], 'height'=>$result['image_height']));
					if(!$res){
						$this->getError(array('error'=>'Ошибка в Image Manipulation Class'));
						return;
					}
				}
				if(!isset($arr['id']) || $arr['id']===''){
					unset($arr['id']);
					if($result['file_name']) $arr['photo']=$result['file_name'];
					$this->Admin_model->insert('employee', $arr);
					$id=$this->db->insert_id();
				}
				else{
					unset($arr['term_text']);
					if($result['file_name']) $arr['photo']=$result['file_name'];
					//var_dump($arr);
					//exit;
					$this->Admin_model->update('employee', $arr['id'], $arr);
					$id=$arr['id'];
				}
				redirect(site_url('admincontroller/employee/edit').'/'.$id);
			}
		}
		$data['spec'] = $this->Admin_model->getAll('spec', array('field'=>'name', 'order'=>'asc'));
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu');
		$this->load->view('templates/tinymce');
		$this->load->view('team/employee', $data);
		$this->load->view('templates/footer');
	}
	
	public function terms($action=null, $id=null, $employee=null){
		if($action=='add'){
			$this->input->post(NULL, TRUE);
			$arr=$this->input->post();
			$this->Admin_model->insert('terms', $arr);
		}
		if($action=='update'){
			$this->input->post(NULL, TRUE);
			$arr=$this->input->post();
			$this->Admin_model->update('terms', $id, $arr);
		}
		if($action=='delete'){
			$this->Admin_model->delete('terms', $id);
		}
		$data['terms']=$this->Admin_model->getWhere('terms', array('field'=>'eployee_id', 'value'=>$employee));
		$data['employee']=$employee;
		//var_dump($action);
		//var_dump($id);
		//var_dump($employee);
		//var_dump($employee);
		echo $this->load->view('team/terms', $data, true);
	}

	public function mensclubgallery($action='add', $id=null){
		$data['title'] = 'Добавить/изменить запись';
		
		$data['mensclubgallery'] = $this->Admin_model->getAll('mensclubgallery');
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu');
		//$this->load->view('templates/tinymce');
		$this->load->view('mensclubgallery/mensclubgallery', $data);
		$this->load->view('templates/footer');
	}
	
	public function cert($field='all'){
		$data['title'] = 'Сертификаты';
		
		$config['base_url'] = site_url('admincontroller/cert').'/'.$field;
		$config['per_page'] = $this->Admin_model->getConParam('admin_item_per_page');
		$config['uri_segment'] = 4;
		
		if ($field=='all'){
			$data['certificates']=$this->Admin_model->getAll('certificates', array('field'=>'price', 'order'=>'asc'), $config['per_page'], $this->uri->segment(4));
			$config['total_rows'] = $this->db->count_all('certificates');
		}
		else{
			$filter=$this->Admin_model->getRow('certfilter', $field);
			//$where=$this->input->post();
			$data['certificates']=$this->Admin_model->getBetween('certificates', array('field'=>'price', 'min'=>$filter['min'], 'max'=>$filter['max']), $config['per_page'], $this->uri->segment(4));
			$config['total_rows'] = $this->Admin_model->getBetweenCount('certificates', array('field'=>'price', 'min'=>$filter['min'], 'max'=>$filter['max']));
		}
		$data['certfilter']=$this->Admin_model->getAll('certfilter', array('field'=>'min', 'order'=>'asc'));

		$data['total']=$config['total_rows'];
		$this->pagination->initialize($config);
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu');
		$this->load->view('certificates/cert', $data);
		$this->load->view('templates/footer');
	}
	
	public function certFilter($action=null, $id=null){
		if($action=='add'){
			$this->input->post(NULL, TRUE);
			$arr=$this->input->post();
			$this->Admin_model->insert('certfilter', $arr);
		}
		if($action=='update'){
			$this->input->post(NULL, TRUE);
			$arr=$this->input->post();
			$this->Admin_model->update('certfilter', $id, $arr);
		}
		if($action=='delete'){
			$this->Admin_model->delete('certfilter', $id);
		}
		$data['certfilter']=$this->Admin_model->getAll('certfilter', array('field'=>'min', 'order'=>'asc'));
		echo $this->load->view('certificates/certfilter', $data, true);
	}

	public function certrecord($action='add', $id=null){
		$data['title'] = 'Добавить/изменить сертификат';
		if($action=='edit'){
			$this->input->post(NULL, TRUE);
			$arr=$this->input->post();
			if($arr['id']=='') unset($arr['id']);
			if($id)
				if(count($this->Admin_model->getRow('certificates', $id))==0)
					redirect(site_url('admincontroller/cert'));
			
			$this->form_validation->set_rules('name', 'имя', 'trim|htmlspecialchars|required|max_length[255]');
			$this->form_validation->set_rules('price', 'цена', 'trim|htmlspecialchars|is_natural_no_zero|required');
			$this->form_validation->set_rules('text', 'текст', 'trim|htmlspecialchars|required|max_length[1024]');
			
			if ($this->form_validation->run() === FALSE){
				$data['certificates']=($arr) ? $arr : $this->Admin_model->getRow('certificates', $id);
				
				$this->load->view('templates/header', $data);
				$this->load->view('templates/menu');
				$this->load->view('templates/tinymce');
				$this->load->view('certificates/certrecord', $data);
				$this->load->view('templates/footer');
				return;
			}
			else{
				if ($_FILES && $_FILES['photo']['error']!=4){
					//list($size['width'], $size['height']) = getimagesize($_FILES['photo']['tmp_name']);
					//var_dump($_FILES);
					//exit;
					if(!$id && empty($arr['id'])) $id=$this->Admin_model->getMaxID('certificates');
					if(!empty($arr['id'])) $id=$arr['id'];
					$path='./'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_certificates_path').$id;
					$photo=$this->Admin_model->getRow('certificates', $id)['photo'];
					if($photo)
						$name=$photo;
					else
						$name='cert_'.random_string('unique');
					$result=$this->do_upload($path, 'photo', $name, $overwrite=true, $delete=false);
					if(isset($result['error'])){
						$this->getError(array('error'=>$result['error']));
						return;
					}
					$res=$this->makeThumb('ava', $result['full_path'], array('width'=>$result['image_width'], 'height'=>$result['image_height']));
					if(!$res){
						$this->getError(array('error'=>'Ошибка в Image Manipulation Class'));
						return;
					}
				}
				if(!isset($arr['id']) || $arr['id']===''){
					unset($arr['id']);
					if($result['file_name']) $arr['photo']=$result['file_name'];
					$this->Admin_model->insert('certificates', $arr);
					$id=$this->db->insert_id();
				}
				else{
					//unset($arr['term_text']);
					if($result['file_name']) $arr['photo']=$result['file_name'];
					//var_dump($arr);
					//exit;
					$this->Admin_model->update('certificates', $arr['id'], $arr);
					$id=$arr['id'];
				}
				redirect(site_url('admincontroller/certrecord/edit').'/'.$id);
			}
		}
		//$data['spec'] = $this->Admin_model->getAll('spec', array('field'=>'name', 'order'=>'asc'));
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu');
		$this->load->view('templates/tinymce');
		$this->load->view('certificates/certrecord', $data);
		$this->load->view('templates/footer');
	}
	
	public function orders($field='all', $order='date'){
		$data['title'] = 'Заказы';
		$data['status']=$this->Admin_model->getAll('status', array('field'=>'id', 'order'=>'asc'));
		$sort=($order=='date')?'desc':'asc';
		
		$config['base_url'] = site_url('admincontroller/orders').'/'.$field.'/'.$order;
		$config['per_page'] = $this->Admin_model->getConParam('admin_item_per_page');
		$config['uri_segment'] = 5;
		
		if ($field=='all'){
			$data['orders']=$this->Admin_model->getAll('order', array('field'=>$order, 'order'=>$sort), $config['per_page'], $this->uri->segment(5));
			$config['total_rows'] = $this->db->count_all('order');
		}
		else{
			$data['orders']=$this->Admin_model->getWhere('order', array('field'=>'status_id', 'value'=>$field), $config['per_page'], $this->uri->segment(5), array($order, $sort));
			$config['total_rows'] = $this->Admin_model->getWhereCount('order', array('field'=>'status_id', 'value'=>$field));
		}

		$data['total']=$config['total_rows'];
		$this->pagination->initialize($config);
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu');
		$this->load->view('orders/orders', $data);
		$this->load->view('templates/footer');
	}

	public function order($act='edit', $id){
		//if($act=='edit'){
		if($id)
			if(count($this->Admin_model->getRow('order', $id))==0)
				redirect(site_url('admincontroller/orders'));
		
		$this->form_validation->set_rules('notes', 'Заметки оператора', 'trim|htmlspecialchars|max_length[1024]');
		
		if ($this->form_validation->run() === FALSE){
			$data['status']=$this->Admin_model->getAll('status', array('field'=>'id', 'order'=>'asc'));
			$data['order']=$this->Admin_model->getRow('order', $id);
			$data['title'] = 'Заказ #'.$data['order']['id'];
			$this->load->view('templates/header', $data);
			$this->load->view('templates/menu');
			$this->load->view('orders/order', $data);
			$this->load->view('templates/footer');
		}
		else{
			$this->input->post(NULL, TRUE);
			$this->Admin_model->update('order', $id, $this->input->post());
			//var_dump($this->input->post());
			redirect(site_url('admincontroller/order/edit').'/'.$id);
		}
		//}
	}
	
	public function changestatus($table, $id, $statusid){
		$data['status']=$this->Admin_model->getAll('status', array('field'=>'id', 'order'=>'asc'));
		if($table=='order'){
			$this->Admin_model->update($table, $id, array('status_id'=>$statusid));
			$data['orders']=$this->Admin_model->getRow('order', $id);
			echo $this->load->view('orders/orderrow', $data);
		}
	}

	public function changenotes($table, $id){
		$this->input->post(null, true);
		$this->Admin_model->update($table, $id, $this->input->post());
		echo $this->input->post('notes');
	}

	public function mail(){
		$this->input->post(null, true);
		
		$this->load->library('email');
		
		//$config['protocol']='smtp';
		//$config['smtp_host']='ssl://smtp.your.host';
		//$config['smtp_user']='Your_user_name';
		//$config['smtp_pass']='Your_password';
		//$config['smtp_port']='465';
		//$config['smtp_timeout']='30';
		//$this->email->initialize($config);

		$this->email->from('YOLO@gmail.com', 'You Only Live Once');
		$this->email->to($this->input->post('email'));

		$this->email->subject($this->input->post('subject'));
		$this->email->message($this->input->post('text'));

		if(!$this->email->send()){
			echo $this->email->print_debugger();
		}
		else{
			echo 'Письмо успешно отправлено на '.$this->input->post('email');
		}
	}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

	public function config(){
		$data['title'] = 'Настройки';
		//$data['cart']=$this->session->userdata('cart');

		$this->form_validation->set_rules('img_base_path', 'Укажите путь', 'trim|htmlspecialchars|required|max_length[255]');
		$this->form_validation->set_rules('img_mainpage_path', 'Укажите путь', 'trim|htmlspecialchars|required|max_length[255]');
		$this->form_validation->set_rules('img_mansclub_path', 'Укажите путь', 'trim|htmlspecialchars|required|max_length[255]');
		$this->form_validation->set_rules('img_blog_path', 'Укажите путь', 'trim|htmlspecialchars|required|max_length[255]');
		$this->form_validation->set_rules('img_employee_path', 'Укажите путь', 'trim|htmlspecialchars|required|max_length[255]');
		$this->form_validation->set_rules('img_certificates_path', 'Укажите путь', 'trim|htmlspecialchars|required|max_length[255]');
		$this->form_validation->set_rules('img_per_page_portfolio', 'Укажите число', 'trim|htmlspecialchars|required|integer');
		$this->form_validation->set_rules('img_per_page_mensclub', 'Укажите число', 'trim|htmlspecialchars|required|integer');
		$this->form_validation->set_rules('img_thumb_width', 'Укажите число', 'trim|htmlspecialchars|required|integer');
		$this->form_validation->set_rules('img_thumb_height', 'Укажите число', 'trim|htmlspecialchars|required|integer');
		$this->form_validation->set_rules('img_employee_size', 'Укажите число', 'trim|htmlspecialchars|required|integer');
		$this->form_validation->set_rules('admin_item_per_page', 'Укажите число', 'trim|htmlspecialchars|required|integer|max_length[3]');
		$this->form_validation->set_rules('front_item_per_page', 'Укажите число', 'trim|htmlspecialchars|required|integer|max_length[3]');
		if(isset($this->input->post()['changeadmin'])){
			$this->form_validation->set_rules('admin', 'Имя пользователя', 'trim|required|min_length[4]|max_length[45]');
			$this->form_validation->set_rules('adminpass', 'Пароль', 'required|matches[adminpassc]');
			$this->form_validation->set_rules('adminpassc', 'Подтвердите пароль', 'required');
		}
		//$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		//$this->form_validation->set_rules('address', 'Адрес доставки', 'callback_deltypeCheck');
		
		//var_dump($this->input->post());
		//exit;

		if ($this->form_validation->run() === FALSE){
			$data['config'] = $this->Admin_model->getAll()[0];
			$this->load->view('templates/header', $data);
			$this->load->view('templates/menu');
			$this->load->view('config', $data);
			$this->load->view('templates/footer');
		}
		else {
			$data['sesconfig'] = 'Конфигурация успешно изменена';
			$this->input->post(NULL, TRUE);
			$arr=$this->input->post();
			unset($arr['submit']);
			if(isset($arr['order_send_confirm'])) $arr['order_send_confirm']=1;
			else $arr['order_send_confirm']=0;
			if(isset($arr['changeadmin'])){
				unset($arr['adminpassc']);
				unset($arr['changeadmin']);
				$arr['adminpass']=$this->crypt->generateHash($arr['adminpass']);
			}
			$this->Admin_model->setConfig($arr);
			$data['config'] = $this->Admin_model->getAll()[0];
			$this->load->view('templates/header', $data);
			$this->load->view('templates/menu');
			$this->load->view('config', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function do_upload($path, $field, $name, $overwrite=true, $delete=true){
		$config['upload_path'] = $path;
		$config['file_name'] = $name;
		$config['overwrite'] = $overwrite;
		$config['allowed_types'] = 'jpg|jpeg|png';
		
		if(!is_dir($path)){
			mkdir($path);
		}
		else{
			if($delete) delete_files($path);
		}

		$this->upload->initialize($config);

		if (!$this->upload->do_upload($field)){
			return array('error'=>$this->upload->display_errors());
		}
		else{
			return $this->upload->data();
		}
	}
	
	public function uploadMultiple($path, $field, $nameprefix='', $overwrite=false, $delete=false){
		$imgnum=1;
		foreach($_FILES[$field] as $key=>$val){
			$i=0;
			foreach($val as $item){
				$res[$i][$key]=$item;
				$i++;
			}
		}
		//return $_FILES;
		unset($_FILES);
		foreach($res as $val){
			$_FILES[$field]=$val;
			$name=$nameprefix.random_string('unique');
			//var_dump($name);
			$result=$this->do_upload($path, $field, $name, $overwrite, $delete);
			//var_dump($result);
			//return $result;
			if(!isset($result['error'])) $upfiles[]=$result['file_name'];
			if(isset($result['error'])){
				$result['num']=$imgnum;
				if(!empty($upfiles))
					foreach($upfiles as $val) unlink($path.$val);
				return $result;
			}
			$resarr[]=$result;
			$imgnum++;
		}
		return $resarr;
		//var_dump($res);
		//return;
	}
	
	public function makeThumb($mode='thumb', $path, $size){
		$this->image_lib->clear();
		unset($config);
		$config['source_image'] = $path;
		if ($mode=='ava'){
			if($size['width']!=$size['height']){
				if($size['width']>$size['height']){
					$config['x_axis']=($size['width']-$size['height'])/2;
					$config['y_axis']=0;
					$size['width']=$size['height'];
				}
				else{
					$config['x_axis']=0;
					$config['y_axis']=($size['height']-$size['width'])/2;
					$size['height']=$size['width'];
				}
				$config['width'] = $size['width'];
				$config['height'] = $size['height'];
				$config['maintain_ratio'] = false;
				
				$this->image_lib->initialize($config);
				$this->image_lib->crop();
			}
			$dim=$this->Admin_model->getConParam('img_employee_size');
			$config['width'] = $dim;
			$config['height'] = $dim;
			$config['maintain_ratio'] = true;
			
			$this->image_lib->initialize($config);
			return $this->image_lib->resize();
		}
		if ($mode=='thumb'){
			$tc=false;
			list($width, $height)=getimagesize($path);
			if($width/$height!=$size['width']/$size['height']){
				if ($width/$height>$size['width']/$size['height']){
					$widthnew=$height*$size['width']/$size['height'];
					$config['x_axis']=($width-$widthnew)/2;
					$config['y_axis']=0;
					$config['width'] = $widthnew;
					$config['height'] = $height;
				}
				elseif ($width/$height<$size['width']/$size['height']){
					$heightnew=$width/($size['width']/$size['height']);
					$config['x_axis']=0;
					$config['y_axis']=($height-$heightnew)/2;
					$config['width'] = $width;
					$config['height'] = $heightnew;
				}
				$config['maintain_ratio'] = false;
				$replace=preg_replace('/\.\w+/i', '', basename($path));
				$path=str_replace($replace, $replace.'_thumb', $path);
				//var_dump(basename($path));
				//exit;
				$config['new_image'] = basename($path);
				$this->image_lib->initialize($config);
				$this->image_lib->crop();
				unset($config);
				$this->image_lib->clear();
				$config['source_image'] = $path;
				$tc=true;
			}
			$config['width'] = $size['width'];
			$config['height'] = $size['height'];
			$config['maintain_ratio'] = true;
			if(!$tc){
				$replace=preg_replace('/\.\w+/i', '', basename($path));
				$path=str_replace($replace, $replace.'_thumb', $path);
				$config['new_image'] = basename($path);
			}
			$this->image_lib->initialize($config);
			return $this->image_lib->resize();
		}
	}
	
	public function getError($msg){
		$data['title']='Ошибка';
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu');
		$this->load->view('error', $msg);
		$this->load->view('templates/footer');
	}
	
	public function deletePage($table, $id, $ajax=false, $content=false){
		if ($ajax=='true'){
			//echo 'ajax';
			$arr=$this->input->post();
			if(isset($arr['deleteFiles'])){
				unlink($arr['deleteFiles']);
				$replace=preg_replace('/\.\w+/i', '', basename($arr['deleteFiles']));
				$path=str_replace($replace, $replace.'_thumb', $arr['deleteFiles']);
				if(is_file($path)) unlink($path);
			}
			return $this->Admin_model->delete($table, $id);
		}
		if ($content=='true'){
			//echo 'ajax';
			$path='./'.$this->Admin_model->getConParam('img_base_path').$table.'/'.$id;
			if (is_dir($path)){
				delete_files($path);
				rmdir($path);
			}
		}
		//var_dump($ajax);
		//var_dump($content);
		//var_dump($id);
		//exit;
		$this->Admin_model->delete($table, $id);
		redirect($_SERVER["HTTP_REFERER"]);
	}
	
	public function deleteBatch($table, $ajax=false){
		$this->input->post(NULL, TRUE);
		$this->deletePage($table, array_values($this->input->post()), $ajax);
	}
	
	public function deleteBatchEmpl($table, $conparam='img_employee_path'){
		$this->input->post(NULL, TRUE);
		//var_dump(array_values($this->input->post()));
		$ids=array_values($this->input->post());
		$path='./'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam($conparam);
		foreach($ids as $val){
			if (is_dir($path.$val)){
				delete_files($path.$val);
				rmdir($path.$val);
			}
		}
		//exit;
		$this->deletePage($table, $ids, false);
	}
	
	public function deleteBatchPortfolio(){
		$this->input->post(NULL, TRUE);
		$path='./'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_employee_path').$this->input->post('eployee_id').'/';
		unset($_POST['eployee_id']);
		$res=$this->Admin_model->getWhere('portfolio', array('field' => 'id', 'value' => array_values($this->input->post())));
		foreach($res as $val){
			//echo('is file: '.is_file($path.$val['path']));
			if (is_file($path.$val['path'])) unlink($path.$val['path']);
			if (is_file($path.$val['thumb'])) unlink($path.$val['thumb']);
		}
		$this->deletePage('portfolio', array_values($this->input->post()));
	}
	
	public function deleteBatchMensClub(){
		$this->input->post(NULL, TRUE);
		$path='./'.$this->Admin_model->getConParam('img_base_path').$this->Admin_model->getConParam('img_mansclub_path');
		$res=$this->Admin_model->getWhere('mensclubgallery', array('field' => 'id', 'value' => array_values($this->input->post())));
		foreach($res as $val){
			//echo('is file: '.is_file($path.$val['path']));
			if (is_file($path.$val['path'])) unlink($path.$val['path']);
			if (is_file($path.$val['thumb'])) unlink($path.$val['thumb']);
		}
		$this->deletePage('mensclubgallery', array_values($this->input->post()));
	}
	
	public function changePage($id){
		$arr['text']=trim(htmlspecialchars($this->input->post('text', true)));
		try{
			$this->Admin_model->update('mainpage', $id, $arr);
			echo $arr['text'];
		}
		catch(Exception $e){
			echo('Ошибка при записи в базу данных: '.$e->getMessage());
		}
	}
	
	public function changeField($table, $field='text', $id=null, $ajax=false){
		$arr[$field]=trim(htmlspecialchars($this->input->post($field, true)));
		try{
			if ($id) $this->Admin_model->update($table, $id, $arr);
			else $this->Admin_model->insert($table, $arr);
			if ($ajax) echo $arr[$field];
			else redirect ($_SERVER["HTTP_REFERER"]);
		}
		catch(Exception $e){
			echo('Ошибка при записи в базу данных: '.$e->getMessage());
		}
	}
}