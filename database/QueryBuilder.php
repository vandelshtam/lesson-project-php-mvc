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
        
        
    }

    
    public function getUserAllTable($tables){
        
        $sql = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){
            
            $sql .= '  INNER JOIN ' .$table. ' ON '. $table.'.user_id  = users.id';
        }
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getOneAllTable($tables, $id, $where_param )
    {
       
        $str = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){
            
            $str .= '  INNER JOIN ' .$table. ' ON '. $table.'.user_id  = users.id ';
        }
        $sql = $str .' WHERE '.array_pop($tables).'.'.$where_param.'_id LIKE :id';
       // echo $sql;
        //$sql = "SELECT * FROM users  INNER JOIN infos ON infos.user_id = users.id WHERE users.id LIKE :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
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


    //для постов 
    
/*
    public function getPostsAllTable(){
        
        $sql = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){
            
            $sql .= '  INNER JOIN ' .$table. ' ON '. $table.'.user_id  = users.id ';
        }
        
        $sql = "SELECT * FROM posts  INNER JOIN infos ON infos.id = posts.info_id INNER JOIN users ON users.id = posts.user_id";
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        //dd($statement->fetchAll(PDO::FETCH_ASSOC));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
*/


    public function getPostAllTable(){
        /*
        $sql = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){
            
            $sql .= '  INNER JOIN ' .$table. ' ON '. $table.'.user_id  = users.id ';
        }
        */
        $sql = "SELECT * FROM posts  INNER JOIN infos ON infos.id = posts.info_id  INNER JOIN socials ON socials.id = posts.social_id INNER JOIN users ON users.id = posts.user_id WHERE posts.favorites LIKE 1";
        $statement=$this->pdo->prepare($sql);
        //$statement->bindValue(':id', $id);
        $statement->execute();
        //dd($statement->fetch(PDO::FETCH_ASSOC));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    
    
    public function getAllTableWhereParam($tables,$where, $value){
        
        $sql = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){
            
            $sql .= '  INNER JOIN ' .$table. ' ON '. $table.'.user_id  = users.id';
        }
        $sql = $sql.' WHERE ' .array_pop($tables).'.'.$where. ' LIKE ' .$value;
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    





    //========= универсальные запросы для всех разделов  ==============
    //пока тут находятся все методы с которыми работает пост

    //запрос одной записи из нескольких таблиц
    public function getWhereTableAll($tables, $value, $where_param, $where_param_2, $table_param,$table_param_2 )
    {
        //$table_param - параметр из присоединяемой таблицы (user_id, post_id, и т д)
        //$table_param_2 - параметр из основной таблицы (users.id, posts.id и т д)
        //$where_param - условие выборки из таблицы (user_id, post_id, и.т.п)
        //$where_param_2 - значение условия выборки из таблицы (например id)
        //образец формируемого запроса - $sql = "SELECT * FROM users  INNER JOIN infos ON infos.user_id = users.id   INNER JOIN posts ON posts.user_id = users.id WHERE posts.id LIKE :id"
        $str = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){    
            $str .= '  INNER JOIN ' .$table. ' ON '. $table.'.'.$table_param.'  = '.$table_param_2;
        }
        $sql = $str .' WHERE '.array_pop($tables).'.'.$where_param.' LIKE :'.$where_param_2;
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':'.$where_param_2, $value);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    //получение всех записей из нескольких таблиц
    public function getAllTableAll($tables,$table_param,$table_param_2){
        //$table_param - параметр из присоединяемой таблицы (user_id, post_id, и т д)
        //$table_param_2 - параметр из основной таблицы (users.id, posts.id и т д)
        //образец формируемого запроса - $sql = "SELECT * FROM users  INNER JOIN infos ON infos.user_id = users.id   INNER JOIN posts ON posts.user_id = users.id"
        $sql = 'SELECT * FROM ' .$tables[0];
        foreach(array_slice($tables, 1) as $table){    
            $sql .= '  INNER JOIN ' .$table. ' ON '. $table.'.'.$table_param.'  = '.$table_param_2;
        }
        $statement=$this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //получение записей из любой одной таблицы с сортировкой 
    public function getTableParams($table,$value,$param_value,$param_where,$param_order,$param_sort){   
        $sql = "SELECT * FROM {$table} WHERE {$param_where}={$param_value} ORDER BY {$param_order} {$param_sort}";
        $statement=$this->pdo->prepare($sql);
        $statement->bindValue($param_value, $value);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    //получение одной записи по любому условию(полю) из любой одной таблицы
    public function getOneParam($table,$param,$value)
    {
        $sql = "SELECT * FROM {$table} WHERE {$param}=:{$param}";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':'.$param.'', $value);
        //$statement->bindParam(':id', $id);//принимает только переменную ввести строку или цифру нельзя
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    //обновление в любой таблице
    public function updateAny($table, $data, $param, $param2)
    {    
        $keys = array_keys($data);
        $string = '';
        foreach($keys as $key)
        {
            $string .= $key .'=:'. $key .',';
        }
        $keys = rtrim($string, ',');
        $data['param2'] = $param2;
        $sql = "UPDATE {$table} SET {$keys} WHERE {$param}=:param2";
        //echo $sql;die;
        $statement = $this->pdo->prepare($sql);
        foreach($data as $key => $value){
            $statement->bindValue(':'.$keys.'', $value);
        }
        $statement->bindValue(':param2', $param2);
        $statement->execute($data);
    }
    
    //удаление записи в любой таблице
    public function deleteParam($table,$param, $value)
    {
        $sql = "DELETE FROM {$table} WHERE {$param}=:{$param}";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':'.$param.'', $value);
        //$statement->bindParam(':id', $id);//принимает только переменную ввкести строку или цифру нельзя
        $statement->execute();    
    }

    //новая запись в любую таблицу
    public function create($table,$data)
    {
        // модель запроса $sql = "INSERT INTO users (name, email, password) VALUE (:name, :email, :password)";
        $keys = implode(', ', array_keys($data));
        $tags = ":" . implode(', :',array_keys($data));
        $sql = "INSERT INTO {$table} ({$keys}) VALUE ({$tags})";
        $statement = $this->pdo->prepare($sql);
        foreach($data as $key => $value){
            $statement->bindValue(':'.$keys.'', $value);
        }
        $result = $statement->execute($data);
        return $result;
    }

    // получение id последней записи в таблицу
    public function lastId(){
        return $this->pdo->lastInsertId();
    }

}