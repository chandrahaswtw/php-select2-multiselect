<?php
header('Content-Type: application/json');

use MS\DB;

$config = require(basePath("config/_db.php"));

$page =  $_GET["page"] ?? 1;
$searchTerm = $_GET["search"] ?? "";

$db = new DB($config);

$recordLimit = 30;
$offset = $recordLimit * ($page - 1);

//Fetch the records
$fetchRecordsQuery = "SELECT DISTINCT projects FROM random_data " . ($searchTerm ? "WHERE projects LIKE :searchTerm" : "")  . " LIMIT $recordLimit OFFSET $offset";
$fetchRecordsQueryParams = [];
if ($searchTerm) {
  $fetchRecordsQueryParams["searchTerm"] = "%$searchTerm%";
}

$fetchedRecords = $db->query($fetchRecordsQuery, $fetchRecordsQueryParams)->fetchAll();
$recordsCountQuery = "SELECT COUNT(DISTINCT projects) FROM random_data " . ($searchTerm ? "WHERE projects LIKE :searchTerm" : "");
//Fetch the records count
$recordCount = $db->query($recordsCountQuery, $fetchRecordsQueryParams)->fetchColumn();

$response = [
  "results" => [],
  "pagination" => ["more" => null]
];

foreach ($fetchedRecords as $record) {
  $response["results"][] = ["id" => $record["projects"], "text" => $record["projects"]];
}

$response["pagination"]["more"] = $recordCount > $page * 30;

echo json_encode($response);

/*
The return JSON should be of type as below:
{
  "results": [
    {
      "id": 1,
      "text": "Option 1"
    },
    {
      "id": 2,
      "text": "Option 2"
    }
  ],
  "pagination": {
    "more": true
  }
}
*/
