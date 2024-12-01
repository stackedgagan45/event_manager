<?php

// Fetch the Aiven MySQL connection URI from environment variables
$uri = getenv('DATABASE_URL'); // Set the DATABASE_URL environment variable in Render or your host

// Parse the URL to extract the components
$fields = parse_url($uri);

// Build the DSN for MySQL, including SSL options
$conn = "mysql:";
$conn .= "host=" . $fields["host"];
$conn .= ";port=" . $fields["port"];
$conn .= ";dbname=" . ltrim($fields["path"], '/'); // Remove leading '/' from the database name
$conn .= ";sslmode=verify-ca;sslrootcert=ca.pem"; // Ensure SSL connection

try {
    $db = new PDO($conn, $fields["user"], $fields["pass"]);

    // Test query to verify connection
    $stmt = $db->query("SELECT VERSION()");

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch customers
$customers = [];
$result = $db->query("SELECT * FROM customers");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

// Fetch events
$events = [];
$result = $db->query("SELECT * FROM events");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Close connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-gray-800 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
      <a href="#" class="text-lg font-bold">Event Extravaganza Dashboard</a>
      <div class="flex space-x-4">
        <a href="#" class="hover:text-yellow-400">Home</a>
        <a href="#" class="hover:text-yellow-400">Customers</a>
        <a href="#" class="hover:text-yellow-400">Events</a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container mx-auto mt-8 space-y-8">

    <!-- Customers Table -->
    <div>
      <h2 class="text-xl font-bold text-gray-700 mb-4">Customers</h2>
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="table-auto w-full text-left border-collapse">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-4 py-2 border">ID</th>
              <th class="px-4 py-2 border">Name</th>
              <th class="px-4 py-2 border">Email</th>
              <th class="px-4 py-2 border">Phone</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($customers as $customer): ?>
            <tr class="border-t">
              <td class="px-4 py-2 border"><?= htmlspecialchars($customer['customer_id']) ?></td>
              <td class="px-4 py-2 border"><?= htmlspecialchars($customer['name']) ?></td>
              <td class="px-4 py-2 border"><?= htmlspecialchars($customer['email']) ?></td>
              <td class="px-4 py-2 border"><?= htmlspecialchars($customer['phone_number']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Events Table -->
    <div>
      <h2 class="text-xl font-bold text-gray-700 mb-4">Events</h2>
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="table-auto w-full text-left border-collapse">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-4 py-2 border">Event ID</th>
              <th class="px-4 py-2 border">Customer ID</th>
              <th class="px-4 py-2 border">Event Type</th>
              <th class="px-4 py-2 border">Event Date</th>
              <th class="px-4 py-2 border">Guests</th>
              <th class="px-4 py-2 border">Location</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($events as $event): ?>
            <tr class="border-t">
              <td class="px-4 py-2 border"><?= htmlspecialchars($event['event_id']) ?></td>
              <td class="px-4 py-2 border"><?= htmlspecialchars($event['customer_id']) ?></td>
              <td class="px-4 py-2 border"><?= htmlspecialchars($event['event_type']) ?></td>
              <td class="px-4 py-2 border"><?= htmlspecialchars($event['event_date']) ?></td>
              <td class="px-4 py-2 border"><?= htmlspecialchars($event['guest_count']) ?></td>
              <td class="px-4 py-2 border"><?= htmlspecialchars($event['event_location']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white text-center p-4 mt-8">
    &copy; 2024 Event Extravaganza. All rights reserved.
  </footer>

</body>
</html>
