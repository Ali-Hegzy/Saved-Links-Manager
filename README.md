# Saved Links Manager
A web site that helps you to manage your saved links.

## Features
- Authentication and Authorization
- Ability to create, delete, update links
- Ability to create `sites` to categorize each link to it's website
- Ability to create `inventories` to categorize each link as you want, for ex. links that belong to CS content, or links that talk about Database, and so on.

## Technologies
- **BackEnd** : Laravel
- **FrontEnd** : Blade, Tailwind, Alpine.js
- **DataBasw** : Sqlite

## Local Installation and Execution Steps
```bash
    git clone git@github.com:Ali-Hegzy/Saved-Links-Manager.git
    cd Saved-Links-Manager

    composer install
    npm install

    cp .env.example .env
    php artisan key:generate

    php artisan migrate

    # To run the project
    composer run dev
```

## License
This project is licensed under the MIT license.
