<?php
	/**
	* deklaracja nowej klasy .
	*/
	class ToDoList{
	
		/**
		* Zmienne globalne .
		*/
		protected $DataBase;
		public $query;
		public $stmt;
		
		/**
		* Konstruktor inicjujący bazę.
		*/
		public function __construct()
			{
				$this->DataBase = new PDO('sqlite:tododb.db');
				$this->DataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->DataBase->exec
				("CREATE TABLE IF NOT EXISTS todolist (
				ID INTEGER PRIMARY KEY AUTOINCREMENT, 
				task TEXT, 
				status INTEGER)");
			} 
		
		/**
		* Metoda wyświetlająca rekordy z bazy
		*/
			public function GetRows()
		{
			try{
				$this->query = ("select * from todolist");
				 $this->stmt = $this->DataBase->prepare($this->query);
				 $this->stmt->execute();
				 print '<ul id="todo-list" class="todo-list">';
      
				 while ($row = $this->stmt->fetch(PDO::FETCH_ASSOC))
					{
					print '<li ';
					if($row['status'] == "1") print 'class="done">'; else print ">";
					print '<div class="customcheckbox"><input style="color:green;" class="checkbox" onchange="chceck('.$row['ID'].')"'; if($row['status'] == "1")print "checked";
					print ' type="checkbox"/><label for="lblcheckbox"></label></div>';
					print $row['task'];
					print '<a class="trash" onclick="delete_row('.$row['ID'].');">';
					print '<img class="trash" ';
					if($row['status'] == "1") print 'src="../assets/img/trash_shadow.png"'; else print 'src="../assets/img/trash.png"';
					print '></li></a>';
					
					}	 
				 print '</ul>';
				}
			catch (PDOException $e)
				{
					throw new Exception($e->getMessage());
				}
			
		}

		/**
		* Metoda dodająca rekord do bazy
		*/
		public function SetRow($text)
		{
			try{
				$this->query = ("insert into todolist (task,status) VALUES (:task, 0)");
				$this->stmt = $this->DataBase->prepare($this->query);
				$this->stmt->bindValue(':task', $text, PDO::PARAM_STR);
				$this->stmt->execute();
				return true;
				
				}
			catch (PDOException $e)
				{
					throw new Exception($e->getMessage());
				}
			
		}
		
		/**
		* Metoda edytująca rekord
		*/
		public function EditRow($id, $status)
		{
			try{
				$this->query = ("update todolist set status = :status where id= :id");
				$this->stmt = $this->DataBase->prepare($this->query);
				$this->stmt->bindValue(':status', $status, PDO::PARAM_INT);
				$this->stmt->bindValue(':id', $id, PDO::PARAM_INT);
				$this->stmt->execute();
				return true;
				
				}
			catch (PDOException $e)
				{
					throw new Exception($e->getMessage());
				}
			
		}
		/**
		* Metoda usuwająca rekord z bazy
		*/
		public function DeleteRow($id)
		{
			try{
				$this->query = ("delete from todolist where id= :id");
				$this->stmt = $this->DataBase->prepare($this->query);
				$this->stmt->bindValue(':id', $id, PDO::PARAM_INT);
				$this->stmt->execute();
				return true;
				
				}
			catch (PDOException $e)
				{
					throw new Exception($e->getMessage());
				}
			
		}
				
	}
		
?>