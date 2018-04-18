<?php
namespace Model\Session\Alerts;

class Alert {
    /** @var bool */
    private $state;
    /** @var string */
    private $message;

    public function __construct(bool $state = false, string $message = '')
    {
        $this->state = $state;
        $this->message = $message;
    }

    /**
     * Return the response state
     * @return bool
     */
    public function getState(): bool { return $this->state; }

    /**
     * Return the response message
     * @return string
     */
    public function getMessage(): string { return $this->message; }

    /**
     * Return the alert type
     * @return string
     */
    public function getAlertType(): string { return $this->state ? 'success' : 'error'; }

    /**
     * Define the response state
     * @param bool $state
     * @return Alert
     */
    public function setState(bool $state): Alert
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Define the response message
     * @param string $message
     * @return Alert
     */
    public function setMessage(string $message): Alert
    {
        $this->message = $message;
        return $this;
    }
}