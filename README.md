# my_movie_list
### Description
A website that lets you rank your favorite movies and shows a community ranking made from all the users lists combined.

### Images
![mymovielistHome](https://user-images.githubusercontent.com/88403974/233849729-365f643e-b4a2-489b-a760-d1973e322a89.png)
![mymovielistUser](https://user-images.githubusercontent.com/88403974/233849733-80d8568a-da69-4c44-aa6e-e0b0adfe8d6e.png)

### Technologies
I used HTML, CSS, PHP, MySQL and a bit of Javascript to make this website.

### Functionality
1. Sign up or login with an email and password.
2. The home page shows the community ranking, this ranking is made from all the users personal rankings.
3. The Users page lets users add or remove movies from thier list, as well as change the order of movies.

### Why
I created this project to learn about the basics of web development. I will also add it to my dev portfolio.

### Limitations
* There is no admin interface to add movies to the database.
* Since PHP was used for the backend, the database can only be updated if the page is refreshed. So this means the page gets refreshed after certain user actions.
* The user movies lists can have as many movies are the database has, if the database is large then the user page would need to have a limit implemented.
* There is no was to recovery or reset a password.
* There is no email verification.

### Database Structure
#### Movies Table
![image](https://user-images.githubusercontent.com/88403974/233851429-42aa7af4-00db-403c-8a09-ba65cdba552b.png)
#### User Table
![image](https://user-images.githubusercontent.com/88403974/233851477-27d0e461-44b0-4f0c-824e-793404bca2d0.png)
#### Ranking Table
![image](https://user-images.githubusercontent.com/88403974/233851504-d1f99e4d-cddd-466c-aa9f-52cfc8d8795f.png)
