<?php
session_start();
$max = 10;
$fin = false;
if ( (!isset($_SESSION['t'])) || (isset($_REQUEST['prenom'])) ) {
	session_destroy();
	session_start();
$prenom = $_REQUEST['prenom'];
$type = $_REQUEST['type'];
$nb = $_REQUEST['nb']; 

$_SESSION['type'] = $type;
$_SESSION['prenom'] = $prenom;

$t = array();
for($i=1;$i<$max;$i++)
  for($j=1;$j<$max;$j++) $t[] = array($i,$j);
shuffle($t);

$nb = ($nb!=''?$nb:count($t));
$_SESSION['nb'] = $nb;
$_SESSION['t'] = $t;
$_SESSION['ok'] = 0;
$_SESSION['ko'] = 0;
$_SESSION['out'] = 0;
$i = 0;
$_SESSION['i'] = $i;
$_SESSION['x'] = $t[0][0];
$_SESSION['y'] = $t[0][1];
$_SESSION['histo'] = array();
$message = 'C\'est parti !';
} 
else {
  $type = $_SESSION['type'] ;
  $prenom = $_SESSION['prenom'] ;
  $nb = $_SESSION['nb'];
  $x=$_SESSION['x'];
  $y=$_SESSION['y'];
  $rep = $_REQUEST['rep'];
  switch ($type) {
		  case 'addition' : $s = $x+$y;break;
		  case 'multiplication' : $s = $x*$y;break;
		  default :;
	  }
  if (isset($rep) && ($rep!='')) {

	  if ($rep == $s) {
		  $_SESSION['ok'] = $_SESSION['ok'] + 1;
		  $message = $x.($type=='addition'?' + ':' * ').$y." = $s".". Bien $prenom !";
      } else { 
	      $_SESSION['ko'] = $_SESSION['ko'] + 1;
	      $message = 'Non ! Rappel toi : '.$x.($type=='addition'?' + ':' * ').$y." = $s (tu as répondu $rep)";
	      $_SESSION['histo'][] = array($x,$y,$s);
      }
  } else 	{
	  $_SESSION['out'] = $_SESSION['out'] + 1;
	  $message = 'Pas de réponse ? Rappel toi : '.$x.($type=='addition'?' + ':' * ').$y." = $s !";
	  $_SESSION['histo'][] = array($x,$y,$s);
  }
  $i = $_SESSION['i'];
  $t = $_SESSION['t'];
  if ($i+1 == $nb) $fin = true;
  else {
  	  $i = $i+1;
	  $_SESSION['i'] = $i;
	  
	  $_SESSION['x'] = $t[$i+1][0];
      $_SESSION['y'] = $t[$i+1][1];
  }
}

  $x=$_SESSION['x'];
  $y=$_SESSION['y'];

?>

<?php include 'header.php'; ?>
			<div id="splash">
				<div class="top"><img src="images/Math.png" alt="" width="460" height="180" /></div>
				<div class="bottom"></div>
			</div>
			<div id="samples">
			
<script type="text/javascript">
window.onload =function setFocus(){
    document.saisie.rep.focus();
    return true;
}
function verif(){
	var reg = /^[\d]+$/;
    if (reg.test(document.saisie.rep.value)) return true;
    else {
    	alert('Attention <?php echo $prenom;?>, il faut entrer un nombre !'); 
    	return false;
    }
}
</script>

<?php
if ($fin) { echo '<p>'.$message.'</p>';
	echo "<p> C'est terminé $prenom ! </p> <p>Voici les résultats :</p>";
	echo '<p>Bonnes réponses : '.$_SESSION['ok'].'<br/>';
	echo 'Mauvaises réponses : '.$_SESSION['ko'].'<br/>';
	echo 'Absence de réponse : '.$_SESSION['out'].'</p>';
	$note = $_SESSION['ok']*20/$nb;
	echo '<p>Note : '.number_format($note,0,',',' ').'  /  20 - ';
	if ($note>=18) echo 'Parfait !';
	else if ($note>=16) echo 'Très bien !';
	else if ($note>=15) echo 'Bien !';
	else if ($note>=14) echo 'Assez bien.';
	else if ($note>=12) echo 'bon.';
	else if ($note>=10) echo "Trop juste $prenom !";
	else echo "Il faut revoir tes tables $prenom !";
	echo '</p>';
	if (count($_SESSION['histo'])) {
		echo '<p>Et souviens-toi :</p><ul>';
		foreach($_SESSION['histo'] as $pb){
			echo '<li>'.$pb[0].($type=='addition'?' + ':' * ').$pb[1].' = '.$pb[2].'</li>';
		}
		echo '</ul>';
	}
	//session_destroy();
	echo '<p><a href="tables_init.php">Recommencer</a></p>';
} else { ?>
 	<p><?php echo $message;?></p>
 	<script type="text/javascript">setFocus();</script>
	<FORM name="saisie" action="tables.php" method="GET">
		<p><?php echo 'Opération '.($i+1).' (sur '.$nb.') :<br/> '.$x.($type=='addition'?'+':'*').$y; ?>  = <INPUT type="text" name="rep" id="rep"/></p>
		<INPUT type="submit" name="Valider" value="Proposer" onClick="return verif();"/>
    </FORM>
<?php }
?>

			</div>
<?php include 'footer.php'; ?>