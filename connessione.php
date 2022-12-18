<?php
namespace DB;#metto all'interno funzioni di utilità usate per acceddere al db 
class DBAccess{
    private const HOST_DB="127.0.0.1";
    private const DATABASE_NAME="mbrugin";
    private const USERNAME="mbrugin"
    private const PASSWORD="eingohha5Iemuaba";
    private $connection;
    public function openDBConnection(){
        mysqli_report(MYSQLI_REPORT_ERROR); #SEGNALA SOLO GLI ERRORI aLL SEGNALA TUTTO si blocca anche per warning 
        $connection=mysqli_connect(HOST_DB,USERNAME,PASSWORD,DATABASE_NAME);
        #nuemro dell'errore 
        if(mysqli_connect_errno()){
            return false;
        }
        else{
            return true;
        }

    }
    public function getList(){
        $query="SELECT * FROM giocatori ORDER BY ID";
        $result= mysqli_query($connection,$query) or  die("Errore in dbConnection: ".mysqli_error($connection)); #se muore stampa quella pagina 
        if(!mysqli_num_rows($result)){
            return null;
    }
    else{
      #se elaboro io l'output qua ho una risorsa impegnata -> la conessioen al DB-> anche google guarda queste caratterristiche
      $res=array();
      while($riga=mysqli_fetch_assoc($result)){
        array_push($res,$riga);
      }   
      $result->free();
      return $res;

    }

}
public function closeConnection(){
    mysqli_close($connection);
}
}
?>