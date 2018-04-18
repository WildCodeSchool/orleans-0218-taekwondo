<?php
namespace Model\Form;

class Alert {
    const SESSION_KEY = 'LastFormResult';

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

    /**
     * Retrieve the $_SESSION form last result
     * @return Alert|null
     */
    public function fromSession()
    {
        $element = $_SESSION[self::SESSION_KEY] ?? null;
        return $element !== null ? unserialize($element) : $element;
    }

    /**
     * Define $_SESSION form last result
     * @return Alert
     */
    public function updateSession(): Alert
    {
        $_SESSION[self::SESSION_KEY] = serialize($this);
        return $this;
    }

    /**
     * Clean $_SESSION form last result
     * @return Alert
     */
    public function clearSession(): Alert
    {
        if (isset($_SESSION[self::SESSION_KEY]))
            unset($_SESSION[self::SESSION_KEY]);
        return $this;
    }
}