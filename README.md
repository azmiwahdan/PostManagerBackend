
# PostManagerBackend

  PostManagerBackend is a Laravel-based backend application that provides RESTful APIs for user management, post creation, and comment management. It utilizes Laravel Sanctum for authentication and 
  MySQL database for data storage.
  
## Introduction

  PostManagerBackend is a backend application that serves as the API backend for a post-management system. It provides endpoints for user registration, login, and logout. Users can create posts,           manage their own posts, and comment on posts. Comments can also have replies.

## Features

   User registration and login with authentication using Laravel Sanctum.
   
   User logout to invalidate the authentication token.
   
   Post creation, updating, and deletion.
   
   Comment creation, updating, and deletion.

   Reply creation, updating, and deletion for comments.
   
   Secure authentication and authorization for API endpoints.
   
   Error handling and validation of user input.
   
## Installation
  To install and set up PostManagerBackend, follow these steps:
  Clone the repository to your local machine.
  
  Install the required dependencies by running the following command:

  composer install
  
  Configure the database connection by updating the .env file with your MySQL database credentials.
  
  Run the database migrations to create the required tables by executing the following command:
  
  php artisan migrate

 ### Start the development server by executing the following command:
    php artisan serve
### The API endpoints should now be accessible at http://localhost:8000.

## Usage
To use the PostManagerBackend APIs, you can utilize tools like Postman or any REST client.
Send requests to the defined endpoints with the required parameters and headers.

## Endpoints

The following are the main endpoints provided by the PostManagerBackend API:

POST /users/register: Register a new user.

POST /users/login: Log in as a user and obtain an access token.

POST /users/logout: Log out a user and invalidate the access token.

POST /posts: Create a new post.

PUT /posts/{postId}: Update a post.

DELETE /posts/{postId}: Delete a post.

POST /posts/{postId}/comments: Comment on a post.

PUT /posts/{postId}/comments/{commentId}: Update a comment.

DELETE /posts/{postId}/comments/{commentId}: Delete a comment.

POST /posts/{postId}/comments/{commentId}/replies: Reply to comment.



## Authentication

PostManagerBackend uses Laravel Sanctum for authentication. 
When a user logs in or registers, an access token is generated and returned in the response.
This access token must be included in the headers of subsequent requests to access protected endpoints.
