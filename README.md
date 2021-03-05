# JetChat

Hi!
JetChat is a messaging API.
## Details
the API has two functionalities:
it sends and receives messages.
data is stored in an SQLite database,
user authentication is done via username and password, each user has a hashed password token in the database.
the API communicates through sending and receiving JSON messages
 
## Assumptions
* only logged in users can send or receive messages.
* users cannot send messages to themselves.
* the API call can get the newest received messages based on a number that can be sent in the get request as a parameter, if not, the default is 50.
* the Id of the last read message can be determined in the request to get all the messages that has been sent after this message, if the Id is not sent in the request, the API will get all messages sent(with the limit).
* users cannot send messages to non existing users.
* users cannot send messages on behalf of other users or get messages with different receiver Id.
 

# Implementation Details

## Frameworks and tools
* Slim framework
* PHPstorm
* xampp
* postman for testing

## Architecture
the architecture used is MVC
### Models: 
* User model
* Message model
### Controllers:
* message controller
handles incoming requests
### Repositories:
* user repository
performs any user related database operations
* message repository
performs any message related database operations

## Database
the database used is sqlite, it has two tables
### Message table
contains message details:
* message id
* sender id
* receiver id
* date sent
* message content
### User table
contains user details:
* user id
* username
* hashed password token for verification

# API Manual 
## Requirements 
* PHP8
* SQLite
* Apache
* Composer
* slim
## Installation
run composer install in the root directory of the project.
make sure that the database directory in the config.php file is correct.
the database is already populated with users and some messages to make testing easier.
## API endpoints
authentication: basic authentication header (username and password)
### Get Messages
* /api/message/get/{userId}/{lastReadMessageId}/{limit}
*/api/message/get/{userId}/{lastReadMessageId}/
*/api/message/get/{userId}
where lastReadMessageId and limit are optional
* response: json object with the status code and messages
~~~
{"statusCode":"200","msg":[{"id":"2","content":"hiiiiiiiiii
again","sender_id":"1","receiver_id":"3","date_sent":"26-2-2021 20:10:12"},{"id":"3","content":"hi again
again","sender_id":"1","receiver_id":"3","date_sent":"26-2-2021 20:10:12"}]}
~~~
gets the messages of the current logged in user
### Send Message
* /api/message/send
* Request body:
~~~
{
   "message":[
      {
         "senderId":"1",
         "receiverId":"3",
         "dateSent":"28-2-2021 20:10:12",
         "messageContent":"test "
      }
   ]
}
~~~
* Response:
~~~
{"statusCode":"200","msg":"message sent"}
~~~

## Testing
### using postman, or any similar API client
* login with basic authentication, or send the authentication token in the request header of you're not using postman
current user info in the database:
  * username: reham pwd:123456aA id:1authorization token:  Basic cmVoYW06MTIzNDU2YUE=
  * username: coolCat pwd:123456 id:2 authorization token: Basic Y29vbENhdDoxMjM0NTY=
  * username: fuffyCat pwd:123654 id:3 authorization token: Basic Zmx1ZmZ5Q2F0OjEyMzY1NA==




