## How to run this application?
#### Step:1
Clone this repo
```
git clone https://github.com/pranaycb/inventory-management-system-codeigniter4.git
```

#### Step:2
Install necessary dependencies using composer
```
composer install
```

#### Step:3
Copy env file and rename it with .env

#### Step:4
Login to your phpmyadmin and create a database and import the sql file (located inside the `database-file` directory). 
After then, open .env file and uncomment and change the following env variable with your own database configurations.
```
# database.default.hostname = localhost
# database.default.database = ci4
# database.default.username = root
# database.default.password = root
# database.default.DBDriver = MySQLi
# database.default.DBPrefix =
# database.default.port = 3306
```

#### Step:5
You also have to set the base url of your application. Uncomment and change the following env variable
```
# app.baseURL = ''
```

#### Step:6
Now run the following command to run your application.
After running the command you will receive a local url. Copy and paste the url in your browser and you will find your application up and running.
```
php spark serve
```

#### Step:7
To properly load all the css and js you need to add the url (found after running the serve command) in the base url env variable. Uncomment and change the following variable in .env file.
```
# app.baseURL = 'base url here'
```

Follow the Codeigniter4 documentation `https://codeigniter.com/user_guide/intro/index.html` for details.


### Need Help?
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

If you have any problem regarding the file please feel free to contact me via email pranaycb.ctg@gmail.com

Happy Coding 🤗🤗
