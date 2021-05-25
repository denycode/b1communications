<?php
namespace App\Helpers;
use App\Model\Server;
use Config;
use DB;
use Auth;

class DatabaseConnection
{
    public static function setConnection($params)
    {
        try {
            config(['database.connections.dynamicmysql' => [
                'driver' => 'mysql',
                'host' => $params->host,
                'username' => $params->username,
                'password' => $params->password,
                'database' => $params->dbname
            ]]);
            $connection = DB::connection('dynamicmysql');
            if(!$connection->getPdo()){
                return ;
            }
           
            return $connection; 

        }   catch (\Exception $e) {
            if ($e instanceof \PDOException) {
               return false;
            }
            return false;
        }
        
    }

    public static function getConnectionParams(){
        dd(Auth::user());
    }


    public static function getServers(){
        $servers = Server::where('is_active',1)->get();
        return $servers;
    }
}
?>
