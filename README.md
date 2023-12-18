# InternProject
InternProject is a group project created by Malek Alobeidat, Mohammed Kayed, Omama Akour, Mohannad Ayman, Mohammed Thabteh, and Yasmeen Almoumani. The project replicates a variety of social networking websites and has the basic funcationalites of adding friends, creating posts, viewing feed, messaging, and more from the perspectives of a regular user, content creators, and admistrators. The system archeticture used within this project for frontend is ReactJS and for backend is Laravel.

The backlog for this project was created on Trello:
https://trello.com/invite/b/yK3z0vY6/ATTI1ea7ebdac9b7e187b962f44d144eb3de9C648857/social-media-platform

And the LinkedIn for the members of the group
Malek Alobeidat: https://www.linkedin.com/in/malek-alobeidat-717361251/
Mohammed Kayed: https://www.linkedin.com/in/mohammad-kayed-b708bb290/
Omama Akour: https://www.linkedin.com/in/omama-akour-426476267/
Mohannad Ayman: https://www.linkedin.com/in/mohannad-ayman-2bba5419a/
Mohammed Thabteh: https://www.linkedin.com/in/mohammdkhaled/
Yasmeen Almoumani: https://www.linkedin.com/in/yasmeen-almoumani-544a35214/



composer install

cp .env.example .env

php artisan key:generate


In .env 
DB_DATABASE=malek

php artisan migrate 

php artisan db:seed

