<?php

    class crudApp{
        private $conn;

        public function __construct()
        {
            #database host,database user, database pass, database name

            $dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass ="";
            $dbname = 'crud';

            $this->conn= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

            if(!$this->conn){
                die("Database Connection Error!!");
            }
            
        }



        public function add_data($data)
        {
            $s_name = $data['st_name'];
            $s_roll = $data['st_roll'];
            $s_image = $_FILES['st_img']['name'];
            $tmp_name = $_FILES['st_img']['tmp_name'];

           

            $query = "INSERT INTO students(std_name,std_roll,std_img) VALUE('$s_name',$s_roll,'$s_image')";
            
            if(mysqli_query($this->conn, $query)){
                move_uploaded_file($tmp_name, 'upload/'.$s_image);
                return "Information Successfully";
            }

        }
		
		
				/*
		  public function add_data($data)
        {
            $s_name = $data['st_name'];
            $s_roll = $data['st_roll'];
            $s_image = $_FILES['st_img']['name'];
            $tmp_name = $_FILES['st_img']['tmp_name'];

           if(!empty($s_name) && !empty($s_roll) && !empty($s_image)){
			     $query = "INSERT INTO students(std_name,std_roll,std_img) VALUE('$s_name',$s_roll,'$s_image')";
				 
			  if(mysqli_query($this->conn, $query)){
                move_uploaded_file($tmp_name, 'upload/'.$s_image);
                return "Information Successfully";
            }
				
			   
		   }else{
			echo "Field should not be empty";
			}  

        }
		
		
		*/


        public function display_data(){
            $query = "SELECT * FROM students";

            if(mysqli_query($this->conn, $query)){
                $returndata = mysqli_query($this->conn, $query);
                return $returndata;
           
            }
        } 


        public function display_data_by_id($id){
            $query = "SELECT * FROM students WHERE id=$id";

            if(mysqli_query($this->conn, $query)){
                $returndata = mysqli_query($this->conn, $query);
                $studentData = mysqli_fetch_assoc($returndata);
                return $studentData;
           
            }
        } 


        public function update_data($data){
            $sd_name = $data['u_st_name'];
            $sd_roll= $data['u_st_roll'];
            $idno = $data['std_id'];
            $sd_img = $_FILES['u_st_img']['name'];
            $tmp_name = $_FILES['u_st_img']['tmp_name'];

            $query ="UPDATE students SET std_name='$sd_name', std_roll=$sd_roll, std_img='$sd_img' WHERE id=$idno";

            if(mysqli_query($this->conn, $query)){
                move_uploaded_file($tmp_name, 'upload/'.$sd_img);
                return "Information Update Successfully!";
            }
        }



        public function delete_data($id){

          $catch_img = "SELECT * FROM students WHERE id=$id";
          $delete_std_info = mysqli_query($this->conn, $catch_img);
          $std_infodel = mysqli_fetch_assoc($delete_std_info);
          $deleteImg_data = $std_infodel['std_img'];

          $query = "DELETE FROM students WHERE id=$id";
          
          if(mysqli_query($this->conn, $query)){
              unlink('upload/'.$deleteImg_data);
              return "Deleted Successfully";
          }

        }

    

    }
    
?>