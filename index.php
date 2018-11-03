<?php

#VT
$db = new PDO("mysql:host=localhost;dbname=api;charset=utf8","root","");
$tablename = "todo";

#FUNC
function input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if (isset($_GET["api_key"])) {
	$api_key = input($_GET["api_key"]);

	if ($api_key == "cyprs") {
		// API KEY TRUE

		if (isset($_GET["getall"])) {
			$fetch_all = $db->prepare("SELECT * FROM $tablename");
	        $fetch_all->execute();
	        
	        $fetch = array();
	        
	        while($row=$fetch_all->fetch(PDO::FETCH_ASSOC)){
	            $fetch['jsondata'][] = $row;
	        }
	        
	        echo json_encode($fetch);
		}
		if (isset($_GET["get_status_one"])) {
			$fetch_all = $db->prepare("SELECT * FROM $tablename WHERE status = 1");
	        $fetch_all->execute();
	        
	        $fetch = array();
	        
	        while($row=$fetch_all->fetch(PDO::FETCH_ASSOC)){
	            $fetch['jsondata'][] = $row;
	        }
	        
	        echo json_encode($fetch);
		}
		if (isset($_GET["getone_id"])) {
			$getone_id = input($_GET["getone_id"]);

			$getone_id_fetch = $db->prepare("SELECT * FROM $tablename WHERE id = '$getone_id'");
	        $getone_id_fetch->execute();
	        
	        $fetch = array();
	        
	        while($row=$getone_id_fetch->fetch(PDO::FETCH_ASSOC)){
	            $fetch['jsondata'][] = $row;
	        }
	        
	        echo json_encode($fetch);
		}
		if (isset($_GET["getone_name"])) {
			$getone_name = input($_GET["getone_name"]);

			$getone_name_fetch = $db->prepare("SELECT * FROM $tablename WHERE name = '$getone_name'");
	        $getone_name_fetch->execute();
	        
	        $fetch = array();
	        
	        while($row=$getone_name_fetch->fetch(PDO::FETCH_ASSOC)){
	            $fetch['jsondata'][] = $row;
	        }
	        
	        echo json_encode($fetch);
		}
		if (isset($_GET["update_status_id"])) {
			$update_status_id = input($_GET["update_status_id"]);
			$update = $db->prepare("UPDATE $tablename SET status = ? WHERE id = ?");
			$update->execute(array("1", $update_status_id));

			$update_select = $db->prepare("SELECT * FROM $tablename WHERE id = $update_status_id");
	        $update_select->execute();
	        
	        $fetch = array();
	        
	        while($row=$update_select->fetch(PDO::FETCH_ASSOC)){
	            $fetch['jsondata'][] = $row;
	        }

	        echo json_encode($fetch);
		}
		if (isset($_GET["delete_id"])) {
			$delete_id = input($_GET["delete_id"]);

			$delete = $db->exec("DELETE FROM $tablename WHERE id = $delete_id");

			echo "true";
		}
		if (isset($_GET["name"])) {
            $name = input($_GET["name"]);

            $query = $db->prepare("INSERT INTO $tablename (name) VALUES (?)"); 
            $query->execute(array($name));
            
            echo "Success";
		}

	}else {
		echo "API KEY!";
	}
}else {
	echo "API KEY!";
}
?>