<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dbcon</title>
</head>
<body>
    <div>
    <?php

    if(DB::connection()->getPdo()){
        echo "Database connection is successful.".DB::connection()->getDatabaseName();
    }else{
        echo "Database connection is not successful.";
    }

    ?>
    </div>

</body>
</html>
