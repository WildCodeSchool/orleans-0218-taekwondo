<?php
namespace Model\Session\Alerts;

class Manager {
    const SESSION_KEY = "SessionAlerts";

    /**
     * Return a list of alerts
     * @return Alert[]
     */
    public function getAlerts(): array
    {
        if (!isset($_SESSION[self::SESSION_KEY]))
            return [];
        return array_map('unserialize', $_SESSION[self::SESSION_KEY]);
    }

    /**
     * Add a list of alerts
     * @param Alert[] $alerts
     * @return Manager
     */
    public function setAlerts(array $alerts): Manager
    {
        foreach ($alerts as $alert)
            if ($alert instanceof Alert)
                $this->addAlert($alert);
        return $this;
    }

    /**
     * Add an alert
     * @param Alert $alert
     * @return Manager
     */
    public function addAlert(Alert $alert): Manager
    {
        if (!isset($_SESSION[self::SESSION_KEY]))
            $_SESSION[self::SESSION_KEY] = [];
        $_SESSION[self::SESSION_KEY][] = serialize($alert);
        return $this;
    }

    /**
     * Clean the list
     * @return Manager
     */
    public function clean(): Manager
    {
        if (isset($_SESSION[self::SESSION_KEY]))
            unset($_SESSION[self::SESSION_KEY]);
        return $this;
    }
}