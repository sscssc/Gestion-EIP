<?php
include "sql_req.php";
error_reporting(0);

class client
{
    private $info = array(); // 0=ID; 1=login; 2=fist_name; 3=lastname;
                       // 4=passwrd; 5=email; 6=phone_nbr; 7=type;
                       // 8=project_ID;

    private function check_entry($str)
    {
        for ($i=0, $correct = 1; $str[$i] && $correct ; $i++) { 
            if ((65 > $str[$i] && $str[$i] > 90 &&
                 97 > $str[$i] && $str[$i] > 122) ||
                 95 != $str[$i] || $i > 10 || 40 != $str[$i])
            {
                $correct = -1;
            }
        }
        return $correct;
    }

    public function __construct($ID = '', $login = '', $first_name = '', 
                                $last_name = '', $passwrd = '', $email = '', 
                                $phone_nbr = '', $type = '', $project_ID = '')
    {
        if (!($this->check_entry($ID) && $this->check_entry($login) &&
              $this->check_entry($first_name) && $this->check_entry($last_name) &&
              $this->check_entry($passwrd) && $this->check_entry($email) &&
              $this->check_entry($phone_nbr) && $this->check_entry($type) &&
              $this->check_entry($project_ID)))
            return -1;


        $this->info[0] = $ID;
        $this->info[1] = $login;
        $this->info[2] = $first_name;
        $this->info[3] = $last_name;
        $this->info[4] = $passwrd;
        $this->info[5] = $email;
        $this->info[6] = $phone_nbr;
        $this->info[7] = $type;
        $this->info[8] = $project_ID;
    }

    public function register($bdd)
    {

        $request = $bdd->prepare(
            ' INSERT INTO Members (ID, login, first_name,
                                   last_name, passwrd, email,
                                   phone_nbr, type, project_ID)
              VALUES (:ID, :login, :first_name,
                        :last_name, :passwrd, :email,
                        :phone_nbr, :type, :project_ID)');

        $request->execute(array(
        'ID' => $this->info[0],
        'login' => $this->info[1],
        'first_name' => $this->info[2],
        'last_name' => $this->info[3],
        'passwrd' => $this->info[4],
        'email' => $this->info[5],
        'phone_nbr' => $this->info[6],
        'type' => $this->info[7],
        'project_ID' => $this->info[8]));
    }

    public function get_ID()
    {
        return $this->info[0];
    }

    public function get_login()
    {
        return $this->info[1];
    }

    public function get_first_name()
    {
        return $this->info[2];
    }


    public function get_last_name()
    {
        return $this->info[3];
    }

    public function check_passwrd($bdd, $pass)
    {
        $precision = "WHERE login = '".$this->info[1]."'";
        $result = sql_select($bdd, "passwrd", "Members", $precision);
        if (md5($pass) == $result[0][0])
            return 1;
        else
            return 0;
    }

    public function connection($bdd, $login, $pass)
    {
        $precision = "WHERE login = '$login'";

        if (!($this->check_entry($login) && $this->check_entry($pass)))
            return 0;

        if(sql_select($bdd, "ID", "Members", $precision))
        {
            $this->info[1] = $login;
            if ($this->check_passwrd($bdd, $pass))
            {
                $this->down_info($bdd, $login);
                return 1;
            }
        }    
        return 0;

    }

    public function down_info($bdd, $login)
    {
        $precision = "WHERE login = '$login'";
        if ($result = sql_select($bdd, "*", "Members", $precision)) {
            for ($i=0; $i < 9; $i++) { 
                $this->info[$i] = $result[0][$i];
            }
        }
    }

    public function get_email()
    {
        return $this->info[5];
    }

    public function get_phone_nbr()
    {
        return $this->info[6];
    }

    public function get_type($bdd)
    {
        return $this->info[7];
    }

    public function get_project_ID()
    {
        return $this->info[8];
    }
}