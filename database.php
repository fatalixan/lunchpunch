
<?php
 POSTGRES_URL="postgres://default:FL0ykw3vBEtb@ep-snowy-dust-a47wvub0-pooler.us-east-1.aws.neon.tech:5432/verceldb?sslmode=require"
 POSTGRES_PRISMA_URL="postgres://default:FL0ykw3vBEtb@ep-snowy-dust-a47wvub0-pooler.us-east-1.aws.neon.tech:5432/verceldb?sslmode=require&pgbouncer=true&connect_timeout=15"
 POSTGRES_URL_NO_SSL="postgres://default:FL0ykw3vBEtb@ep-snowy-dust-a47wvub0-pooler.us-east-1.aws.neon.tech:5432/verceldb"
 POSTGRES_URL_NON_POOLING="postgres://default:FL0ykw3vBEtb@ep-snowy-dust-a47wvub0.us-east-1.aws.neon.tech:5432/verceldb?sslmode=require"
 POSTGRES_USER="default"
 POSTGRES_HOST="ep-snowy-dust-a47wvub0-pooler.us-east-1.aws.neon.tech"
 POSTGRES_PASSWORD="FL0ykw3vBEtb"
 POSTGRES_DATABASE="verceldb"

function connectDatabase() {


    $host = POSTGRES_HOST;
    $dbname = POSTGRES_DATABASE="verceldb";
    $user = POSTGRES_USER;
    $password = POSTGRES_PASSWORD

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }
}
?>
