  <?php
  
  echo(
  '<div style="font-family:courier; font-size:11px; border:solid 1px black; margin:0 auto 0 auto;  width:90%;">
        <table style="width:90%; ">
            <tr>
            <td><p style="font-size:11px;">'. $GLOBALS['titulo'] .'</p></td>');
            echo('<td><p>Impresión:'. date('Y-m-d') .'</p></td>');
            echo('<td><p>Página:'.$GLOBALS['pagina']. '</p></td>');
            echo('</tr></table></div>');

?>

