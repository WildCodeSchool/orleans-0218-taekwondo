<?php
namespace Model\Ajax;

class Response {
    private $state;
    private $message;

    public function __construct(bool $state = false, string $message = '')
    {
        $this->state = $state;
        $this->message = $message;
    }

    public function getMessage(): string { return $this->message; }
    public function getState(): bool { return $this->state; }
    public function getJSON(): string
    {
        return json_encode([
            'state' => $this->state,
            'message' => $this->message
        ]);
    }

    public function isSuccess(): bool { return $this->state; }
    public function isError(): bool { return !$this->state; }

    public function setState(bool $state): Response
    {
        $this->state = $state;
        return $this;
    }

    public function setMessage(string $message): Response
    {
        $this->message = $message;
        return $this;
    }
}