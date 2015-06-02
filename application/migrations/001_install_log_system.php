<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_log_system extends CI_Migration {

	public function up()
	{
            // set default engine
            $this->db->query('SET storage_engine=MYISAM;');
            
            // Drop table 'log' if it exists
            if($this->db->table_exists('log'))
            {
                $this->dbforge->drop_table('log');
            }

            // Table structure for table 'category'
            $this->dbforge->add_field(array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => '11',
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'who' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '150',
                ),
                'description' => array(
                    'type' => 'TEXT',
                    'null' => TRUE
                ),
                'action'  => array(
                    'type'  => 'VARCHAR',
                    'constraint' => '25'
                ),
                'created_at' => array(
                    'type'  => 'INT',
                    'constraint' => '11'
                ),
                'updated_at'   => array(
                    'type'  => 'INT',
                    'constraint' => '11'
                )

            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('log');

	}

	public function down()
	{
            $this->dbforge->drop_table('log');
	}
}


/* End of file 001_create_log_table.php */
/* Location: ./application/migrations/001_create_log_table.php */