<?php
#metto all'interno funzioni di utilità usate per acceddere al db 
namespace DB;
class DBAccess{
    private const HOST_DB='127.0.0.1';
    private const DATABASE_NAME='mbrugin';
    private const USERNAME='mbrugin';
    private const PASSWORD='eingohha5Iemuaba';
    private $connection;
    public function openDBConnection() {
        mysqli_report(MYSQLI_REPORT_ERROR);

        $this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);

        if(mysqli_connect_errno()){
            return false;
        } else {
            return true;
        }
    }

    public function getList() {
        $query = "SELECT * FROM giocatori ORDER BY ID ASC";
        $query_result = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($query_result)==0){
            return null;
        } else {
            $result = array();
            while ($row = mysqli_fetch_assoc($query_result)) {
                array_push($result, $row);
            }
            $query_result->free();
            return $result;
        }
    }
    public function insertNewPlayer($nome,$capitano,$datanascita,$luogo,$squadra,$ruolo,$altezza,$maglia,$maglia_nazionale,$punti,$riconoscimenti,$note){
        $query = "INSERT INTO giocatori (nome, capitano, dataNascita, luogo, squadra, ruolo, altezza, maglia, magliaNazionale, punti, riconoscimenti, note) VALUES (\"$nome\", $capitano, \"$datanascita\", \"$luogo\", \"$squadra\", \"$ruolo\", $altezza, $maglia, $maglia_nazionale, $punti, \"$riconoscimenti\", \"$note\")";
        $queryOk=mysqli_query($this->connection,$query) or die (mysqli_error($this->connection)); #e se si interrompe la connessione    va sul log
        if(mysqli_affected_rows($this->connection)==1){
            return true;
        }
        return false;
    }
    public function closeConnection(){
        mysqli_close($this->connection);
    }

}
?>