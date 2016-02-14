<html>
<head>
<title>Unit Test Results</title>
<style>
.resultTable {
	width: 100%;
	border:1px;
	border-color: black;
}
.EmptyTable {
	text-align:  center;
	font-weight: bold;
}
</style>
</head>
<body>
<h1> Unit Test Results</h1>
<table class="resultTable">
<tr>
	<th>Number</th>
	<th>Name</th>
	<th>Processing Time</th>
	<th>Result</th>
	<th>Errors</th>
</tr>
<?php 
if(count($rows)>0): 
	foreach($rows as $row): ?>
<tr>
	<td><?=$row['num'] ?></td>
	<td><?=$row['name'] ?></td>
	<td><?=$row['process_time'] ?></td>
	<td><?=boolean_convert($row['result']) ?></td>
	<td><?=$row['error_count'] ?></td>
</tr>
<?php endforeach;
	else: ?>
<tr>
	<td colspan="5" class="EmptyTable"> No Unit Tests Found </td>
</tr>
<?php
	endif;
 ?>
</table>
</body>
</html>
