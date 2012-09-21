<?php
class DB extends DRM {
    private $table;
    private $query;
        
    function __call($name, $values) {
        Logger::error('Method ['.$name.'] not isset in class ['.__CLASS__.']');
    }
        
    function __get($name) {
        Logger::error('Try get acces to undefined value ['.$name.'] in class ['.__CLASS__.']');
    }
        
    function __set($name, $value) {
        Logger::error('Try to set undefined value ['.$name.'] = ['.$value.'] in class ['.__CLASS__.']');
    }
    
    public function connect() {
		try {
			$connect = @mysql_connect($this->registry()->config['db_host'],
									 $this->registry()->config['db_user'],
									 $this->registry()->config['db_password']);
            if(!$connect) {
                throw new Exception('DB is not connected');
            } else {
                $table = mysql_select_db($this->registry()->config['db_table']);
				if($table) {
					mysql_query('SET NAMES '.$this->registry()->config['db_encoding']);
					return true;
				} else {
					return false;
				};
            };
        } catch (Exception $e) {
            Logger::error($e->getMessage());
        }
    }
    
    public function table($table) {
        $this->table = $table;
        return $this;
    }
    
    public function insert($array, $escape_string = true) {
        if(count($array)>0) {
            foreach($array as $key => $value) {
				$row = empty($row) ? '`'.$key.'`' : $row.', `'.$key.'`';
                if($value == 'now()' || $value == 'NOW()') {
                    $query = empty($query) ? 'now()' : $query.', now()';
                } else {
                    $value = $escape_string == true ? mysql_escape_string($value) : $value;
                    $query = empty($query) ? '\''.$value.'\'' : $query.', \''.$value.'\'';
                };
			}
            $this->query = 'INSERT INTO `'.$this->table.'` ('.$row.') VALUES ('.$query.')';
        };
        return $this;
    }
    
    public function update($array, $escape_string = true) {
        if(count($array)>0) {
			foreach($array as $key => $value) {    
                if($value == 'now()' || $value == 'NOW()') {
                    $query = empty($query) ? '`'.$key.'`=now()' : $query.',`'.$key.'`=now()';
                } else {
                    $value = $escape_string == true ? mysql_escape_string($value) : $value;
                    $query = empty($query) ? '`'.$key.'`=\''.$value.'\'' : $query.',`'.$key.'`=\''.$value.'\'';
                };
			}
            $this->query = 'UPDATE `'.$this->table.'` SET '.$query;
		};
        return $this;
    }
    
    public function delete() {
        $this->query = 'DELETE FROM `'.$this->table.'`';
        return $this;
    }
    
    public function select($array = '') {
        $array = !empty($array) ? (array)$array : array('*');
        
        for($i=0;$i<count($array);$i++) {
            if($array[$i]=='*') { 
                $query = '*';
            } else {
                $query = empty($query) ? '`'.$array[$i].'`' : $query.', `'.$array[$i].'`';  
            };
        }
        $this->query = 'SELECT '.$query.' FROM `'.$this->table.'`';
        return $this;
    }
    
    public function query() {
        try {
            $query = mysql_query($this->query);
            if($query == false) {
                throw new Exception('MySQL error: ['.$this->table.'] #'.mysql_errno().' - '.mysql_error());
            } else {
                return $query;
            };
        } catch (Exception $e) {
            Logger::error($e->getMessage());
            die($e->getMessage());
        }
    }
    
    public function fetch() {
        return mysql_fetch_array($this->query());
    }
    
    public function num() {
        return mysql_num_rows($this->query());
    }
    
    public function where($where = '') {
        if(!empty($where)) {
            $this->query .= ' WHERE '.$where;
        };
        return $this;
    }
    
    public function andwhere($where = '') {
        if(!empty($where)) {
            $this->query .= ' AND '.$where;
        };
        return $this;
    }
    
    public function limit($num = 0, $count = '') {
        if($num>=0) {
            $this->query .= empty($count) ? ' LIMIT '.$num : ' LIMIT '.$num. ', '.$count;
        };
        return $this;
    }
    
    public function order($by = '', $sort = '') {
        if(!empty($by)) {
            $by = ($by !== 'RAND()' && $by !== 'rand()') ? '`'.$by.'`' : $by;
            $this->query .= ' ORDER BY '.$by.' '.$sort;
        };
        return $this;
    }
}