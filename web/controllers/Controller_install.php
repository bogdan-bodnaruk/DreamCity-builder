<?php
class Controller_install extends Controller {
    private $host;
    private $user;
    private $pass;
    private $table;

    public function __construct() {
        parent::__construct();
        $this->registry()->config['DB-connected'] ? Go::main() : '';
        $this->registry()->main_page = 'install/main.tpl';
        $this->host = isset($_SESSION['host']) ? $_SESSION['host'] : $this->registry()->config['db_host'];
        $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : $this->registry()->config['db_user'];
        $this->pass = isset($_SESSION['pass']) ? $_SESSION['pass'] : $this->registry()->config['db_password'];
        $this->table = isset($_SESSION['table']) ? $_SESSION['table'] : $this->registry()->config['db_table'];
    }

    public function index() {
        if($_POST && $this->template()->post_is_valide()) {
            $_SESSION['host'] = $this->host = $this->template()->validate('host');
            $_SESSION['user'] = $this->user = $this->template()->validate('login');
            $_SESSION['pass'] = $this->pass = $this->template()->validate('password');
        };
        if(@mysql_connect($this->host, $this->user, $this->pass)) {
            $this->val['message'] = 'Successfully connected to mysql!';
            $this->val['link'] = 'create_db';
            $this->template()->load('install/next_step.tpl')->main();
        } else {
            $this->template()->load('install/db_connect.tpl')->main();
        };
    }

    public function create_db() {
        if(@mysql_connect($this->host, $this->user, $this->pass)) {
            if($_POST && $this->template()->post_is_valide()) {
                $_SESSION['table'] = $this->table = $this->template()->validate('table');
                mysql_query('CREATE DATABASE IF NOT EXISTS `'.$this->table.'` CHARACTER SET '.$this->registry()->config['db_encoding']);
            };
            if(@mysql_select_db($this->table)) {
                $this->val['message'] = 'Successfully connected to DB ['.$this->table.']!';
                $this->val['link'] = 'import_data';
                $this->template()->load('install/next_step.tpl')->main();
            } else {
                $this->template()->load('install/create_db.tpl')->main();
            };
        } else {
            $this->index();
        };
    }

    public function import_data() {
        if($_POST) {
            if(@mysql_connect($this->host, $this->user, $this->pass)) {
                if(@mysql_select_db($this->table)) {
                    exec('mysql -u '.$this->user.' -p'.$this->pass.' '.$this->table.' < '.$_FILES['file']['tmp_name'].'');
                    $this->val['message'] = 'Successfully imported data to DB!';
                    $this->val['link'] = 'files_permissions';
                    $this->template()->load('install/next_step.tpl')->main();
                } else {
                    Go::to('install/create_db');
                };
            } else {
                Go::to('install');
            };
        } else {
            $this->template()->load('install/import_data.tpl')->main();
        };
    }

    public function files_permissions() {
        if($_POST) {
            $paths = array('.log','uploads');
            for($i=0;$i<count($paths);$i++) {
                if(is_dir(PATH.$paths[$i])) {
                    chmod(PATH.$paths[$i], 0777);
                } else {
                    mkdir(PATH.$paths[$i]);
                    chmod(PATH.$paths[$i], 0777);
                };
            }
            $this->val['message'] = 'Successfully created folders!';
            $this->val['link'] = 'end';
            $this->template()->load('install/next_step.tpl')->main();
        }  else {
            $this->template()->load('install/files_permissions.tpl')->main();
        };
    }

    public function end() {
        if($_POST) {
            uset($_SESSION);
            Go::to('login');
        } else {
            $this->template()->load('install/end.tpl')->main();
        };
    }
}