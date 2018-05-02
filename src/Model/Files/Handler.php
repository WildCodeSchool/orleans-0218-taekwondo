<?php
namespace Model\Files;

class Handler {
    /** @var File[] */
    private $files = [];

    public function __construct(array $requestData)
    {
        if (is_array($requestData['name'])) $this->setFiles($requestData);
        else $this->setFile($requestData);

    }

    /**
     * Add multiple files to the list
     * @param array $files
     * @return Handler
     */
    private function setFiles(array $files): Handler
    {
        for ($i = 0; $i < count($files['name']); $i++) {
            $this->setFile([
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i]
            ]);
        }
        return $this;
    }

    /**
     * Add a file to the list
     * @param array $file
     * @return Handler
     */
    private function setFile(array $file): Handler
    {
        $this->files[] = new File(
            $file['name'],
            $file['type'],
            $file['tmp_name'],
            $file['error'],
            $file['size']
        );
        return $this;
    }

    /**
     * Return list of files
     * @return File[]
     */
    public function getFiles(): array { return $this->files; }
}
