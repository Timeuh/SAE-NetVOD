# SAE-NetVOD

## What's this project ?
The purpose of the project was to create a website that would do the same thing as a video streaming website. Which means streaming videos on a platform where people could stream series, add them as their favorites, continue a series where they left it etc.

## Components
To create the website, we used different programming languages : 
- **PHP**, to manage the users, series and episodes
- **HTML**, to display the different pages of the site
- **TailwindCSS**, which is a CSS framework to simplify customisation of the site (appearance)


For hosting, we use the University Webetu server, or a local Xampp server with : 
- **Apache**, for web server 
- **MariaDB**, for database

## How to use ?
This repository holds all necessary files to display NetVOD if you have  a web server for hosting : videos, images and website code for managing the site data. There is a **config.ini** file which is a template file for database connection. To use it, just take and modify this file with your database information. 


If you just want to see the result, you can go to https://webetu.iutnc.univ-lorraine.fr/www/brindejo2u/Index.php but you need to have a University of Lorraine account to access it.


Otherwise, once you install the site on your own, here’s a user’s guide : 

# 1. First steps
When you first go to the website, you have to choose between sign in (if you already have an account) or sign up (if you haven’t). 	

## 1.1. Registering
When you are a new user, you need to create an account where you indicate your email address (composed of the @ sign and a .com at the end) and a password. Then, you need to activate your account by clicking on the button located in the center of the screen. If you do not click on it right after your registration, you will not be able to activate later since the token to identify yourself will be lost and you will not be able to access this account. 

# 2. Connection
After your registration, or if you are already registered, you have to connect on the website by indicating the same information as when you created an account. Following these steps, you will successfully connect on the website and access many options to wander around the platform. Otherwise, you will be redirected to a page indicating that your informations are incorrect.

# 3. When connected
While connected to your account, you will have many options at your disposal. 
The main options are the following : 
- Access the catalog of series 
- Edit your profile
- Access your favorite series 
- Access your ongoing series 
- Disconnect

## 3.1. Access the catalog
In the catalog, there are all available series to watch. You can filter series by genre/public or sort the title by name/number of episodes/date of add. You can also search for a word and display all series having this word in their title. Obviously you can click on a series link and display it. On a serie’s page, you see all the serie’s details, you can display comments and add or remove the series from your favorites. If you click on an episode, it will start playing the video, and you will have the possibility to leave a comment on the series.

## 3.2. Edit your profile
In this section, you can see your current first name, name and favorite genre. You can modify those informations in the text boxes and click the button on the bottom to update those informations on the database. 

## 3.3. Access your favorite series 
The page is at the beginning a black screen since no series have been added to the list. However, when you go to a series, you can click on the button to add the series to the list.
After clicking on the button, the series will be added to the list. It is also possible to remove a series from the favorite list, by clicking on the button made for it in the show’s page.

## 3.4. Access you ongoing series
When you start watching a series, it is automatically added to your ongoing series. On this page, you have all your ongoing series’ links to continue watching. Just click on one and then on the episode you were watching.


## 3.5. Disconnect
Clicking on the disconnect button will end your session and put you back to the home page.


# Credits
## This website was created by :
 - Timothée Brindejonc
 - Ronan Cunin
 - Lancelot Doan
 - Noam Gomes-Odent
