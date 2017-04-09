<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Probando encriptacion</title>
</head>
<body>
<h1>Intranet</h1>
    <form method="post">
        <label>encriptar:</label><input name="strToEncriptar">
        <?php echo \App\Sys\Security::encrypt($msgToEncrypt); ?><br>
        <label>Desencriptar:</label><input name="strToDesencrypt">
        <?php echo \App\Sys\Security::desencrypt($msgToDesencrypt); ?><br>
        <input type="submit">
    </form>
</body>
</html>