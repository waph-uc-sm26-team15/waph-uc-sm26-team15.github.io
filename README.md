# README.md

## WAPH-Web Application Programming and Hacking

### Instructor: Dr. Phu Phung

# Team Project

## miniFacebook - Team 15

# Team members

1. Lucas Andrew, [mailto:andrewl2@mail.uc.edu](andrewl2@mail.uc.edu)

![Lucas's headshot](images/headshot_lucas_andrew.JPG)

2. Member 2, email
3. Member 3, email

# Project Management Information

Source code repository (private access): <https://github.com/waph-uc-sm26-team15/waph-teamproject>

Project homepage (public): <https://waph-uc-sm26-team15.github.io/index.html>

## Revision History

| Date       |   Version     |  Description |
|------------|:-------------:|-------------:|
| 07/19/2026 |  0.1          | Sprint 0 complete |
| 07/28/2026 |  0.2          | Sprint 1 complete |
| 08/05/2026 |  1.0          | Project complete  |


# Overview

For this project, we were tasked to create a miniFacebook. For this application, we were tasked to implement the following:
  - User registration
  - User login
  - User logout
  - User profile view
  - Ability to add posts
  - Ability to edit owned posts
  - Ability to delete owned posts
  - Ability to add comments to posts
  - Superuser login
  - Superuser logout
  - Ability to view registered users as a superuser
  - Ability to disable a registered user as a superuser
  - Ability to enable a previously disabled registered user as a superuser
  - Real-time chat between two logged-in users

Describe the overview of the project with a high-level architecture figure. 

# System Analysis

## High-level Requirements

The requirements for this project were divided into two categories: functional, and non-functional and security requirements.

### Functional Requirements

- Anyone can register for an account with an email as a username and password
- Registered users can:
  - Login
  - Change password
  - Edit their profile: including name, additional email and phone number
  - Add a new post
  - Edit and delete their own posts
  - View and add comments on any post
- Superusers can:
  - Login
  - Disable a registered user
  - Enable a registered user
- Logged in users can have real-time chat with others

### Non-functional Requirements

- The system must be deployed using HTTPS
- Passwords must be hashed in the database
- No MySQL root account can be used for PHP code
- All SQL must use prepared statements
- All input data must be validated in every layer
- HTML outputs must be sanitized
- Session authentication must be fully protected
- Prevent against CSRF attacks
- Role-based access control for registered users and superusers
- Integrate an open-source front-end CSS template
- A team project website

# System Design

## Use-Case Realization

There are two main use cases of our application- for registered users and superusers. Registered users have the ability to create posts and add comments, while also being able to edit and delete their own posts. Additionally, they are able to update their personal information and password. Superusers have the ability to view all registered users, enable and disable their accounts as appropriate. 

## Database 

The database design for this project included four distinct tables. These were:
- `users`
- `superusers`
- `posts`
- `comments`

Each user has the following fields:
- Username
- Password
- Name
- Email
- Phone number

Where the username is the primary key for a user entry.

Each superuser has the following fields:
- Username
- Password

Where the username is the primary key for a superuser entry.

Each post has the following fields:
- Post ID
- Title
- Content
- Date
- Owner

Where the post ID is the primary key for a post entry. Additionally, the owner of the post is a registered user and is a foreign key for a post entry.

Each comment has the following fields:
- Comment ID
- Post ID
- Content
- Date
- Owner

Where the comment ID is the primary key for a comment entry. Additionally, the post ID and the owner of the post are foreign keys for a comment.

## User Interface

The user interface of the application consists of multiple views.

For normal users, they are first presented a login screen from `from.php`. If they have credentials, they would use them to log into the miniFacebook application. If they do not have credentials, they can click a `Sign Up` link under the login form. This link takes them to `registrationform.php`, where they would enter in their username, name, email, phone number, and password twice (the second time for validation).

Once a normal user has logged in, they are directed to `index.php`. This page contains their profile information at the top, along with all posts and comments for each post. The user can also create a post. Additionally, they are presented with three links, `Profile Management`, `Change Password`, and `Logout`.

The `Profile Managment` link directs the user to a page called `profilemanagementform.php`, where they can update their name, email, or phone number. The `Change Password` link directs the user to a page called `changepasswordform.php`, where they can update their password. Finally, the `Logout` link logs the user out and directs them back to the login page, `form.php`.

Additionally, users can edit and delete their own posts. These options are presented under their own posts as links. The `Edit` link directs the user to `editpostform.php`, where they can edit the title or content of the post. The `Delete` link deletes the post by calling `deletepost.php` and reloading `index.php` after.

For superusers, they are presented a login screen from `admin/loginform.php`. Please note there is no superuser registration on purpose. A superuser must be directly added to the database. Once the superuser is logged in, they are directed to `admin/index.php`, where they can view a list of registered users. Superusers can also log out, where they are directed back to the superuser login page, `admin/loginform.php`.

# Security analysis

_Include a brief explanation of your implementation and the security aspects based on the following questions:_

*  How did you apply the security programming principles in your project?
*  What database security principles have you used in your project?
*  Is your code robust and defensive? How?
*  How did you defend your code against known attacks such as XSS, SQL Injection, CSRF, Session Hijacking
*   How do you separate the roles of super users and regular users?

We applied the security programming principles in our project by using prepared statements for all SQL, including CSRF protection in all files that interacted with the database, and sanitized inputs on both the user interface and code that processes the user input prior to calling into the database (XSS protection), and sanitizing html outputs.

We used the following database security principles in our project:
- Use of prepared statements for every database interaction
- Sanitization of inputs on both the front end and code that processes the user input

Our code is robust and defensive. We wrote reusable code that validates a user for any page they navigate to. If the user is unauthenticated, they will not be given access to the page. Additionally, we assumed that some users could provide malicous inputs, so we sanitized the inputs at every level possible. We even went as far as validating certain input's structure, such as emails needing to contain an `@` character and `.` (for `.com`, `.edu`, etc).

We defended our code against known attacks.
- For XSS, we sanitized all inputs from the front end and code that processes user inputs. Additionally, we sanitized any outputs our application displays to the user.
- For SQL Injection, we used prepared statements for every database interaction.
- For CSRF, we generated a random token on any form and validated it in the respective code that validates the form's submission. This prevents a user from directly calling the code that validates the form's submission.
- For Session Hijacking, we wrote common code that validates a user is logged in on every page that requires an authenticated user. Additionally, we also stored information about the authenticated user's browser in the event that someone attempts to hijack their session. In this case, session hijacking would be detected and the user would be logged out and directed back to `form.php`.

# Demo (screenshots)

_You need to capture screenshots to demonstrate how your web application works. The screenshots must be accompanied by a short description of its functionalities following the implementation as below:_

*   Everyone can register a new account and then login
*   Superuser can disable an account
    *   The disabled account cannot log in 
    *   Superuser can enable the disabled account
    *   The enabled user can log in	
*   A regular logged-in user can delete her own existing posts but cannot delete the posts of others
*   CSRF attack to delete a post should be detected and prevented
*   A regular logged-in user cannot access the link for superusers
*   A logged-in user can have a real-time chat with other logged-in users

User registration:

TODO

A regular logged-in user can delete their own existing posts but cannot delete the posts of others:

TODO

CSRF ttack to delete a post should be detected and prevented:

TODO

A regular logged-in user cannot access the link for superusers:

TODO

**Note:** We did not implement the following:
*   Superuser can disable an account
    *   The disabled account cannot log in 
    *   Superuser can enable the disabled account
    *   The enabled user can log in	
*   A logged-in user can have a real-time chat with other logged-in users

# Software Process Management

## Scrum process

### Sprint 0

Duration: 07/14/2026-07/21/2026

#### Completed Tasks: 

1. Create team SSL key/certificate
2. Set up HTTPS and team local domain name
3. Set up team database
4. Copied and modified login system from Lab 3 with Lab 4 requirements

    a. Screenshot of login system working from team's local HTTPS domain: 
    
    ![Login system working](images/login-system-working.png)

5. Implemented `index.html` page on HTTPS team's local domain

    a. Lucas's Screenshot of the completed task: 
    
    ![Lucas's Screenshot of the task](images/lucas-index-html.png)

#### Contributions: 

1. Lucas Andrew, 2 commits, 2 hours, contributed in creating team SSL key/certificate, set up HTTPS and team local domain name, copied and modified login system from Lab 3 with Lab 4 requirements to this project
2. Member 2, x commits, y hours, contributed in xxx
3. Member 3, x commits, y hours, contributed in xxx

### Sprint 1

Duration: 07/22/2026-07/28/2026

#### Completed Tasks: 

1. Implemented user registration and login
2. Implemented change password feature
3. Implemented edit profile information feature

#### Contributions: 

1. Lucas Andrew, 1 commits, 2 hours, contributed in implementing tasks 1-3.
2. Member 2, x commits, y hours, contributed in xxx
3. Member 3, x commits, y hours, contributed in xxx

### Sprint 2

Duration: 07/28/2026-08/05/2026

#### Completed Tasks: 

1. Implemented create post feature
2. Implemented edit post feature
3. Implemented delete post feature
4. Implemented add comment feature
5. Implemented superuser login
6. Implemented view all registered users as a superuser

#### Contributions: 

1. Lucas Andrew, 7 commits, 6 hours, contributed in implementing tasks 1-6.
2. Member 2, x commits, y hours, contributed in xxx
3. Member 3, x commits, y hours, contributed in xxx

#### Sprint Retrospection:

_(Introduction to Sprint Retrospection:

_Working through the sprints is a continuous improvement process. Discussing the completed sprint can improve the next sprint walk through a much more efficient one. Sprint retrospection is done once a sprint is finished and the team is ready to start another sprint planning meeting. This discussion can take up to 1 hour depending on the ideal team size of 4 members. 
Discussing good things that happened during the sprint can improve the team's morale, good team collaboration, appreciating someone who did a fantastic job solving a blocker issue, work well-organized, and helping someone in need. This will improve the team's confidence and keep them motivated.
As a team, we can discuss what has gone wrong during the sprint and come up with improvement points for the next sprints. Few points can be like, need to manage time well, need to prioritize the tasks properly and finish a task in time, incorrect design lead to multiple reviews and that wasted time during the sprint, team meetings were too long which consumed most of the effective work hours. We can mention every problem is in the sprint which is hindering the progress.
Finally, this meeting should improve your next sprint drastically and understand the team dynamics well. Mention the bullet points and discuss how to solve it.)_

| Good     |   Could have been better    |  How to improve?  |
|----------|:---------------------------:|------------------:|
|          |                             |                   |


# Appendix

Include the content (in text, not as images) of the SQL files and all source code of your PHP files (with the file name).