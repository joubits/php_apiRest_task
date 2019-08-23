<?php     
    class Task {
        //DB Stuff
        private $conn;
        private $table = 'tasks';
        //Post properties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;
        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }
        //Get Posts (more than one)
        public function read() {
            //create query
            $query = 'SELECT 
                    c.name as category_name,
                    t.id,
                    t.category_id,
                    t.title,
                    t.body,
                    t.author,
                    t.created_at
                FROM
                '  .$this->table. ' t
                
                LEFT JOIN
                    categories c ON t.category_id = c.id
                ORDER BY
                    t.created_at DESC';
                    
            // prepared statement
            $stmt = $this->conn->prepare($query);
            // execute query
            $stmt->execute();
            return $stmt;
            //return $query;
        }

        // Get one Post
        public function read_single() {
            // create query
            $query = 'SELECT 
                    c.name as category_name,
                    t.id,
                    t.category_id,
                    t.title,
                    t.body,
                    t.author,
                    t.created_at
                FROM
                '  .$this->table. ' t

                LEFT JOIN
                    categories c ON t.category_id = c.id

                WHERE
                    t.id = ?

                LIMIT 0,1';
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind
            $stmt->bindParam(1, $this->id);

            // Execute
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];

        }

        // Create Task
        public function create() {
            // query
            $query = 'INSERT INTO 
                        ' .$this->table. '
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id';
        

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            if(!$stmt->execute()){
                printf("Error: %s. \n", $stmt->error);
                return false;
            }

            return true;
        }

        public function update() {
            // query
            $query = 'UPDATE 
                        ' .$this->table. '
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
                WHERE
                    id = :id        
            ';
        

            // prepare statement
            $stmt = $this->conn->prepare($query);



            // Clean Data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);

            if(!$stmt->execute()){
                printf("Error: %s. \n", $stmt->error);
                return false;
            }

            return true;
        }

        public function delete() {
            // query
            $query = 'DELETE ' .$this->table. 'WHERE id = :id';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            
            // Bind data
            $stmt->bindParam(':id', $this->id);

            if(!$stmt->execute()){
                printf("Error: %s. \n", $stmt->error);
                return false;
            }

            return true;
        }



    }
?>