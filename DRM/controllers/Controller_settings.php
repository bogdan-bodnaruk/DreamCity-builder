<?php
class Controller_settings extends Controller {
    function __construct() {
        parent::__construct();
        User::login()->permissions()!==99 ? Go::main() : '';
        $this->val['vals'] = array('1', '2');
        $this->val['text'] = array('No', 'Yes');
        $this->val['hours'] = array('0', 'daily', 'weekly', 'monthly');
        $this->val['text_hours'] = array('OFF', 'daily', 'weekly', 'monthly');
    }
    
    function index() {
        $this->val['db'] = $this->db()->table('config')->select()->where('`id`=1')->limit(1)->fetch();
        $this->template()->load('settings.tpl')->show();
    }
    
    function save() {        
        $this->val['db'] = $this->db()->table('config')->select()->where('`id`=1')->limit(1)->fetch();
        $this->template()->load('settings.tpl')->return_data();
        
        if(isset($_POST['auto_backup']) && $_POST['auto_backup']!=='0'){
            shell_exec('/etc/crontab -r');
            file_put_contents(PATH.'DataBase/crontab.txt', '@'.$_POST['auto_backup'].' /usr/local/bin/wget -O /dev/null -q '.$this->registry()->config['base_href'].'cron_backup/f3bd881abae9b8f23708d46812d/'.PHP_EOL);
            exec('/etc/crontab '.PATH.'DataBase/crontab.txt');
            chmod(PATH.'DataBase/crontab.txt',0777);
            unlink(PATH.'DataBase/crontab.txt');
        } elseif($_POST['auto_backup']=='0') {
            shell_exec('/etc/ crontab -r');
        };
        
        if($_POST && $this->template()->post_is_valide()) {  
            $this->db()
                 ->table('config')
                 ->update(array('title'             =>  $this->template()->validate('title'),
                              'keyword'             =>  $this->template()->validate('keyword'),
                              'description'         =>  $this->template()->validate('description'),
                              'enable'              =>  $_POST['enable'],
                              'backup_email'        =>  $this->template()->validate('backup_email'),
                              'admin_email'         =>  $this->template()->validate('admin_email'),
                              'registered_user_mail'=>  $_POST['registered_user_mail'],
                              'items_onpage'        =>  $this->template()->validate('items_onpage'),
                              'main_page'           =>  $this->template()->validate('main_page'),
                              'auto_backup'         =>  $this->template()->validate('auto_backup'),
                              'copyright'           =>  $this->template()->validate('copyright')))
                 ->where('`id`=1')
                 ->limit(1)
                 ->query();
            Logger::update($_SESSION['login'].' was changed settings');
            Go::to('settings/saved/');
        } else {
            $this->index(); 
        };
    }
    
    public function saved() {
        $this->template()->load('Saved.tpl')->show();
    }
    
    function backup() {
        $date = date("Y.m.d_H:i:s");
        $dir = './DataBase/'.$date;
        mkdir($dir);
        chmod($dir, 0777);
        
        exec('rm -f ./DataBase/*');
        
        exec("/usr/local/bin/mysqldump -u".$this->registry()->config['db_user']." -p".$this->registry()->config['db_password']
             ." -h".$this->registry()->config['db_host']." ".$this->registry()->config['db_table']." > ".$dir."/MySQL_DataBase.sql;");

        exec("/usr/local/bin/zip -r -e -P ".$this->registry()->config['zip_password']." ./DataBase/database.zip ".$dir."/");
        exec("/usr/local/bin/zip -r -e -P ".$this->registry()->config['zip_password']." ./DataBase/".$date.".zip ./interedinfo/upload");
        
		$mail = new PHPMailer();
		$mail->AddAddress($this->registry()->config['backup_email']);
		$mail->Subject = "Backup for ".$this->registry()->config['base_href'];
		$mail->Body = '<a href="'.$this->registry()->config['base_href'].'DataBase/'.$date.'.zip" target="_blank">Download backup files</a>
                       <br />This link will be available for next backup!'; 
		$mail->AddAttachment('./DataBase/database.zip', 'backup_'.$date.'.zip');
		$mail->Send();
        
		exec("rm -r ".$dir);
        exec("rm -f ./DataBase/database.zip");        
        
        $this->template()->load('<p class="success">Backup was sent to <b>'.$this->registry()->config['backup_email'].'</b></p>')->show();
    }
}