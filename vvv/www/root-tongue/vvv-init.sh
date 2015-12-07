# Init script for Root Tongue site

echo "Commencing WordPress latest stable Setup"

# Make a database, if we don't already have one
echo "Creating database (if it's not already there)"
mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS root_tongue_wp"

# Check for the presence of a `core` folder.
if [ ! -d core/wp-admin ]
then
    echo "Checking out WordPress SVN"
    # If `core/wp-admin` folder doesn't exist, check out WordPress
    # as that folder
    svn checkout http://svn.automattic.com/wordpress/tags/4.3.1 core
    # Use WP CLI to install WordPress
    wp core install --title="Root Tongue Dev Site" --admin_user=admin --admin_password=abc --admin_email=demo@example.com --allow-root
    # Use WP CLI to set the Root Tongue theme
    wp theme activate root-tongue --allow-root
else
    echo "Updating WordPress SVN"
    # If the `core` folder exists, then run SVN update
    svn up core
fi

# The Vagrant site setup script will restart Nginx for us

# Let the user know the good news
echo "Latest stable WordPress now installed at http://root-tongue.dev";
