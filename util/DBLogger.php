<?php

namespace util;


class DBLogger implements ILogger
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function log($request, $priority)
    {
        $sql = "INSERT INTO transaction_log (priority, timestamp, data) VALUES (:priority, :timestamp, :data)";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':priority',$priority);
        $statement->bindParam(':timestamp',time());
        $statement->bindParam(':data',$request);
        return $statement->execute();
    }

}