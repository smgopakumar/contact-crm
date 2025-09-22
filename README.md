CRM System (Laravel)

A simple CRM system built with Laravel to manage Contacts, Leads, and Accounts.
Contacts are automatically created when a Lead or Account is created using Event + Listener pattern.

Features

Create Leads and Accounts via API

Automatically create associated Contacts from Leads/Accounts

Extensible service-based architecture for adding new contact sources

Fully tested using PHPUnit (Feature tests)

Follows Laravel best practices, OOP, and design patterns

Requirements

PHP >= 8.1

Composer >= 2.x

MySQL / SQLite

Laravel >= 10.x

Node.js & NPM (if using front-end assets)

Installation

Clone the repository:

git clone <https://github.com/smgopakumar/contact-crm.git> crm-system
cd crm-system


Install dependencies:

composer install


Copy .env file:

cp .env.example .env


Configure database in .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm
DB_USERNAME=root
DB_PASSWORD=


Generate application key:

php artisan key:generate


Run migrations:

php artisan migrate

API Endpoints
1. Create a Lead

POST /api/leads

Body (JSON):

{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "9876543210"
}


Response: Lead object with nested contact created automatically.

2. Create an Account

POST /api/accounts

Body (JSON):

{
    "company_name": "ACME Ltd",
    "representative_name": "Alice Smith",
    "email": "alice@company.com",
    "phone": "1234567890"
}


Response: Account object with nested contact created automatically.

<!-- 3. List Contacts (Optional)

GET /api/contacts

Returns all contacts with their source (Lead/Account).

Running the Application

Start the development server:

php artisan serve --> This section is pending


The API will be available at http://127.0.0.1:8000.

Running Tests

This project includes Feature tests to verify:

Creating Leads/Accounts automatically creates Contacts.

Database records are correctly created.

Configure testing database in phpunit.xml:

<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>


Run tests:

php artisan test


<!-- You should see all tests passing. --> Regarding Testing also need to optmize again

Code Structure
app/
├── Events/             # LeadCreated, AccountCreated
├── Listeners/          # CreateContactFromLead, CreateContactFromAccount
├── Models/             # Lead, Account, Contact
├── Services/           # ContactService, LeadSourceService, AccountSourceService
└── Http/Controllers/   # LeadController, AccountController, ContactController

Extending the System

To add a new source (e.g., Opportunity):

Create a SourceService implementing ContactSourceInterface.

Create an Event for the source (e.g., OpportunityCreated).

Create a Listener to call ContactService.

Register the Listener in EventServiceProvider.

Assumptions

Contacts are auto-created only when Leads/Accounts are created.

Each source (Lead/Account) has at most one Contact.

Email is unique per Lead/Account.

Author

Gopakumar S M
Email: smgopu@gmail.com
