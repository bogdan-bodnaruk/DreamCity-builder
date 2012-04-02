<?php
class User extends DRM {
    static private $login;
    static private $is_user;
    
    function __call($name, $values) {
        Logger::error('Can\'t call function ['.$name.'('.$values.')] in class User');
    }
    
    function __get($name) {
        Logger::error('Try to get access underfined value ['.$name.'] in class User');
    }
    
    function __set($name, $value) {
        Logger::error('Can\'t set any values (['.$name.'] = '.$value.') to class User');
    }
    
    static public function login($login = '') {
        self::$login = isset($_SESSION['login']) && empty($login) ? $_SESSION['login'] : $login;
        self::$is_user = parent::db()
                            ->table('users')
                            ->select('*')
                            ->where('`login` = \''.self::$login.'\'')
                            ->num(); 
        return new self();
    }
    
    public function get($data = '') {
        return $this->db()
                    ->table('users')
                    ->select($data)
                    ->where('`login` = \''.self::$login.'\'')
                    ->limit(1)
                    ->fetch();
    }
    
    public function activate($activate = 'true') {
        try {
            if(self::$is_user == 1) {
                $this->db()
                     ->table('users')
                     ->update(array('active' => $activate))
                     ->where('`login` = \''.self::$login.'\'')
                     ->limit(1)
                     ->query();
            } else {
                throw new Exception('Can\'t '.($activate == 'true' ? 'activate' : 'deactivate').' user ['.self::$login.'] because no such login in DB');  
            };
        } catch (Exception $e) {
            Logger::error($e->getMessage());
        }       
    }
    
    public function deactivate() {
        $this->activate('false');
    }
    
    static public function add($data = '') {
        if(empty($data) || !is_array($data)) {
            Logger::error('No data to add user');
        } else {
            parent::db()
                    ->table('users')
                    ->insert($data)
                    ->query();
        }
    }
    
    public function delete() {
        try {
            if(self::$is_user == 1) {
                $this->db()
                     ->table('users')
                     ->delete(self::$login)
                     ->where('`login` = \''.self::$login.'\'')
                     ->limit(1)
                     ->query();
            } else {
                throw new Exception('Can\'t delete user ['.self::$login.'] because no such login in DB');  
            };
        } catch (Exception $e) {
            Logger::error($e->getMessage());
        }    
    }
    
    public function edit($data = '') {
        try {
            if(self::$is_user == 1) {
                $this->db()
                     ->table('users')
                     ->update($data)
                     ->where('`login` = \''.self::$login.'\'')
                     ->limit(1)
                     ->query();
            } else {
                throw new Exception('Can\'t edit user ['.self::$login.'] because no such login in DB');  
            };
        } catch (Exception $e) {
            Logger::error($e->getMessage());
        }    
    }
    
    public function permissions() {
        try {
            if(self::$is_user == 1) {
                $status = $this->db()
                       ->table('users')
                       ->select('status')
                       ->where('`login` = \''.self::$login.'\'')
                       ->limit(1)
                       ->fetch();
                
                return $this->registry()->user_status[$status['status']];
            } else {
                throw new Exception('Can\'t get permissions for user ['.self::$login.'] because no such login in DB');  
            };
        } catch (Exception $e) {
            Logger::error($e->getMessage());
        }  
    }
    
    static public function count_online() {
        return parent::db()
                    ->table('users')
                    ->select('online')
                    ->where('`online`!=0')
                    ->num();
    }
}