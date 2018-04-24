<?php
namespace Model\Files;

class Handler {
    private $requestData = [];
    /** @var File[] */
    private $files = [];

    public function __construct(array $requestData)
    {
        $this->requestData = $requestData;
        for ($i = 0; $i < count($requestData['name']); $i++) {
            $this->files[] = new File(
                $requestData['name'][$i],
                $requestData['type'][$i],
                $requestData['tmp_name'][$i],
                $requestData['error'][$i],
                $requestData['size'][$i]
            );
        }
    }

    /**
     * Return list of files
     * @return File[]
     */
    public function getFiles(): array { return $this->files; }
}
