<?php
require_once "..".DIRECTORY_SEPARATOR."connessione.php"; #require once se la importo più volte la importo una sola volta 
$paginaHTML=file_get_contents("squadra.html");
$conn=new DBAccess();
$stringaGiocatori="";
$connOK=$conn->openDBConnection();
$giocatori="";
if($connOK){
    $giocatori=getList();
    $conn->closeConnection();
    if($giocatori!=null){
        if(count($giocatori)){
            $stringaGiocatori.='<dl id="giocatori">';
            foreach($giocatori as $giocatore){
            
            }
            $stringaGiocatori.='</dl>';
        }
        else{
            $stringaGiocatori="<span>Alcun giocatore è presente</span>"; #manda una mail all'amminisatrtore per avvisarlo
        }
        
        
    }
    #il ramo vero deve essere il più probabile 
    
    }
else{
    $stringaGiocatori="<span>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disturbo</span>"; #manda una mail all'amminisatrtore per avvisarlo

}
echo str_replace("<listaGiocatori/>",$stringaGiocatori,$paginaHTML);
?>