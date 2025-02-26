<html>
<head><title>Envío de mensajes a usuarios/grupos</title></head>
<bo>
<h1>Envío de mensajes</h1>
<b>Destinatario:</b><br> 
<form action="accion" method="get">
 <select name="grupo">
    <option value="-1">--Seleccionar grupo--</option> 
    <?php 
    //echo var_dump($grupos);

    foreach($grupos as $g)
    {
            echo "<option value='{$g['id_grupo']}'> {$g['grupo']} </option>";
           
    }
    ?>
</select>
<select name="usuario">
    <option value="-1">--Seleccionar usuario--</option> 
    <?php 
    //echo var_dump($grupos);

    foreach($usuarios as $u)
    {
            echo "<option value='{$u['id_usuario']}'> {$u['nombre']} </option>";
           
    }
    ?>
</select><br>
Introduzca mensaje: 
<input type="text" width="60" maxlength="128" name="mensaje">
<br>
<input type="submit" value="Enviar">
</form>
</body>
</html>
