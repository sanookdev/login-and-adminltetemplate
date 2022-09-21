<?
class Admin_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function fetch_projectAll(){
        $this->db->select('*');
        $query = $this->db->get('projects');
        return $query->result();
    }
}
?>