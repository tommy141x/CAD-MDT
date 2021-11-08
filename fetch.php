<?php
include 'config.php';
$connect = mysqli_connect($dbHOST, $dbUSER, $dbPASS, $databaseName);
$output = '';
if (isset($_POST["query"])) {
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $query = "
	SELECT * FROM mdt_users
	WHERE username LIKE '%".$search."%'
	OR perm_id LIKE '%".$search."%'
	OR time_registered LIKE '%".$search."%'
	";
} else {
    $query = "
	SELECT * FROM mdt_users ORDER BY id";
}

function permCheck($num)
{
    if ($num == 0) {
        $rank = "User";
    } elseif ($num == 1) {
        $rank = "Supervisor";
    } elseif ($num == 2) {
        $rank = "Dept Director";
    } elseif ($num == 3) {
        $rank = "Admin";
    } else {
        $rank = "User";
    }
    return $rank;
}
$countb = 0;
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th>User</th>
							<th>Date Registered</th>
							<th>Admin Level</th>
							<th>Settings</th>
						</tr>';
    while ($row = mysqli_fetch_array($result)) {
        if ($countb < 5) {
          $name = strlen($row["username"]) > 9 ? substr($row["username"], 0, 9)."..." : $row["username"];
          $output .= '
			<tr>
				<td>'.$name.'</td>
				<td>'.$row["time_registered"].'</td>
                <td class="text-danger"> '.permCheck($row["perm_id"]).'</td>
                <td><a href="../account/index.php?steam_id='.$row["steam_id"].'"><button type="button" class="btn btn-danger">View</button></a></td>
			</tr>
		';
            $countb++;
        }
    }
    echo $output;
} else {
    echo '<label class="badge badge-danger" data-toggle="modal">No User Found</label>';
}
