<?php
require_once "connessione.php";
use DB\DBAccess;
$pagina_HTML=file_get_contents("squadra.html");
$connessione=new DBAccess();
$connOK=$connessione->openDBConnection();
$giocatori="";
$stringaGiocatori="";
if($connOK){
    $giocatori=$connessione->getList();
    $connessione->closeConnection();
    if($giocatori!=null){
        $stringaGiocatori .="<dl id='giocatori'>";
        foreach($giocatori as $giocatore){
            $stringaGiocatori.= "<dt>" .$giocatore['nome'];
            if($giocatore['capitano']){
                $stringaGiocatori.="- <emCapitano></em>";
            }
            $stringaGiocatori.= "</dt>"
            . '<dd><img src="'.$giocatore['immagine'].'" alt="" />'
            . '<dl class="giocatore"><dt>Data di Nascita</dt>'
            . '<dd>'.$giocatore['dataNascita'].'</dd>'
            . '<dt>Luogo</dt>'
            . '<dd>'.$giocatore['luogo'].'</dd>'
            . '<dt>Squadra</dt>'
            . '<dd>'.$giocatore['squadra'].'</dd>'
            . '<dt>Ruolo</dt>'
            . '<dd>'.$giocatore['ruolo'].'</dd>'
            . '<dt>Altezza</dt>'
            . '<dd>'.$giocatore['altezza'].'</dd>'
            . '<dt>Maglia</dt>'
            . '<dd>'.$giocatore['maglia'].'</dd>'
            . '<dt>Maglia in nazionale</dt>'
            . '<dd>'.$giocatore['magliaNazionale'].'</dd>';
            if($giocatore['ruolo']!='libero'){
                $stringaGiocatori.= '<dt>Punti totali</dt>';
            }
            else{
                $stringaGiocatori.= '<dt>Ricezioni</dt>';
            }
            $stringaGiocatori.= '<dd>'.$giocatore['punti'].'</dd>';
            if($giocatore['riconoscimenti']!=null){
                $stringaGiocatori.='<dt class="Riconoscimenti">Riconoscimenti</dt>'
                .'<dd>'.$giocatore['riconoscimenti'].'</dd>';
            }
            if($giocatore['note']!=null){
                $stringaGiocatori.='<dt class="note">Note</dt>'
                .'<dd>'.$giocatore['note'].'</dd>';
            }
            $stringaGiocatori .= '</dl></dd>';
        }
    }
        else{
            $stringaGiocatori.= "<p>Nessun giocatore presente</p>";
        }
}
else{
    $stringaGiocatori="<p>Il sistema e momentaneamente fuori servizio, ci scusiamo per il disagio</p>";
}
echo str_replace("<listaGiocatori/>",$stringaGiocatori,$pagina_HTML);

?>