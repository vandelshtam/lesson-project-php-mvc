<?php


class QueryBuilder {
    protected $pdo;
    public function __construct($pdo)
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
    public function getOne($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        //$statement->bindParam(':id', $id);//принимает только переменную ввкести строку или цифру нельзя
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function create($table, $data)
    {
        $keys = implode(',', array_keys($data));
        $tags = ":" . implode(', : ',array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$keys}) VALUE ({$tags})";
        
        $statement = $this->pdo->prepare($sql);
        //$statement->bindValue(':title', 'NHHGG67878');
        $statement->execute($data);
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
        //dd($keys);
        $sql = "UPDATE {$table} SET {$keys} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        //$statement->bindValue(':id', $id);
        dd($statement->execute($data));

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
}