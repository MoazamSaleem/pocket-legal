<?php

class Document {
    private $conn;
    private $table_name = "documents";

    public $id;
    public $user_id;
    public $filename;
    public $original_name;
    public $file_path;
    public $file_size;
    public $mime_type;
    public $status;
    public $ai_processed;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create document record
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET user_id=:user_id, filename=:filename, original_name=:original_name, 
                      file_path=:file_path, file_size=:file_size, mime_type=:mime_type, 
                      status=:status";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->filename = htmlspecialchars(strip_tags($this->filename));
        $this->original_name = htmlspecialchars(strip_tags($this->original_name));
        $this->file_path = htmlspecialchars(strip_tags($this->file_path));

        // Bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":filename", $this->filename);
        $stmt->bindParam(":original_name", $this->original_name);
        $stmt->bindParam(":file_path", $this->file_path);
        $stmt->bindParam(":file_size", $this->file_size);
        $stmt->bindParam(":mime_type", $this->mime_type);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Get user documents
    public function getUserDocuments($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE user_id = :user_id 
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get document by ID
    public function getById($id, $user_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id = :id AND user_id = :user_id 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Delete document
    public function delete($id, $user_id) {
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":user_id", $user_id);

        return $stmt->execute();
    }

    // Update AI processing status
    public function updateAIStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " 
                  SET ai_processed = :status 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>