-- Create the database
CREATE DATABASE IF NOT EXISTS event_booking;

USE event_booking;

-- Table: customers
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone_number VARCHAR(15) NOT NULL
);

-- Table: events
CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    event_type ENUM(
        'Wedding',
        'Birthday',
        'Corporate',
        'Other'
    ) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    guest_count INT NOT NULL,
    event_location TEXT NOT NULL,
    special_requests TEXT,
    package_selected ENUM(
        'Basic',
        'Standard',
        'Premium'
    ) DEFAULT 'Basic',
    budget DECIMAL(10, 2) DEFAULT NULL,
    booking_status ENUM(
        'Pending',
        'Confirmed',
        'Cancelled'
    ) DEFAULT 'Pending',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers (customer_id) ON DELETE CASCADE
);

-- Insert sample data for testing
INSERT INTO
    customers (name, email, phone_number)
VALUES (
        'John Doe',
        'john.doe@example.com',
        '1234567890'
    ),
    (
        'Jane Smith',
        'jane.smith@example.com',
        '0987654321'
    );

INSERT INTO
    events (
        customer_id,
        event_type,
        event_date,
        event_time,
        guest_count,
        event_location,
        special_requests,
        package_selected,
        budget,
        booking_status
    )
VALUES (
        1,
        'Wedding',
        '2024-12-15',
        '18:00:00',
        150,
        '123 Wedding Lane, Cityville',
        'Need floral decorations and catering.',
        'Premium',
        10000.00,
        'Confirmed'
    ),
    (
        2,
        'Birthday',
        '2024-12-20',
        '14:00:00',
        50,
        '456 Party Blvd, Townsville',
        'Theme: Superheroes',
        'Standard',
        3000.00,
        'Pending'
    );