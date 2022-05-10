## BjerckeCMS

### PS: This project is still in development.

**Requirements:**

- Webserver with PHP 8.1 or higher.
- MySQL
- Node.js
- Composer

**Docker instructions:**

- For SSL, generate a self-signed certificate for the domain bjerckecms.localhost with mkcert and put the .pem files
  in /docker/php/ssl/.
- Modify ports in the compose file if needed.
- Run "docker compose up -d" to run the containers in detached mode.
- Remember to run "docker compose build" when applying changes to the containers.
- Access container terminals with "docker exec -it container_name bash".

**Step 1:** Start by running the following commands in the project root folder (not /html):

- npm install
- composer install

**Step 2:** In order for the assets to be compiled, you need to run one of the following commands:

- npm run build (this is the production build with compressed assets which will only run once)
- npm run watch (this is the development build with uncompressed assets, commonly used for development. It will run
  every time you save a file)

**Step 3:** Rename the file .env.example to .env and fill in the values for the SQL variables according to your
database.

**Docker settings for .env file:**
SQL_HOSTNAME=db SQL_USERNAME=bjerckecms SQL_PASSWORD=bjerckecms SQL_DATABASE=bjerckecms

**Step 4:** Create a database called bjerckecms.

**Step 5:** If you're not importing any SQL dumps, then you'll have to migrate with Doctrine. Run "php bin/console diff"
from the root directory, and then "php bin/console migrate". Use "php bin/console list" for a list of commands.

**Step 6:** Make sure that mod_rewrite module is enabled on your webserver.

### Success! You should now be able to access the website correctly.