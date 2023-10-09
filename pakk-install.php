<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pakk Installer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&display=swap" rel="stylesheet">
</head>
<style>
    html, body{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background: #f0f0f0;
    }
    .installer{
        display: flex;
        flex-direction: column;
        align-items: center;
        font-family: 'Montserrat', sans-serif;
        border-radius: 5px;
        padding: 20px;
    }
    .button{
        background: #f0ad4e;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }
    .actions{
        margin-top: 20px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
        max-width: 400px;
    }

    .logo{
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .logo img{
        width: 100%;
        max-width: 400px;
    }
</style>
<body>
    <div class="logo">
<!--        base64-->
        <img src="data:image/png;base64,<?= base64_encode(file_get_contents(__DIR__ . '/logo.png')) ?>" alt="Pakk Logo">
    </div>
    <div class="installer">
        <h1>Pakk Installer</h1>
        <p>Pakk is not installed yet. Please run the installer.</p>
        <div class="actions">
            <a class="button" href="<?php echo admin_url('admin-ajax.php?action=wp-pakk-install'); ?>">Run Installer</a>
            <a class="button" href="<?php echo admin_url('admin-ajax.php?action=wp-pakk-delete'); ?>">Delete plugin and hook</a>
        </div>
    </div>

</body>
</html>