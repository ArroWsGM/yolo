<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		/*
		 * Localization
		 */
		//setlocale(LC_TIME, 'russian');
		//setlocale(LC_ALL, 'ru_RU.UTF-8');
		
		$this->load->model('Page_model');
		
		$this->load->helper(array(	'url',
									'form',
									'date',
									'custom',
									'string'));
		
		$this->load->library(array(	'form_validation',
									'pagination'));
	}

	public function main(){
		//$data['product'] = $this->Page_model->get_product();
		$data['title'] = 'You Only Live Once';
		$data['total'] = $this->db->count_all('mainpage');
		$data['mainpage']=$this->Page_model->getAll('mainpage');
		//$data['cart']=$this->session->userdata('cart');

		$this->load->view('templates/header', $data);
		$this->load->view('main', $data);
		$this->load->view('templates/footer');
	}
	
	public function team($specid=null){
		$spec = $this->Page_model->getAll('spec', array('field'=>'name', 'order'=>'asc'));
		foreach($spec as $val){
			$data['spec'][$val['id']]=$val['name'];
		}
		if ($specid!==null){
			if ($specid=='all'){
				$data['currspec']='Все';
				$data['employee']=$this->Page_model->getAll('employee', array('field'=>'name', 'order'=>'asc'));
				echo $this->load->view('teamleft', $data, true);
				return;
			}
			else{
				$data['currspec']=$data['spec'][$specid];
				$data['employee']=$this->Page_model->getWhere('employee', array('field'=>'spec_id', 'value'=>$specid), null, null, 'asc');
				echo $this->load->view('teamleft', $data, true);
				return;
			}
		}
		$data['title'] = 'You Only Live Once';
		$data['about']=$this->Page_model->getRow('team', 1);

		$data['employee']=$this->Page_model->getAll('employee', array('field'=>'name', 'order'=>'asc'));
		$this->load->view('templates/header', $data);
		$this->load->view('team', $data);
		$this->load->view('templates/footer');
	}

	public function employee($id){
		//$data['portfolio']=
		$data['employee']=$this->Page_model->getEmpl($id);
		//$data['spec'] = $this->Page_model->getWhere('spec', array('field'=>'id', 'value'=>$data['employee']['spec_id']));

		echo $this->load->view('templ', $data, true);
	}

	public function portfolio($id){
		$data['id']=$id;
		$config['base_url'] = site_url("page/portfolio/".$id);
		$config['per_page'] = $this->Page_model->getConParam('img_per_page_portfolio');
		$config['uri_segment'] = 4;
		$config['total_rows'] = $this->Page_model->getWhereCount('portfolio', array('field'=>'eployee_id', 'value'=>$id));
		//var_dump($config['total_rows']);
		$data['portfolio']=$this->Page_model->getWhere('portfolio', array('field'=>'eployee_id', 'value'=>$id), $config['per_page'], $this->uri->segment(4));
		$data['total']=$config['total_rows'];
		$this->pagination->initialize($config);

		echo $this->load->view('tportfolio', $data, true);
	}
	
	public function checkout($table=null){
		$this->input->post(null, true);
		$post=$this->input->post();
		//if($post) var_dump($post);
		$data=null;
		
		$this->form_validation->set_rules('name', 'Имя', 'trim|htmlspecialchars|required|min_length[5]|max_length[100]');
		$this->form_validation->set_rules('email', 'e-Mail', 'trim|htmlspecialchars|required|valid_email');
		$this->form_validation->set_rules('phone', 'Телефон', 'trim|htmlspecialchars|required|callback_phone_check');
		$this->form_validation->set_rules('text', 'Текст', 'trim|htmlspecialchars|required|min_length[4]');
		
		if ($this->form_validation->run() === FALSE){
			if($post){
				$response['error']=true;
				$response['view']=($table=='feedback')?$this->load->view('feedback', $data, true):$this->load->view('checkout', $data, true);
				echo json_encode($response);
			}
			else{
				echo ($table=='feedback')?$this->load->view('feedback', $data, true):$this->load->view('checkout', $data, true);
			}
		}
		else{
			if($table=='feedback'){
				$this->Page_model->insert('feedback', $post);
				$response['error']=false;
				echo json_encode($response);
				return;
			}
			else{	
				$this->Page_model->insert('order', $post);
				$response['error']=false;
				echo json_encode($response);
				return;
			}
		}
	}

	public function phone_check($phone){
		if(preg_match('/^\+38([0-9]){10}$/i', $phone)){
			$this->form_validation->set_message('phone_check', 'Поле %s должно содержать реальный номер телефона в международном формате');
			return false;
		}
		return true;
	}
	
	public function mensclub(){
		//$data['product'] = $this->Page_model->get_product();
		$data['title'] = 'You Only Live Once';
		$data['total'] = $this->db->count_all('mensclubgallery');
		$data['mсgallery']=$this->Page_model->getAll('mensclubgallery');
		//$data['cart']=$this->session->userdata('cart');

		$this->load->view('templates/header', $data);
		$this->load->view('mensclub', $data);
		$this->load->view('templates/footer');
	}

	public function mensclubgallery(){
		$config['base_url'] = site_url("page/mensclubgallery");
		$config['per_page'] = $this->Page_model->getConParam('img_per_page_mensclub');
		$config['uri_segment'] = 3;
		$config['total_rows'] = $this->db->count_all('mensclubgallery');
		$data['mсgallery']=$this->Page_model->getAll('mensclubgallery', array('field'=>'id', 'order'=>'desc'), $config['per_page'], $this->uri->segment(3));
		$data['total']=$config['total_rows'];
		$this->pagination->initialize($config);

		echo $this->load->view('mensclubgallery', $data, true);
	}

	public function blog($id=null, $pagination=null){
		$data['title'] = 'You Only Live Once';
		$idlink=($id)?$id:0;
		//$data['product'] = $this->Page_model->get_product();
		$config['base_url'] = site_url("page/blog/$idlink/getpage");
		$config['per_page'] = $this->Page_model->getConParam('front_item_per_page');
		$config['uri_segment'] = 5;
		$config['total_rows'] = $this->db->count_all('blog');
		//$data['cart']=$this->session->userdata('cart');
		if($id){
			$data['id']=$id;
			$data['blog']=$this->Page_model->getRow('blog', $id);
			echo $this->load->view('blogtext', $data, true);
			return;
		}
		else
			$data['blog']=$this->Page_model->getAll('blog', array('field'=>'date', 'order'=>'desc'), $config['per_page'], $this->uri->segment(5));

		$this->pagination->initialize($config);
		if ($pagination=='getpage'){
			echo $this->load->view('blogleft', $data, true);
			return;
		}
		$this->load->view('templates/header', $data);
		$this->load->view('blog', $data);
		$this->load->view('templates/footer');
	}
	
	public function cert($cfid=null){
		$cf = $this->Page_model->getAll('certfilter', array('field'=>'min', 'order'=>'asc'));
		$i=0;
		foreach($cf as $val){
			$data['cf'][$i]['id']=$val['id'];
			$data['cf'][$i]['name']=$val['name'];
			$data['cf'][$i]['min']=$val['min'];
			$data['cf'][$i]['max']=$val['max'];
			$i++;
		}
		if ($cfid!==null){
			if ($cfid=='all'){
				$data['currcf']='Сертификаты';
				$data['cert']=$this->Page_model->getAll('certificates', array('field'=>'price', 'order'=>'asc'));
				echo $this->load->view('certleft', $data, true);
				return;
			}
			else{
				$this->input->post(null, true);
				$data['currcf']=$this->input->post('name');
				$data['cert']=$this->Page_model->getBetween('certificates', array('field'=>'price', 'min'=>$this->input->post('min'), 'max'=>$this->input->post('max')));
				echo $this->load->view('certleft', $data, true);
				return;
			}
		}
		$data['title'] = 'You Only Live Once';

		$data['cert']=$this->Page_model->getAll('certificates', array('field'=>'price', 'order'=>'asc'));
		$this->load->view('templates/header', $data);
		$this->load->view('cert', $data);
		$this->load->view('templates/footer');
	}
	
	public function certtext($id=null){
		$data['cert']=$this->Page_model->getRow('certificates', $id);
		echo $this->load->view('certtext', $data, true);
		return;
	}
	
	public function partner(){
		$data['title'] = 'You Only Live Once';

		$this->load->view('templates/header', $data);
		$this->load->view('partner', $data);
		$this->load->view('templates/footer');
	}
	
	public function contacts(){
		$data['title'] = 'You Only Live Once';

		$this->load->view('templates/header', $data);
		$this->load->view('contacts', $data);
		$this->load->view('templates/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */