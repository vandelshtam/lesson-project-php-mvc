<?php
namespace Database;

use PDO;

class QueryBuilder {

    protected $pdo;
    
    public function __construct($pdo )
    {   
        $this->pdo = $pdo;
    }
    public function getAll($table)
    { 
        $sql="SELECT * FROM {$table}";
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getOne_tableOne($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getOneUserId($table, $user_id)
    {
        $sql = "SELECT * FROM {$table} WHERE user_id=:user_id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $user_id);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //получение юзера по емайл
    public function getOneEmail($table, $email)
    {
        
        $sql = "SELECT * FROM {$table} WHERE email=:email";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function create($table,$data)
    {
        $keys = implode(', ', array_keys($data));
        $tags = ":" . implode(', :',array_keys($data));
        $sql = "INSERT INTO {$table} ({$keys}) VALUE ({$tags})";
        //$sql = "INSERT INTO users (name, email, password) VALUE (:name, :email, :password)";
        $statement = $this->pdo->prepare($sql);
        foreach($data as $key => $value){
            $statement->bindValue(':'.$keys.'', $value);
        }
        $result = $statement->execute($data);
        //$statement->execute(['name' => 'NNN', 'email' => 'nnn@nnn', 'password' => 12345]);
        //$newUserId=$this->pdo->lastInsertId();
        return $result;
    }



    public function update($table, $data, $id)
    {    
        $keys = array_keys($data);
        $string = '';
        foreach($keys as $key)
        {
            $string .= $key .'=:'. $key .',';
        }
        $keys = rtrim($string, ',');
        $data['id'] = $id;
        $sql = "UPDATE {$table} SET {$keys} WHERE id=:id";
        //echo $sql;die;
        $statement = $this->pdo->prepare($sql);
        foreach($data as $key => $value){
            $statement->bindValue(':'.$keys.'', $value);
        }
        $statement->bindValue(':id', $id);
        $statement->execute($data);
    }

    public function updateTableUserId($table, $data, $user_id)
    {    
        $keys = array_keys($data);
        $string = '';
        foreach($keys as $key)
        {
            $string .= $key .'=:'. $key .',';
        }
        $keys = rtrim($string, ',');
        $data['user_id'] = $user_id;
        $sql = "UPDATE {$table} SET {$keys} WHERE user_id=:user_id";
        //echo $sql;die;
        $statement = $this->pdo->prepare($sql);
        foreach($data as $key => $value){
            $statement->bindValue(':'.$keys.'', $value);
        }
        $statement->bindValue(':user_id', $user_id);
        $statement->execute($data);
    }


    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        //$statement->bindParam(':id', $id);//принимает только переменную ввкести строку или цифру нельзя
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result; 
    }

    public function getUserAllTable($tables){
        
        $sql = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){
            
            $sql .= '  INNER JOIN ' .$table. ' ON '. $table.'.user_id  = users.id ';
        }
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getOneAllTable($tables, $id)
    {
       // dd($id);
        $str = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){
            
            $str .= '  INNER JOIN ' .$table. ' ON '. $table.'.user_id  = users.id ';
        }
        $sql = $str .' WHERE infos.user_id LIKE :id';
       // echo $sql;
        //$sql = "SELECT * FROM users  INNER JOIN infos ON infos.user_id = users.id WHERE users.id LIKE :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    //получение одной записи по любому условию(полю) из любой таблицы
    public function getOneParam($table,$param,$value)
    {
        $sql = "SELECT * FROM {$table} WHERE {$param}=:{$param}";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':'.$param.'', $value);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // получение id последней записи в таблицу
    public function userId(){
        return $this->pdo->lastInsertId();
    }


    /*  пока не нужна 
    public function getSearchName($table, $name)
    {
        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $sql = "SELECT * FROM {$table} WHERE name LIKE '%".$name."%'";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':name', $name);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    */

    public function countColumn($table){
        
        $sql = "SELECT COUNT(id) FROM {$table}";
        $statement = $this->pdo->query($sql);
        return $statement->fetchColumn();
    }
    
    //запрос по условиям пагинации
    public function getUsersListPaginate($tables, $params)
    { 
        $str = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){
            
            $str .= '  INNER JOIN ' .$table. ' ON '. $table.'.user_id  = users.id ';
        }
        $sql = $str .'  LIMIT ' .$params['start']. ','.$params['max'];
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}