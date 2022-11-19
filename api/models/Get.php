
   
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

    public function pull_booking($d)
    {
       $sql =  "SELECT * FROM `tbl_booking` booking
                INNER JOIN `tbl_cars` cars ON booking.user_id = cars.user_id
                INNER JOIN `tbl_rate` rate ON cars.car_id = rate.car_id
                INNER JOIN `tbl_ratings`rating ON booking.user_id = rating.user_id
                INNER JOIN `tbl_user` u ON booking.user_id = u.user_id
                WHERE u.user_type = 'rider'";
        
        
       $response =  $this->pdo->query($sql)->fetchAll();
    

       return $response;

    }
}



?>