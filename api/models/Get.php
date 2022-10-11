
   
<?php


class Get
{
    protected $gm, $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->gm = new GlobalMethods($pdo);
    }
    // Functions Starts Here
}



?>