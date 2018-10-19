<p><a href="index.php" title="Back home">Back home</a></p>

<?php
include_once("scheduler/scheduler.php");

$sc = new ScheduleClient();

// Use this function once (to populate database with dummy values)
// Then comment it
$sc->seed();

echo "<br><br>";
echo "-----------------";
echo "<br>";
echo "TESTING";
echo "<br>";
echo "-----------------";
echo "<br><br>";


// Get allocation with req 5
$allocation = $sc->get_allocation(5);
echo "Single allocation details:<br>";
echo "ID: " . $allocation->request_id . "<br>";
echo "Agent Name: " . $allocation->agent_name . "<br>";
echo "Email: " . $allocation->agent_email . "<br>";
echo "Phone: " . $allocation->agent_phone . "<br>";
echo "Start Time: " . $allocation->pool_start_time . "<br>";
echo "End Time: " . $allocation->pool_end_time . "<br>";
echo "<br><br>";


// Get all allocations
$allocations = $sc->get_allocations();
echo "All allocations: <br><br>";
foreach ($allocations as $allocation) {
	echo "Pool ID: " . $allocation->pool_id . "<br>";
	echo "Start time: " . $allocation->pool_start_time . "<br>";
	echo "End time: " . $allocation->pool_end_time . "<br>";
	echo "Agent Name: " . $allocation->agent_name . "<br>";
	echo "Agent Email: " . $allocation->agent_email . "<br>";
	echo "Agent Phone: " . $allocation->agent_phone . "<br>";
	echo "Status: " . $allocation->status . "<br>";
	echo "<br>";
}
?>