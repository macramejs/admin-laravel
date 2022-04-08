    /**
     * Create a new file model from the uploaded file.
     *
     * @param UploadedFile $file
     * @param array $attributes
     * @return static
     */
    public static function createFromUploadedFile(UploadedFile $file, array $attributes = []): static;
    /**
     * Gets the url to the file.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Get the disk name of the file model.
     *
     * @return void
     */
    /**
     * Get the file path of the model.
     *
     * @return string|null
     */
    /**
     * Gets hhe filesystem for the model.
     *
     * @return FilesystemAdapter
     */