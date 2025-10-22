# ORM Implementation for Vehicles Database

This project implements an Object-Relational Mapping (ORM) solution for the `vehicles` database using Doctrine ORM. It provides a web interface for viewing and filtering vehicle data.

## Technologies Used

- **PHP 8.1+**
- **Doctrine ORM** - For database interaction and object-relational mapping
- **MySQL/MariaDB** - Database engine
- **Composer** - For dependency management

## Project Structure

```
vehicles-app/
├── config/
│   └── cli-config.php       # Configuration for Doctrine CLI
├── src/
│   ├── Entity/              # Database entity classes
│   │   ├── Car.php
│   │   ├── Manufacturer.php
│   │   ├── Model.php
│   │   └── Owner.php
│   ├── Repository/          # Custom repository classes
│   │   └── ModelRepository.php
│   └── bootstrap.php        # Database connection setup
├── public/
│   └── index.php            # Web interface
└── composer.json            # Dependencies
```

## Installation

1. Clone the repository
2. Install dependencies:
   ```
   composer install
   ```
3. Configure your database connection in `src/bootstrap.php`
4. Create and import the database:
   ```
   # Use the provided create.sql file to set up the database
   mysql -u username -p < create.sql
   ```
5. Start a PHP development server:
   ```
   php -S localhost:8000 -t public
   ```
6. Open your browser and navigate to `http://localhost:8000`

## Features

### Entity Relationships

The ORM implementation models these relationships:
- A **Manufacturer** has many **Models**
- A **Model** belongs to one **Manufacturer**
- A **Model** has many **Cars**
- An **Owner** has many **Cars**
- A **Car** belongs to one **Model** and optionally one **Owner**

### Query Implementation

The application implements the following queries:
1. **Select All Models with Manufacturer** - Retrieves all models with their respective manufacturer information
2. **Filter by Manufacturer** - Filters models by manufacturer name
3. **Filter by Model Name** - Filters models by model name
4. **Models with Owner Information** - Shows all models with related owner information where available

### Web Interface

The web interface provides:
- A list of all models with manufacturer information
- Filtering options by manufacturer and model name
- Option to view models with owner information
- Clean and responsive UI for data presentation

## Technologies Explanation

### Why Doctrine ORM?

Doctrine ORM was chosen for this project for several key reasons:

1. **Mature and Well-Supported**: Doctrine is one of the most mature and widely-used ORM libraries in the PHP ecosystem.
2. **Rich Feature Set**: It provides a complete set of features for mapping object models to relational databases.
3. **Database Abstraction**: Allows switching between different database systems with minimal code changes.
4. **Query Builder**: Provides an expressive API for building complex database queries.
5. **Repository Pattern**: Supports the repository pattern for organizing data access logic.
6. **Doctrine Query Language (DQL)**: Provides a powerful object-oriented alternative to SQL.

### Entity Mapping

The Entity classes use PHP 8's attribute-based mapping:

```php
#[ORM\Entity]
#[ORM\Table(name: "manufacturers")]
class Manufacturer
{
    // Entity properties and methods
}
```

This approach provides type-safe and IDE-friendly entity definitions compared to XML or YAML mappings.

### Repository Classes

Custom repository classes extend Doctrine's EntityRepository to encapsulate complex queries:

```php
class ModelRepository extends EntityRepository
{
    public function findAllWithManufacturers(): array
    {
        // Custom query implementation
    }
}
```

## Usage Examples

### Retrieving All Models with Manufacturers

```php
$modelRepository = $entityManager->getRepository(Model::class);
$models = $modelRepository->findAllWithManufacturers();
```

### Filtering Models by Manufacturer

```php
$models = $modelRepository->findByManufacturerName('Toyota');
```

### Finding Models with Owner Information

```php
$models = $modelRepository->findModelsWithOwners();
```

## Conclusion

This implementation demonstrates effective use of Doctrine ORM to model and query complex relationships in a vehicle database. The solution provides a clean separation of concerns between database entities, query logic, and the presentation layer.
