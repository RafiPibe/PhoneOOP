<?php

// classes
abstract class Device{
    abstract public function doSomething();
}

// "extends" -> inheritance
class MobilePhone extends Device {
    private $name;
    private $brand;
    private $price;
    private $stock;
    private $os;
    
    public function __construct($name, $brand, $price, $stock, $os = null) {
        $this->name  = $name;
        $this->brand  = $brand;
        $this->price  = $price;
        $this->stock  = $stock;
        $this->os     = $os;
    }

    // encapsulation
    // getter setter name
    public function setName($newName) {
        if (!is_string($newName)) {
            throw new InvalidArgumentException("Name must be a string");
        }
        $this->name = $newName;
    }

    public function getName() {
        return $this->name;
    }

    // getter setter brand
    public function setBrand($newBrand) {
        if (!is_string($newBrand)) {
            throw new InvalidArgumentException("Brand must be a string");
        }
        $this->brand = $newBrand;
    }

    public function getBrand() {
        return $this->brand;
    }

    // getter setter price
    public function setPrice($newPrice) {
        if (!is_numeric($newPrice) || $newPrice < 0) {
            throw new InvalidArgumentException("Price must be positive");
        }
        $this->brand = $newPrice;
    }

    public function getPrice() {
        return $this->price;
    }

    // getter setter stock
    public function setStock($newStock) {
        if (!is_numeric($newStock) || $newStock < 0) {
            throw new InvalidArgumentException("Stock must be positive");
        }
        $this->brand = $newStock;
    }

    public function getStock() {
        return $this->stock;
    }

    // getter setter os
    public function setOS($newOS) {
        if (!is_string($newOS)) {
            throw new InvalidArgumentException("OS must be a string");
        }
        $this->os = $newOS;
    }

    public function getOS() {
        return $this->os;
    }

    // Implementing doSomething method for inheritance
    public function doSomething() {
        echo "\nHello World from {$this->brand}, {$this->name}!\n";
    }
}

class MobileInventory {
    private $inventory;

    public function __construct() {
        $this->inventory = [];
    }

    // AddPhone function
    public function addPhone($name, $brand, $price, $stock, $os) {
        $phone = new MobilePhone($name, $brand, $price, $stock, $os);
        $this->inventory[] = $phone;
    }

    // Delete using $name
    public function deletePhone($name) {
        $this->inventory = array_filter($this->inventory, function ($phone) use ($name) {
            return $phone->getName() !== $name;
        });
    }

    // Update phone data by name
    public function updatePhone($name, $newPhoneData) {
        foreach ($this->inventory as $phone) {
            if ($phone->getName() === $name) {
                if (isset($newPhoneData['brand'])) {
                    $phone->setBrand($newPhoneData['brand']);
                }
                if (isset($newPhoneData['price'])) {
                    $phone->setPrice($newPhoneData['price']);
                }
                if (isset($newPhoneData['stock'])) {
                    $phone->setStock($newPhoneData['stock']);
                }
                if (isset($newPhoneData['os'])) {
                    $phone->setOS($newPhoneData['os']);
                }
                break;
            }
        }
    }

    public function callDoSomething($name) {
        foreach ($this->inventory as $phone) {
            if ($phone->getName() === $name) {
                $phone->doSomething();
                return true;
            }
        }
        return false; // Phone not found
    }

    // getter inventory
    public function getInventory() {
        return $this->inventory;
    }
}

// Create inventory
$inventory = new MobileInventory();

// // addPhone to inventory
// $inventory->addPhone("iPhone 13", "Apple", 1099, 10, "iOS");
// $inventory->addPhone("Samsung Galaxy S21", "Samsung", 999, 15, "Android");

// // deletePhone from inventory
// $inventory->deletePhone("iPhone 13");

// // UpdatePhone in inventory
// $newData = ['price' => 899, 'stock' => 20];
// $inventory->updatePhone("Samsung Galaxy S21", $newData);

// // Getting the current inventory
// $currentInventory = $inventory->getInventory();

// // List phone after deleting
// $currentInventory = $inventory->getInventory();
// echo "\nHere is the list of phones:\n\n";
// foreach ($currentInventory as $phone) {
//     echo "=============================\n" . "Name: " . $phone->getName() . "\n" . "Brand: " . $phone->getBrand() . "\n" . "Price: " . $phone->getPrice() . "\n" . "Stock: " . $phone->getStock() . "\n" . "Price: " . $phone->getOS() . "\n" . "=============================\n" . "\n";
// }

while (true) {
    echo "Menu:\n";
    echo "1. Add Phone\n";
    echo "2. Delete Phone\n";
    echo "3. Update Phone Data\n";
    echo "4. Display Inventory\n";
    echo "5. Call Message From Each Phone\n";
    echo "6. Exit\n";
    echo "Select an option: ";

    $choice = trim(fgets(STDIN)); // Read user input

    switch ($choice) {
        case '1':
            echo "Enter phone details:\n";
            echo "Name: ";
            $name = trim(fgets(STDIN));
            echo "Brand: ";
            $brand = trim(fgets(STDIN));
            echo "Price: ";
            $price = trim(fgets(STDIN));
            echo "Stock: ";
            $stock = trim(fgets(STDIN));
            echo "OS: ";
            $os = trim(fgets(STDIN));

            $inventory->addPhone($name, $brand, $price, $stock, $os);
            echo "Phone added to inventory.\n\n";
            break;

        case '2':
            echo "Enter the name of the phone to delete: ";
            $nameToDelete = trim(fgets(STDIN));

            if ($inventory->deletePhone($nameToDelete)) {
                echo "Phone deleted from inventory.\n\n";
            } else {
                echo "Phone not found in inventory.\n\n";
            }
            break;

        case '3':
            echo "Enter the name of the phone to update: ";
            $nameToUpdate = trim(fgets(STDIN));

            echo "Enter new phone data :\n";
            echo "Example: " . '{"brand": "Apple"}\n';
            $newPhoneData = json_decode(trim(fgets(STDIN)), true);

            $inventory->updatePhone($nameToUpdate, $newPhoneData);
            echo "Phone data updated.\n\n";
            break;

        case '4':
            $currentInventory = $inventory->getInventory();
            echo "\nCurrent Inventory:\n" . "=============================\n";
            foreach ($currentInventory as $phone) {
                echo "Name: " . $phone->getName() . "\n" . "Brand: " . $phone->getBrand() . "\n" . "Price: " . $phone->getPrice() . "\n" . "Stock: " . $phone->getStock() . "\n" . "Price: " . $phone->getOS() . "\n" . "=============================\n" . "\n";
            }
            break;

        case '5':
            echo "Enter the name of the phone to call: ";
            $callName = trim(fgets(STDIN));

            if ($inventory->callDoSomething($callName)) {
                echo "\n";
            } else {
                echo "Phone not found in inventory.\n";
            }
            break;

        case '6':
            echo "Exiting program.\n\n";
            exit;

        default:
            echo "Invalid option. Please try again.\n\n";
            break;
    }
}
