<?
class calendario extends CI_Controller
{
    /***************FULL CALENDAR****************** */
    function __construct(){
        parent::__construct();
        $this->load->model('modelo_calendario', 'mc');
        $this->load->library(array('form_validation','session', 'pagination'));
        $this->load->database();
    }
    public function index(){
        $data['result'] = $this->mc->get_event_list();
        foreach ($data['result'] as $key => $value) {
            $data['data'][$key]['title'] = $value->title;
            $data['data'][$key]['start'] = $value->start_date;
            $data['data'][$key]['end'] = $value->end_date;
            $data['data'][$key]['backgroundColor'] = "#00a65a";

        }
        $this->load->view('vista_calendario', $data);
    }
    public function save(){
        $this->form_validation->set_rules('title','title','required');
        $this->form_validation->set_rules('start_date', 'start_date', 'required');
        $this->form_validation->set_rules('end_date', 'end_date', 'required');

        if($this->form_validation->run() == false){
           $this->load->view('vista_calendario');
        }else{
            $data = array(
                'title' =>$this->input->post('title'),
                'start_date'=>$this->input->post('start_date'),
                'end_date'=>$this->input->post('end_date'),
            );
            $this->mc->insert($data);
            $this->session->set_flashdata('success', 'El evento: '.$data["title"].'ha sido agregado');
            redirect(INDEX_CP.'vista_calendario');
        }
    }
    public function list_all(){
        $config = [
            'base_url' =>base_url(INDEX_CP).'/calendario_eventos',
            'per_page'=> 10,
            'total_rows'=> $this->mc->num_rows(),
        ];
        $this->pagination->initialize($config);
        $events = $this->mc->list_all($config['per_page'], $this->uri->segment(3));
        //$vdata['vdata'] = $this->mc->list_all();
        $this->load->view('vista_eventos',['events'=>$events] );
    }
    public function delete_data(){
      /* $id =  $this->input->get('id');
       if($this->mc->delete_data($id)){
           $data['events'] = $this->mc->list_all();
           $this->load->view('vista_eventos', $data);
       }**/
      if($this->mc->delete_data()) {
        redirect(INDEX_CP.'vista_calendario');
      }
       

    }
    
}
