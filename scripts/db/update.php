<?php

chdir(dirname(__DIR__));
define('APPLICATION_PATH', realpath(__DIR__ . '/../..'));
define('DELTA_PATH', APPLICATION_PATH . '/scripts/db/delta');
$dump = shell_exec(APPLICATION_PATH . '/vendor/bin/doctrine-module orm:schema-tool:update --dump-sql');

updateDatabase();
newDeltascript();
updateDatabase();

$files = scandir(DELTA_PATH);

function getDeltaScripts($int = 0)
{
    $files  = scandir(APPLICATION_PATH . '/scripts/db/delta');
    $deltas = array();
    foreach ($files as $file) {
        if (\preg_match("/^[0-9]+.sql$/", $file)) {
            $deltaint = (int) \str_replace('.sql', '', $file);
            if ($deltaint > $int) {
                $deltas[] = $deltaint;
            }
        }
    }
    return $deltas;
}

function getLastDeltaScript()
{
    $delta = \getDeltaScripts();
    return \end($delta);
}

function newDeltascript()
{
    $string = shell_exec(APPLICATION_PATH . '/vendor/bin/doctrine-module orm:validate-schema');
    $array  = \explode("\n", $string);
    $info   = array();
    foreach ($array as $value) {
        $matches = array();
        $pattern = "/^\[([A-Za-z]*)\][ ]+([a-zA-Z]*)[ ]+/";
        \preg_match($pattern, $value, $matches);
        if (!empty($matches)) {
            $info[$matches[1]] = $matches[2];
        }
    }
    if ($info['Mapping'] != 'OK') {
        throw new Exception('mapping not ok');
    }

    if ($info['Database'] == 'OK') {
        echo 'database is up to date' . "\n";
        return true;
    } else {
        echo 'create deltascript' . "\n";
        $string = shell_exec(APPLICATION_PATH . '/vendor/bin/doctrine-module orm:schema-tool:update --dump-sql');
        
        $last = getLastDeltaScript();

        $int = ($last) ? $last + 1 : 1;

        $fp = \fopen(DELTA_PATH . '/' . $int . '.sql', 'w+');
        fwrite($fp, $string);
        fclose($fp);
    }
}

function updateDatabase()
{
    $pdo = new \DbDeployPDO();
    if (!$pdo->isInstalled()) {
        $pdo->install();
    }
    $int    = $pdo->getLastInsert();
    $deltas = \getDeltaScripts($int);
    if (!empty($deltas)) {
        foreach ($deltas as $delta) {
            echo "deploy " . $delta . "\n";
            $pdo->deploy($delta);
        }
    } else {
        echo 'no delta'. "\n";
    }
}

class DbDeployPDO extends PDO
{

    public function __construct($dsn = null, $username = null, $passwd = null, $options = null)
    {
        $config   = include \APPLICATION_PATH . '/config/autoload/doctrine.local.php';
        $params   = $config['doctrine']['connection']['orm_default']['params'];
        $dsn      = 'mysql:dbname=' . $params['dbname'] . ';host=' . $params['host'];
        $username = $params['user'];
        $passwd   = $params['password'];
        parent::__construct($dsn, $username, $passwd, $options);
    }

    public function isInstalled()
    {
        $query     = 'show tables like "changelog"';
        $statement = $this->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 1) {
            return true;
        }
        return false;
    }

    public function install()
    {
        $installscript = \file_get_contents(DELTA_PATH . '/../install.sql');
        $this->exec($installscript);
    }

    public function getLastInsert()
    {
        $query     = 'SELECT description FROM changelog ORDER BY description DESC LIMIT 1';
        $statement = $this->prepare($query);
        $statement->execute();
        $fetch     = $statement->fetch();
        $int       = (int) \str_replace('.sql', '', $fetch['description']);
        return $int;
    }

    public function deploy($delta)
    {
        $number = $this->preDeploy($delta);

        $script = \file_get_contents(DELTA_PATH . '/' . $delta . '.sql');
        $exec   = $this->exec($script);
        if (false === $exec) {
            \var_dump($this->errorInfo());
            throw new Exception($this->errorCode(), $this->errorCode());
        }
        $this->postDeploy($number);
    }

    public function preDeploy($delta)
    {
        $params = array(
            ':delta_set'   => 'Main',
            ':applied_by'  => 'dbdeploy',
            ':description' => $delta . '.sql',
        );
        $sql    = 'INSERT INTO changelog (delta_set, applied_by, description) '
                . 'VALUES (:delta_set, :applied_by, :description)';

        $q            = $this->prepare($sql);
        $q->execute($params);
        $changenumber = $this->lastInsertId();
        return $changenumber;
    }

    public function postDeploy($number)
    {
        $sql = 'UPDATE changelog SET complete_dt = NOW() WHERE change_number = ?';
        $q   = $this->prepare($sql);
        $q->execute(array($number));
    }

}
