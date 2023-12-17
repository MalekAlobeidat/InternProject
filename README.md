# InternProject
social media

InternProject is a group projected created by Malek Alobeidat, Mohammed Kayed, Omama Akour, Mohannad Ayman, Mohammed Thabteh, and Yasmeen Almoumani. The project replicates a variety of social networking websites and has the basic funcationalites of adding friends, creating posts, viewing feed, messaging, and more from the perspectives of a regular user, content creators, and admistrators. The system archeticture used within this project for frontend is ReactJS and for backend is Laravel.

The backlog for this project was created on Trello:
https://trello.com/invite/b/yK3z0vY6/ATTI1ea7ebdac9b7e187b962f44d144eb3de9C648857/social-media-platform

And the LinkedIn for the members of the group:
Malek Alobeidat:
Mohammed Kayed:
Omama Akour:
Mohannad Ayman:
Mohammed Thabteh:
Yasmeen Almoumani:

composer install

cp .env.example .env

php artisan key:generate


In .env 
DB_DATABASE=malek

php artisan migrate 

php artisan db:seed

