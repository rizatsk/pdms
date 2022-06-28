<?php

class Model_Id extends CI_Model
{
    public function IdManagement($code, $maxIdUsers)
    {
        $maxIdUsers = substr($maxIdUsers, 6, 3);
		$serialNumber = sprintf("%03s",$maxIdUsers + 1);
		$date = date("my");
		$idUsers = $code.$date.$serialNumber;
        return $idUsers;
    }
}