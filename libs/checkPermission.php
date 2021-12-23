<?php
    function checkPermission($conn, $role_id, $permission_id){
        
        $sql ="SELECT * FROM roles_permissions
        LEFT JOIN users ON users.role_id = roles_permissions.role_id
        WHERE users.role_id = $role_id
        AND roles_permissions.perm_id = $permission_id";
        
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($result);
        if ($rows == 0) {
            return false;
        } else {
            return true;
        };
    }
