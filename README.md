# Laravel Messenger - DB final project

At 2022 spring semester, I selected the course: Principles of database design under supervision
of [Dr. shahriayari](https://ceit.aut.ac.ir/shahriari)
. <br>

As the final project of the course we were tasked to implement a chatting service similar to facebook messenger.

- authentication
- Users searching
- Invite to connection
- Blocking / unblocking other users
- Active session management
- message inbox
- Add / Remove from Connections list
- Like message
- Logging
- 3 time fail login throttle
- Delete account

## technical specs

In this project I have used:

- Php/Laravel: as the backend framework
- Laravel Jet-stream: as frontend scaffolding
- Vue3: as frontend framework
- Inertia.js: as server side rendering and server side routing
- tailwind css: as css framework
- mailgun api: as emailing service
- Laravel sail: for containerization of the project( uses docker under the hood)

## screenshots

![home page area](/app/laravel_messenger/documentation/screenshots/homepage.png "homepage area")
![register](/app/laravel_messenger/documentation/screenshots/register.png "register area")
![login](/app/laravel_messenger/documentation/screenshots/login.png "login area")
![dashboard](/app/laravel_messenger/documentation/screenshots/dashboard.png "dashboard")
![user-search](/app/laravel_messenger/documentation/screenshots/user-search.png "search")
![invites](/app/laravel_messenger/documentation/screenshots/invites.png "invites")
![connections](/app/laravel_messenger/documentation/screenshots/connections.png "connections")
![chat area](/app/laravel_messenger/documentation/screenshots/chat%20area.png "chat area")
![profile](/app/laravel_messenger/documentation/screenshots/profile.png "profile")
![user settings - 1](/app/laravel_messenger/documentation/screenshots/user-settings-area-1.png "settings 1")
![user settings - 2](/app/laravel_messenger/documentation/screenshots/user-settings-area-2.png "settings 2")

## Installation

In order to be able to run this project you must have these things installed on your local computer:

- docker
- laravel sail
- npm

The necessary steps are:

1. Clone the project
   To have project folder on your local machine.
    ```bash 
   $ git clone https://github.com/Noisyboy-9/laravel_messenger.git
   ```

2. create .env file
   Run the following command to create a new copy of .env.example file and name it .env:
    ```bash
   $ cp .env.example .env
   ```

3. generate project keys
   Run the following command to generate a project key:
    ```bash
   $ php artisan key:generate
    ```

4. Start external services
   As mentioned before this project uses laravel-sail for containerization so after installing laravel-sail run the
   following command to start services:
    ```bash
   $ /vendor/bin/sail up
   ```

5. Compile frontend assets
   this command starts a npm build process inside the application-container which your laravel project files sit:
    ```bash
   $ /vendor/bin/sail npm run watch 
   ```


