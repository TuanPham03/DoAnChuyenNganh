<?php
    function getAllServices(){
        $conn=connectdb();
        $sql = "SELECT * FROM services";
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;

    }
    function deleteServices($id){
        $conn=connectdb();
        $sql="DELETE  from services where id=".$id;
        $conn->exec($sql);
        return true;
    }
    
    function addServices($servicename,$price,$description){
        $conn = connectdb();
        $sql="INSERT into services(service_name,price,description) values('$servicename','$price','$description')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    function updateServices($id,$servicename,$price,$description){
        $conn = connectdb();
        $sql="UPDATE services set service_name='$servicename',price='$price',description='$description'  where id=".$id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    function getServicesbyId($id){
        $conn=connectdb();
        $sql = "SELECT * FROM services where id=".$id;
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;

    }
    function checkOldServices($servicename){
        $conn=connectdb();
        $sql="SELECT * from services where service_name='$servicename' ";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if($count > 0)
            return true;
        else 
            return false;
    }
    function searchService($search) {
        $conn = connectdb();
        $sql = "SELECT  * FROM services WHERE 
                service_name LIKE :search ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        $service = $stmt->fetchAll();
        return $service;
    }
?>