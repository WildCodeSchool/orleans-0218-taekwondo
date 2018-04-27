<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 20:52
 * PHP version 7
 */

namespace Model;

use App\Connection;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManager
{
    protected $pdoConnection; //variable de connexion

    protected $table;
    protected $className;

    /**
     *  Initializes Manager Abstract class.
     * @param string $table Table name of current model
     */
    public function __construct(string $table)
    {
        $connexion = new Connection();
        $this->pdoConnection = $connexion->getPdoConnection();
        $this->table = $table;
        $this->className = __NAMESPACE__ . '\\' . ucfirst($table);
    }

    /**
     * Get all row from database.
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdoConnection->query('SELECT * FROM ' . $this->table, \PDO::FETCH_CLASS, $this->className)->fetchAll();
    }

    /**
     * Get one row from database by ID.
     * @param  int $id
     * @return array
     */
    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdoConnection->prepare("SELECT * FROM $this->table WHERE id=:id");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * DELETE on row in database by ID
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $req = $this->pdoConnection->prepare("DELETE FROM $this->table WHERE id = :id");
        $req->bindValue('id', $id);
        return $req->execute();
    }


    /**
     * INSERT one row in database
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        $keys = $values = $replaces = [];
        foreach ($data AS $key => $value) {
            $keys[] = $key;
            $replaces[] = ":$key";
            $values[] = $value;
        }

        $intoKeys = implode(',', $keys);
        $intoReplaces = implode(',', $replaces);

        $req = $this->pdoConnection->prepare("INSERT INTO $this->table ($intoKeys) VALUES ($intoReplaces)");
        foreach ($replaces AS $key => $replacement) {
            $req->bindValue($replacement, $values[$key]);
        }

        return $req->execute();
    }


    /**
     * Update a given row in database
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $update = [];
        foreach ($data AS $key => $value) $update[] = "$key = :$key";
        $update  = implode(',', $update);

        $req = $this->pdoConnection->prepare("UPDATE $this->table SET $update WHERE id = :id");
        $req->bindValue('id', $id);
        foreach ($data AS $key => $value) $req->bindValue($key, $value);

        return $req->execute();
    }

    /**
     * Check if a given id exists in database
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        $req = $this->pdoConnection->prepare("SELECT COUNT(*) AS nbr FROM $this->table WHERE id = :id");
        $req->bindValue('id', $id);
        $state = $req->execute();
        return $state ? $req->fetch(\PDO::FETCH_ASSOC)['nbr'] > 0 : false;
    }
}
