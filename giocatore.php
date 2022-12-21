<?php
require_once "connessione.php"; #require once se la importo più volte la importo una sola volta 
$paginaHTML=file_get_contents("form.html");
use DB\DBAccess;
$tagpermessi='<em><strong><li><ul><span>';#legge anche il tag di chiusura 
$nome='';
$capitano='';
$datanascita='';
$luogo='';
$altezza='';
$campionato='';
$maglia='';
$ruolo_nazionale='';
$maglia_nazionale='';
$punti='';
$riconoscimenti='';
$note='';
$messaggiForm='';
function PulisciInputRic($value){
    global $tagpermessi;
    $value=trim($value);
    $value=strip_tags($value,$tagpermessi); #toglie i tag se lo uso su qualsiasi cosa lui rimuove dal tag di apertura a quello di chiusura 
    #$value=htmlentities($value); #traduce tag html con i codice relativi-> prende tutto come carattri se inverto non trovo nulla
    return $value;
}
function PulisciInput($value){
    $value=trim($value);
    $value=strip_tags($value); #toglie i tag se lo uso su qualsiasi cosa lui rimuove dal tag di apertura a quello di chiusura 
    #$value=htmlentities($value); #traduce tag html con i codice relativi-> prende tutto come carattri se inverto non trovo nulla
    return $value;
}
if(isset($_POST['submit'])){
    $nome=PulisciInput($_POST['nome']);
    if(strlen($nome)==0){
        $messaggiForm .='<li>Nome e cognome non inseriti</li>';
    }
    else{
        if (preg_match("/\d/",$nome))
            $messaggiForm.='<li> Nome e cognome non posono contenere nuemeri</li>';
    }
    $capitano=$_POST['capitano']=='<capitanosi/>' ? 1 :  0 ;
    $datanascita=PulisciInput($_POST['dataNascita']);
    if(strlen($datanascita)==0){
        $messaggiForm.='<li> Data di nascita non inserita</li>';
    }
    
    else {
        if(!preg_match("/\d{4}\-\d{2}\-\d{2}/", $datanascita)){ //se la data non è nel formato corretto (anno - mese - giorno)
            $messaggiForm .= '<li>La data di nascita non è nel formato corretto</li>';
        }
    }
    
    $luogo=PulisciInput($_POST['luogo']);
    if(!strlen($luogo))
    {
        $messaggiForm."<li>Luogo non può essere vuoto</li>";
    }
    else{
        if(preg_match("/\d/",$luogo)){
            $messaggiForm .= '<li>Il luogo non può contenere caratterri numerici</li>';
        }
    }
    $altezza=PulisciInput($_POST['altezza']);
    if(!(ctype_digit($altezza)&&($altezza<130) && altezza>230)){
        $messaggiForm."<li>Altezza non permessa</li>"; 
    }
    $campionato=PulisciInputRic($_POST['squadra']);
    if(!strlen($campionato)){
        $messaggiForm.="<li>Campionato assente</li>";
    }
    else{
        if(preg_match("/\d/",$campionato)){
            $messaggiForm.="<li>La squadra non può contenere numeri</li>";
        }
    }
    $maglia=PulisciInput($_POST['maglia']);
    if(!strlen($maglia)){
        $messaggiForm.="<li>La maglia non può essere vuota</li>";
    }
    else if($maglia<0 || $maglia>1000){
    $messaggiForm.= "<li>Numero di maglia non valido</li>";
    }
   $ruolo_nazionale=PulisciInput($_POST['ruolo']);
   if(!strlen($ruolo_nazionale)){
    $messaggiForm.="<li>Il ruolo non può essere vuoto</li>";
    }
   $maglia_nazionale=PulisciInput($_POST['magliaNazionale']);
   if(!strlen($maglia_nazionale)){
    $messaggiForm.="<li>Maglia della nazionale non può essere vuota";
   }
   else if($maglia_nazionale<0 || $maglia_nazionale>1000){
    $messaggiForm.= "<li>Numero di maglia non valido</li>";
   }
   $punti=PulisciInput($_POST['punti']);
   if(!strlen($punti)){
    $messaggiForm.="<li>Punti non inseriti</li>";
   }
   else if(ctype_digit($punti) && $punti<0){
    $messaggiForm.="<li>Punti minori di zero</li>";
   }
   $riconoscimenti=PulisciInputRic($_POST['riconoscimenti']);
   $note=PulisciInputRic($_POST['note']);
//dopo aver fatto tutti i controlli

if($messaggiForm==""){
    $conn=new DBAccess();
    $connOK=$conn->openDBConnection();
    if($connOK){
        $queryOK=$conn->insertNewPlayer($nome,$capitano,$datanascita,$luogo,$campionato,$ruolo_nazionale,$altezza,$maglia,$maglia_nazionale,$punti,$riconoscimenti,$note);
        if($queryOK){
            $messaggiForm='<div id="greeting"><p>inserimento avvenuto con successo</p></div>'; 
        }
        else{
            $messaggiForm='<div id="messageError"><p>Problema di inserimento nei dati, controlla la presenza dei caratteri speciali</p></div>';
        }
    }
    else{
        $messaggiForm='<div id="messageError"><p>I nostri sistemi sono al momento non funzionanti, ci scusiamo per il disagio.</p></div>';
    }
}
else{
    $messaggiForm='<div id="messageError"><uL>'.$messaggiForm.'</ul></div>';

}

}
$paginaHTML=str_replace('<valoreNome />',$nome,$paginaHTML);
$paginaHTML=str_replace('<valData />',$datanascita,$paginaHTML);
$paginaHTML=str_replace('<valLuogo />',$luogo,$paginaHTML);
$paginaHTML=str_replace('<valoreAltezza />',$altezza,$paginaHTML);
$paginaHTML=str_replace('<valoreSquadra />',$campionato,$paginaHTML);
$paginaHTML=str_replace('<valoreMaglia />',$maglia,$paginaHTML);
$paginaHTML=str_replace('<valoreRuolo />',$ruolo_nazionale,$paginaHTML);
$paginaHTML=str_replace('<valoreMagliaNazionale />',$maglia_nazionale,$paginaHTML);
$paginaHTML=str_replace('<valorePunti />',$punti,$paginaHTML);
$paginaHTML=str_replace('<valoreRiconoscimenti />',$riconoscimenti,$paginaHTML);
$paginaHTML=str_replace('<valoreNote />',$note,$paginaHTML);
$paginaHTML=str_replace('<messaggiForm />',$messaggiForm,$paginaHTML);
echo $paginaHTML;

?>