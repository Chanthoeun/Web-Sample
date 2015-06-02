<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_ion_auth extends CI_Migration {

	public function up()
	{
            // set default engine
            $this->db->query('SET storage_engine=MYISAM;');
            
            // Drop table 'groups' if it exists
            if($this->db->table_exists('groups'))
            {
                $this->dbforge->drop_table('groups');
            }

            // Table structure for table 'groups'
            $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'MEDIUMINT',
                            'constraint' => '8',
                            'unsigned' => TRUE,
                            'auto_increment' => TRUE
                    ),
                    'name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '20',
                    ),
                    'description' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '100',
                    ),
                    'created_at' => array(
                        'type'  => 'INT',
                        'constraint' => '11'
                    ),
                    'updated_at' => array(
                        'type'  => 'INT',
                        'constraint' => '11'
                    ),
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('groups');

            // Dumping data for table 'groups'
            $data = array(
                    array(
                        'id' => '1',
                        'name' => 'admin',
                        'description' => 'Administrator',
                        'created_at' => time(),
                        'updated_at' => time()
                    ),
                    array(
                        'id' => '2',
                        'name' => 'members',
                        'description' => 'General User',
                        'created_at' => time(),
                        'updated_at' => time()
			)
            );
            $this->db->insert_batch('groups', $data);


            // Drop table 'users' if it exists
            if($this->db->table_exists('users'))
            {
                $this->dbforge->drop_table('users');
            }
            

            // Table structure for table 'users'
            $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'MEDIUMINT',
                            'constraint' => '8',
                            'unsigned' => TRUE,
                            'auto_increment' => TRUE
                    ),
                    'ip_address' => array(
                            'type' => 'VARBINARY',
                            'constraint' => '16'
                    ),
                    'username' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '100',
                    ),
                    'password' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '80',
                    ),
                    'salt' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '40'
                    ),
                    'email' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '100'
                    ),
                    'activation_code' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '40',
                            'null' => TRUE
                    ),
                    'forgotten_password_code' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '40',
                            'null' => TRUE
                    ),
                    'forgotten_password_time' => array(
                            'type' => 'INT',
                            'constraint' => '11',
                            'unsigned' => TRUE,
                            'null' => TRUE
                    ),
                    'remember_code' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '40',
                            'null' => TRUE
                    ),
                    'created_on' => array(
                            'type' => 'INT',
                            'constraint' => '11',
                            'unsigned' => TRUE,
                    ),
                    'last_login' => array(
                            'type' => 'INT',
                            'constraint' => '11',
                            'unsigned' => TRUE,
                            'null' => TRUE
                    ),
                    'active' => array(
                            'type' => 'TINYINT',
                            'constraint' => '1',
                            'unsigned' => TRUE,
                            'null' => TRUE
                    )

            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('users');

            // Dumping data for table 'users'
            $data = array(
                    'id' => '1',
                    'ip_address' => 0x7f000001,
                    'username' => 'administrator',
                    'password' => '$2y$07$QYs5LROz2ygPxxw.NnHLxutxFcslv9GoDhZxahmPZhmmLTZvF6ITu', // without salt : $2y$08$7gfsTb1O2sjcP0VEELr.WOvL5sTNoljSa4bp6eDtYfx3Ljo9joPBO
                    'salt' => '9462e8eee0',
                    'email' => 'admin@admin.com',
                    'activation_code' => '',
                    'forgotten_password_code' => NULL,
                    'created_on' => '1268889823',
                    'last_login' => '1268889823',
                    'active' => '1'
            );
            $this->db->insert('users', $data);


            // Drop table 'users_groups' if it exists
            if($this->db->table_exists('users_groups'))
            {
                $this->dbforge->drop_table('users_groups');
            }
            

            // Table structure for table 'users_groups'
            $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'MEDIUMINT',
                            'constraint' => '8',
                            'unsigned' => TRUE,
                            'auto_increment' => TRUE
                    ),
                    'user_id' => array(
                            'type' => 'MEDIUMINT',
                            'constraint' => '8',
                            'unsigned' => TRUE
                    ),
                    'group_id' => array(
                            'type' => 'MEDIUMINT',
                            'constraint' => '8',
                            'unsigned' => TRUE
                    )
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('users_groups');

            // Dumping data for table 'users_groups'
            $data = array(
                    array(
                            'id' => '1',
                            'user_id' => '1',
                            'group_id' => '1',
                    )
            );
            $this->db->insert_batch('users_groups', $data);


            // Drop table 'login_attempts' if it exists
            if($this->db->table_exists('login_attempts'))
            {
                $this->dbforge->drop_table('login_attempts');
            }
            
            // Table structure for table 'login_attempts'
            $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'MEDIUMINT',
                            'constraint' => '8',
                            'unsigned' => TRUE,
                            'auto_increment' => TRUE
                    ),
                    'ip_address' => array(
                            'type' => 'VARBINARY',
                            'constraint' => '16'
                    ),
                    'login' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '100',
                            'null', TRUE
                    ),
                    'time' => array(
                            'type' => 'INT',
                            'constraint' => '11',
                            'unsigned' => TRUE,
                            'null' => TRUE
                    )
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('login_attempts');

	}

	public function down()
	{
            $this->dbforge->drop_table('users');
            $this->dbforge->drop_table('groups');
            $this->dbforge->drop_table('users_groups');
            $this->dbforge->drop_table('login_attempts');
	}
}
